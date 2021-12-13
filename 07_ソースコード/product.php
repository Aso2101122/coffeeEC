<?php
session_start();
require("./dbmanager.php");
$pdo = getDb();


if (isset($_GET['category'])) {
    //カテゴリ別で商品を取得
    $category = $_GET['category'];
    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url from m_items where category_id=?');
    $sql->bindValue(1,$category);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
} else if (isset($_GET['keyword'])){
    //検索用処理
    $keyword = $_GET['keyword'];
}

$pdo= null;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee：商品一覧</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/list-style.css">
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
</head>

<body>
<?php require 'global-menu.php'; ?>
<div class="main-content">
    <div class="headder">
        <?php
        if($_GET['category'] === '01'){
            echo '<img src="./img/item-list_beans-header_img.png" class="headder-img">';
        }else if($_GET['category'] === '02'){
            echo '<img src="./img/item-list_utensils-header_img.png" class="headder-img">';
        }
        ?>
    </div>

    <div class="sort">
        <span class="display">表示順:<span>
        <span class="example">
            <select name="example" class="sort-select">
                <option value="人気順">人気順</option>
            </select>
        </span>
    </div>
    <hr class="line">
    <?php
    $count = count($result);
    if ($count === 0){
        echo '<div class="not-find">該当する商品がありません</div>';
    } else {
        for ($i=0; $i < $count; $i+=4){
            echo '<div class="item-row">';
            for ($j=0; $j < 4; $j++){
                echo '<div class="merchandises">';
                echo '<a href="item-detail.php?id='.$result[$j+$i]['item_id'].'" class="item-link">';
                echo '<img src="./img/item-img/'.$result[$j+$i]['item_img_url'].'" class="item-img">';
                echo '<div class="info">';
                echo '<span>'.$result[$j+$i]['item_name'].'</span><br>';
                echo '<div class="price">';
                echo '<span>'.$result[$j+$i]['price'].'(税込)</span>';
                echo '</div>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
                if($j+$i == $count-1){
                    break;
                }
            }
            echo '</div>';

        }
    }

    ?>
</div>
</body>

</html>