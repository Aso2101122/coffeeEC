<?php
session_start();
require("./dbmanager.php");
$pdo = getDb();

//検索文言保存
$word = '';

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
    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url from m_items where item_name LIKE "%'.$keyword.'%"');
    $sql->execute();
    //エリア検索
    $result_item = $sql->fetchALL(PDO::FETCH_ASSOC);
    $sql = $pdo->prepare('select i.item_id, item_name, i.price, i.item_img_url , c.area_id from m_items i,m_country c, m_area a where i.country_id = c.country_id AND c.area_id = a.area_id AND a.area_name LIKE "%'.$keyword.'%"');
    $sql->bindValue(1,$keyword);
    $sql->execute();
    $result_area = $sql->fetchALL(PDO::FETCH_ASSOC);
    //国名検索
    $sql = $pdo->prepare('select i.item_id, item_name, i.price, i.item_img_url , c.area_id from m_items i,m_country c where i.country_id = c.country_id AND c.country_name LIKE "%'.$keyword.'%"');
    $sql->bindValue(1,$keyword);
    $sql->execute();
    $result_country = $sql->fetchALL(PDO::FETCH_ASSOC);
    $result = array_merge($result_item, $result_area, $result_country);
    $resultcount = count($result);

    $word = $keyword;
} else if (isset($_GET['country'])){
    //国idで検索
    $country_id = $_GET['country'];
    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url from m_items where country_id=?');
    $sql->bindValue(1,$country_id);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
    $resultcount = count($result);
    $sql = $pdo->prepare('select country_name from m_country where country_id = ?');
    $sql->bindValue(1,$country_id);
    $sql->execute();
    $country_name = $sql->fetchALL(PDO::FETCH_ASSOC);
    $word = $country_name[0]['country_name'];
} else if(isset($_GET['area'])){
    //エリアidで検索
    $area_id = $_GET['area'];
    $sql = $pdo->prepare('select i.item_id, item_name, i.price, i.item_img_url , c.area_id from m_items i,m_country c, m_area a where i.country_id = c.country_id AND c.area_id = a.area_id AND c.area_id = ?;');
    $sql->bindValue(1,$area_id);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
//    表示用の国名を取得
    $sql = $pdo->prepare('select country_name from m_country where country_id = ?');
    $sql->bindValue(1,$area_id);
    $sql->execute();
    $area_name = $sql->fetchALL(PDO::FETCH_ASSOC);
    $word = $area_name[0]['area_name'];
    $resultcount = count($result);
} else if(isset($_GET['recommend'])){
    //おすすめを表示
    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url from m_items where featured_flag=1');
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
    $resultcount = count($result);
    $word = '入門者におすすめ';
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
    <?php
    if(isset($_GET['category'])){
        echo '<div class="headder">';
        if($_GET['category'] === '01'){
            echo '<img src="./img/item-list_beans-header_img.png" class="headder-img">';
        }else if($_GET['category'] === '02'){
            echo '<img src="./img/item-list_utensils-header_img.png" class="headder-img">';
        }
        echo '</div>';
    }else{
        echo '<div class="heading-search">';
        echo '<span class="heading">'.$word.'の検索結果</span>';
        echo '<span class="search-count">（'.$resultcount.'件）</span>';
        echo '</div>';
    }
    ?>
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
        echo '<div class="item-container">';
        for ($i=0; $i < $count; $i+=4){
            echo '<div class="item-row">';
            for ($j=0; $j < 4; $j++){
                echo '<div class="merchandises">';
                echo '<a href="item-detail.php?id='.$result[$j+$i]['item_id'].'" class="item-link">';
                echo '<img src="./img/item-img/'.$result[$j+$i]['item_img_url'].'" class="item-img">';
                echo '<div class="info">';
                echo '<span>'.$result[$j+$i]['item_name'].'</span><br>';
                echo '<div class="price">';
                echo '<span>'.$result[$j+$i]['price'].'円(税込)</span>';
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
        echo '</div>';
    }

    ?>
</div>
</body>

</html>