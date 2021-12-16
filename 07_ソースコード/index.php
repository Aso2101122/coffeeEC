<?php
session_start();
require("./dbmanager.php");
$pdo = getDb();
$sql = $pdo->prepare('select i.item_id , i.item_name, i.price, i.item_img_url ,sum(quantity) as seles_count from m_items i left outer join t_order_detail o on i.item_id = o.item_id where category_id = 01 group by i.item_id order by seles_count desc;');
$sql->execute();
$result = $sql->fetchALL(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index-style.css">
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <?php require './global-menu.php' ?>
    <div class="main-content">
        <img src=".\img\index_title_01.png" class="page-img">
        <h1><span class="heading">コーヒー豆を選ぶ</span></h1>
        <div class="chooseCoffee">
            <div class="recommend">
                <a href="./product.php?recommend=1">
                    <img src="img/index_recommend_bn.png"><br>
                    <div class="text">入門者におすすめのコーヒー豆</div>
                </a>
            </div>
            <div class="chooseByOrigin">
                <a href="./coffee-world-map.php">
                    <img src="img/index_world-map_bn.png"><br>
                    <div class="text">産地でコーヒー豆を選ぶ</div>
                </a>
            </div>
        </div>
        <h1><span class="heading">コーヒー基礎知識</span></h1>
        <div class="coffeedrip">
            <a href="./reference-page.php">
                <img src="img/index_reference-page_bn.png" class="drip-img">
                <div class="text">コーヒーの淹れ方と必要な道具</div>
            </a>
        </div>
        <h1 class="rank"><span>RANKING</span></h1>
        <p class ="selling">売れ筋商品</p>
        <?php
        echo '<div class="ranking">';
        for ($i=0; $i < 5; $i++){
            echo '<div class="merchandise">';
                echo '<a href="item-detail.php?id='.$result[$i]['item_id'].'" class="item-link">';
                echo '<img src="./img/item-img/'.$result[$i]['item_img_url'].'" class="item-img">';
                echo '<div class="info">';
                    echo '<span>'.$result[$i]['item_name'].'</span><br>';
                    echo '<div class="price">';
                        echo '<span>'.$result[$i]['price'].'円(税込)</span>';
                    echo '</div>';
                echo '</div>';
            echo '</a>';
        echo '</div>';
        }
        echo '</div>';
        ?>
        <button class="merchandise-button" onclick="location.href='./product.php?rank=1'">人気商品をもっと見る<img src="img/yazi3.png" class="arrow-img-black"></button>
    </div>
</body>

</html>