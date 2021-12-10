<?php
session_start();
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





$user_id = null;
$item_id = null;

if(isset($_POST['insert']))






$favorite_flag = null;
//お気に入り情報取得
if(isset($_SESSION['user']['user_id'])){
    $user_id = $_SESSION['user']['user_id'];
    $item_id = $result[0]['item_id'];
    $sql = $pdo->prepare('SELECT * FROM t_favorite_items WHERE user_id=? AND item_id=?');
    $sql->bindValue(1,$user_id);
    $sql->bindValue(2,$item_id);
    $sql->execute();
    if($sql->rowCount() >= 1){
        $favorite_flag = true;
    }else{
        $favorite_flag = false;
    }

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
        <?php
        //ポスト送信パラメーターチェック
        $p_action=null; $p_method=null; $p_item_id=null; $p_user_id=null;
        print("<div class='checkMsg'>POSTパラメータ：");
        echo $_POST['method'];
        echo $_POST['item_id'];
        echo $_POST['user_id'];
//            if(isset($_POST['method'])){ if($_POST['method']!=""){ $p_method = $_POST['method']; print("ポストメソッド： ".$p_method);} }
//            if(isset($_POST['item_id'])){ if($_POST['item_id']!=""){ $p_item_id = $_POST['item_id']; print("アイテムID： ".$p_item_id); } }
//            if(isset($_POST['user_id'])){ if($_POST['user_id']!=""){ $p_user_id = $_POST['user_id']; print("ユーザーID： ".$p_user_id); } }
            print("</div>");
        ?>
        <div class="item-detail">
            <div class="main-left">
                <div class="merchandise1">
                    <h1>
                        <div class="item-name1"><?= $result[0]['item_name']?></div>
                    </h1>
                    <img src="img/item-img/<?= $result[0]['item_img_url']?>" class="beans1">
                </div>
                <a href="./product.php?country=<?= $result[0]['country_id']?>" class="country-button">生産国:<?= $result[0]['country_name']?>
                    <img src="img/country-flag_img/<?= $result[0]['country_img_url']?>" class="flag-img">
                </a>
                <h2 class="reference">参考記事</h2>
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
                <div class="info">
                    <h2 class="item-name2"><?= $result[0]['item_name']?></h2>
                    <div class="price_point">
                        <span class="price"><?= $result[0]['price']?>円( 税込 )</span><br>
                        <span class="point">+<?= $result[0]['point']?>ポイント</span>
                    </div>
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
                    <div class="gram-container">
                        <span class="many-gram">グラム数</span>
                        <select name="gram" class="gramselect">
                            <?php
                            for($i=1; $i<=5; $i++){
                                echo '<option value="',$i*100,'"">'.$i*100,'</option>';
                            }
                            ?>
                        </select>
                        <div></div>
                        <div class="cup-container">
                            <span class="cup">100g(10~15杯)</span>
                        </div>
                    </div>
                    <br>
                    <input type="nummber" value="1" name="many" class="many"/>
                    <span>個</span>
                    <button class="order-button">
                        <img src="./img/cart_cart_icon.png" class="cart-image"/>
                        カートに入れる
                    </button>
                    <br>
                    <?php
                    $page_url = (((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ) ? "https://" : "http://").$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    if(isset($favorite_flag)){
                        if($favorite_flag){
                            //お気に入り登録されていないとき
                            echo '<button onclick="execPost(',$page_url,',INSERT,',$item_id,',',$user_id,')" class="favorite"><img src="img/heart_black.png" class="heart">お気に入り登録</button>';
                        }else{
                            //お気に入り登録されているとき
                            echo '<button onclick="execPost(',$page_url,',DELETE,',$item_id,',',$user_id,')"class="favorite"><img src="img/heart_pink.png" class="heart">お気に入り削除</button>';
                        }
                    }
                    ?>

                </form>
            </div>
        </div>
        <div class="">
            <span class="recommendation">入門者におすすめのコーヒー</span>
        </div>
    </div>
    <script type="text/javascript" src="./js/post.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <script src="js/rader-chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</body>
</html>

