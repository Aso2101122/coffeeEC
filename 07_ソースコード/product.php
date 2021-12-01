<?php
require("./dbmanager.php");
$pdo = getDb();


if (isset($_GET['category'])) {
    //カテゴリ別で商品を取得
    $category = $_GET['category'];
    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url from m_items where category_id=?');
    $sql->bindValue(1,$category);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>商品一覧：Biginners coffee</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/list-style.css">
</head>

<body>
<?php require 'global-menu.php'; ?>
<div class="main-content">
    <img src="./img/item-list_beans-header_img.png" class="beans-header" >
    <span class="display">表示順:<span>
    <span class="example">
        <select name="example">
            <option value="人気順">人気順</option>
        </select>
    </span>
    <?php
    $count = count($result);
    for ($i=0; $i < $count; $i+=4){
    echo '<div class="item-row">';
        for ($j=$i; $j < 4; $j++){
            echo '<div class="merchandises">';
                echo'<img src="./img/item-img/'.$result[$j]['item_img_url'].'" class="item-img">';
                echo '<div class="info">';
                    echo '<span>'.$result[$j]['item_name'].'</span><br>';
                    echo '<span class="price">'.$result[$j]['price'].'(税込)</span>';
                echo '</div>';
            echo '</div>';
            if($j == $count-1){
                break;
            }
        }
        echo '</div>';
    }
    ?>
</div>
</body>

</html>