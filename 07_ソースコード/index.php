<?php
session_start();
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
        <?php
            echo '<pre>';
            echo print_r($_SESSION['user']);
            echo '</pre>';
            echo '<pre>';
            echo print_r($_SESSION['cart']);
            echo '</pre>';
        ?>
        <img src=".\img\index_title_01.png" class="page-img">
        <h1><span class="heading">コーヒー豆を選ぶ</span></h1>
        <div class="chooseCoffee">
            <div class="recommend">
                <a href="">
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
            <a href="">
                <img src="img/index_reference-page_bn.png" class="drip-img">
                <div class="text">コーヒーの淹れ方と必要な道具</div>
            </a>
        </div>
        <h1 class="rank"><span>RANKING</span></h1>
        <p class ="selling">売れ筋商品</p>
        <div class="ranking">
            <div class="merchandise">
                <img src="img/index_item_image.png">
                <a>商品名</a>
                <a>￥300</a>
            </div>
            <div class="merchandise">
                <img src="img/index_item_image.png">
                <a>商品名</a>
                <a>￥300</a>
            </div>
            <div class="merchandise">
                <img src="img/index_item_image.png">
                <a>商品名</a>
                <a>￥300</a>
            </div>
            <div class="merchandise">
                <img src="img/index_item_image.png">
                <a>商品名</a>
                <a>￥300</a>
            </div>
            <div class="merchandise">
                <img src="img/index_item_image.png">
                <a>商品名</a>
                <a>￥300</a>
            </div>
        </div>
        <button class="merchandise-button">人気商品をもっと見る<img src="img/yazi3.png" class="arrow-img-black"></button>
    </div>
</body>

</html>