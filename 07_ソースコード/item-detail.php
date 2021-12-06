<?php
require("./dbmanager.php");
$pdo = getDb();

if (isset($_GET['id'])) {
    //商品idをGETでを取得
    $item_id = $_GET['id'];
    //データベースから必要な情報を検索
    $sql = $pdo->prepare('SELECT * FROM m_items, m_country WHERE m_items.country_id = m_country.country_id AND item_id =? AND private_flag =0');
    $sql->bindValue(1,$item_id);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
//    echo '<p><pre>';
//    print_r($result);
//    echo '</pre></p>';
}else{
    echo '<p>該当する商品が見つかりませんでした。</p>';
}

$pdo= null;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee:<?= $result[0]['item_name']?></title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/item-detail.css">
</head>
<body>
    <?php require './global-menu.php'; ?>
    <div class="main-content">
        <div class="item-detail">
            <div class="main-left">
                <div class="merchandise1">
                    <div class="item-name1">
                        <h1><?= $result[0]['item_name']?></h1>
                    </div>

                    <img src="img/item-img/<?= $result[0]['item_img_url']?>" class="beans1">
                </div>
                <div class="origin">
                    <a href="./product.php?country=<?= $result[0]['country_id']?>" class="country-button">生産国:<?= $result[0]['country_name']?>
                        <img src="img/country-flag_img/<?= $result[0]['country_img_url']?>" class="flag-img">
                    </a>
                </div>
                <h2 class="letter3">参考記事</h2>
                <div class="drip">
                    <a href="">
                        <img src="img/index_reference-page_bn.png"/>
                        <div class="page-title">
                            コーヒーの淹れ方と必要な道具
                        </div>
                    </a>
                </div>
            </div>
            <div class="main-right">
                <div class="merchandise3">
                    <div class="name">
                        <h2><?= $result[0]['item_name']?></h2>
                        <a><?= $result[0]['price']?>( 税込 )</a>
                        <p class="point">+<?= $result[0]['point']?>ポイント</p>
                    </div>
                    <div class="chart">
                        <canvas id="myRadarChart"></canvas>
                    </div>
                    <div class="main-explanation">
                        <p class="explanation">
                            <?= $result[0]['item_description']?>
                        </p>
                    </div>
                    <form action="" method="post">
                        <span class="many-gram">グラム数</span>
                        <select name="gram">
                            <?php
                            for($i=1; $i<=5; $i++){
                                echo '<option value="',$i*100,'"">'.$i*100,'</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <input type="nummber" value="1" name="many" class="many"/>
                        <span>個</span>
                        <button class="orde">
                            <img src="./img/cart_cart_icon.png" class="cart-image"/>
                            カートに入れる
                        </button>
                        <br>
                        <button class="favorite">💛 お気に入り</button>
                    </form>
                </div>
            </div>
        </div>
        <span class="recommendation">入門者におすすめのコーヒー</span>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <script src="js/rader-chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</body>
</html>

