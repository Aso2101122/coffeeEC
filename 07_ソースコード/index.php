<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index-style.css">
</head>

<body>
    <?php require './global-menu.php' ?>
    <div class="main-content">
        <img src=".\img\index_title_01.png" class="page-img">
            <h1>コーヒー豆を選ぶ</h1>
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
            <h1>コーヒー基礎知識</h1>
        <div class="coffeedrip">
            <a href="">
                <img src="img/index_reference-page_bn.png" class="drip-img">
                <div class="text">コーヒーの淹れ方と必要な道具</div>
            </a>
        </div>
        <h1>RANKING</h1>
        <p>売れ筋商品</p>
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
        <button class="merchandise-button">人気商品をもっと見る</button>
    </div>
</body>

</html>