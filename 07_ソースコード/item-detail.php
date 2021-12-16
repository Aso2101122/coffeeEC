<?php
session_start();
require("./dbmanager.php");
$pdo = getDb();
if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    if($item_id <= 20000){
//        コーヒー豆の検索処理
        $sql = $pdo->prepare('SELECT * FROM m_items, m_country WHERE m_items.country_id = m_country.country_id AND item_id =? AND private_flag =0');
    }else{
        $sql = $pdo->prepare('SELECT * FROM m_items WHERE item_id =? AND private_flag =0');
    }
    //データベースから必要な情報を検索
    $sql->bindValue(1,$item_id);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
}else{
    echo '<p>該当する商品が見つかりませんでした。</p>';
}

$user_id = null;
$item_id = null;
if(isset($_POST['method'])){
    $user_id = $_POST['user_id'];
    $item_id = $_POST['item_id'];
    //お気に入りを追加する
    if($_POST['method'] == 0){
        $sql = $pdo->prepare('INSERT INTO t_favorite_items(user_id,item_id) VALUES (?,?)');
        $sql->bindValue(1,$user_id);
        $sql->bindValue(2,$item_id);
        $sql->execute();
    }
    //お気に入りを削除する
    if($_POST['method'] == 1){
        $sql = $pdo->prepare('DELETE FROM t_favorite_items WHERE user_id = ? AND item_id = ?');
        $sql->bindValue(1,$user_id);
        $sql->bindValue(2,$item_id);
        $sql->execute();
    }
}

$favorite_flag = null;
//お気に入り情報取得
if(isset($_SESSION['user']['user_id'])){
    $user_id = $_SESSION['user']['user_id'];
    $item_id = $result[0]['item_id'];
    $sql = $pdo->prepare('SELECT * FROM t_favorite_items WHERE user_id=? AND item_id=?');
    $sql->bindValue(1,$user_id);
    $sql->bindValue(2,$item_id);
    $sql->execute();
    if($sql->rowCount() === 1){
        $favorite_flag = true;
    }else{
        $favorite_flag = false;
    }
}

//カート追加
if(isset($_POST['cart-button'])){
    //数が1以上かのチェック
    if($_POST['quantity'] >= 1){
        if(isset($_SESSION['cart'])){
            $cart = $_SESSION['cart'];
            $count = 0;
            //カート内の商品数を数える
//        foreach($_SESSION['cart'] as $key => $row){
//            if(isset($_SESSION['cart'][$key]['item_id'])){
//                $count++;
//            }
//        }
            $count = count($_SESSION['cart']);
            //カートに挿入するセッション情報の連想配列を作る
            $cart_add_info= array('item_id'=>$_GET['id'],'gram'=>$_POST['gram'],'quantity'=>$_POST['quantity'], 'category'=>$result[0]['category_id']);
            //重複フラグ
            $duplicate_flag = false;
            //重複がないかのチェック
            for($i=0; $i<= count($_SESSION['cart']); $i++){
                if(isset($_SESSION['cart'][$i]['item_id']) && isset($_POST['item_id'])){
                    $value = $_SESSION['cart'][$i];
                    print_r($value);
                    //idが一致するかのチェック
                    if($value['item_id'] == $_POST['item_id']){
                        //グラムが一致するかどうかのチェック
                        if($value['gram'] == $_POST['gram']){
                            //idとgram数が一致する場合は個数を増やす
                            $_SESSION['cart'][$i]['quantity'] = $_SESSION['cart'][$i]['quantity'] + $_POST['quantity'];
                            $duplicate_flag = true;
                        }
                    }
                }
            }
            echo $duplicate_flag;
            //重複がない場合はcartに追加する
            if(!$duplicate_flag){
                $_SESSION['cart'][$count] = $cart_add_info;
            }
        }else{
            //cartに商品が１つもなかった場合
            //商品id,グラム数, 個数の情報を持った連想配列を作る
            $cart_info = array('item_id'=>$_GET['id'], 'gram'=>$_POST['gram'], 'quantity'=>$_POST['quantity'], 'category'=>$result[0]['category_id']);
            $_SESSION['cart'][0] = $cart_info;
        }
    }

}

//豆の場合はjsに味の値を渡す
if($result[0]['category_id'] == '01') {
    $taste = array($result[0]['bitter'], $result[0]['sweet'], $result[0]['acidity'], $result[0]['scent'], $result[0]['rich']);
    $Jsontaste = json_encode($taste, JSON_UNESCAPED_UNICODE);
    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url from m_items where featured_flag = 1');
    $sql->execute();
    $recommend_item = $sql->fetchALL(PDO::FETCH_ASSOC);
}
$pdo= null;
?>
<script type="text/javascript">
    var taste = JSON.parse('<?php echo $Jsontaste; ?>');
</script>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee:<?= $result[0]['item_name']?></title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/item-detail.css">
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <?php require './global-menu.php'; ?>
    <div class="main-content">
        <div class="item-detail">
            <div class="main-left">
                <div class="merchandise1">
                    <h1>
                        <div class="item-name1"><?= $result[0]['item_name']?></div>
                    </h1>
                    <img src="img/item-img/<?= $result[0]['item_img_url']?>" class="beans1">
                </div>
                <?php if($result[0]['category_id'] == '01'):?>
                <a href="./product.php?country=<?= $result[0]['country_id']?>" class="country-button">生産国:<?= $result[0]['country_name']?>
                    <img src="img/country-flag_img/<?= $result[0]['country_img_url']?>" class="flag-img">
                </a>
                <?php endif ?>
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
                <div class="name-price">
                    <h2 class="item-name2"><?= $result[0]['item_name']?></h2>
                    <div class="price_point">
                        <span class="price"><?= $result[0]['price']?>円( 税込 )</span><br>
                        <span class="point">+<?= $result[0]['point']?>ポイント</span>
                    </div>
                </div>
                <?php if($result[0]['category_id'] == '01'):?>
                <div class="chart">
                    <canvas id="myRadarChart"></canvas>
                </div>
                <?php endif ?>
                <div class="main-explanation">
                    <p class="explanation">
                        <?= $result[0]['item_description']?>
                    </p>
                </div>
                <form action="item-detail.php?id=<?= $result[0]['item_id'] ?>" method="post">
                    <?php if($result[0]['category_id'] == '01'):?>
                    <div class="gram-container">
                        <span class="many-gram">グラム数</span>
                        <select name="gram" class="gramselect">
                            <?php
                            for($i=1; $i<=5; $i++){
                                echo '<option value="',$i*100,'"">'.$i*100,'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="cup-container">
                        <span class="cup">100g(10~15杯)</span>
                    </div>
                    <?php endif ?>
                    <br>
                    <input type="number" value="1" name="quantity" class="many"/>
                    <span>個</span>
                    <button type="submit" class="order-button" name="cart-button" value="add">
                        <img src="./img/cart_cart_icon.png" class="cart-image"/>
                        カートに入れる
                    </button>
                    <input type="hidden" name="item_id" value="<?= $_GET['id']?>"
                </form>
                <?php
                if(isset($favorite_flag)){
                    if(!$favorite_flag){
                        //お気に入り登録されていないとき
                        $method = 0;
                        echo '<button type="button" onclick="execPost('.$method.','.$item_id.','.$user_id.')" class="favorite"><img src="img/heart_black.png" class="heart">お気に入り登録</button>';
                    }else{
                        //お気に入り登録されているとき
                        $method = 1;
                        echo '<button type="button" onclick="execPost('.$method.','.$item_id.','.$user_id.')" class="favorite"><img src="img/heart_pink.png" class="heart">お気に入り削除</button>';
                    }
                }else{
                    echo '<button type="button" onclick="location.href=\'./member-login.php?msg=01&page='.$result[0]['item_id'].'\'" class="favorite"><img src="img/heart_black.png" class="heart">お気に入り登録</button>';
                }
                ?>
            </div>
        </div>
        <?php if($result[0]['category_id'] == '01'):?>
        <div class="recommend-container">
            <span class="recommendation">入門者におすすめのコーヒー豆</span>
            <div class="item-row">
            <?php
            for ($i=0; $i < 4; $i++){
                echo '<div class="merchandises">';
                echo '<a href="item-detail.php?id='.$recommend_item[$i]['item_id'].'" class="item-link">';
                    echo '<img src="./img/item-img/'.$recommend_item[$i]['item_img_url'].'" class="item-img">';
                    echo '<div class="info">';
                        echo '<span>'.$recommend_item[$i]['item_name'].'</span><br>';
                        echo '<div class="price">';
                            echo '<span>'.$recommend_item[$i]['price'].'円(税込)</span>';
                        echo '</div>';
                    echo '</div>';
                echo '</a>';
            echo '</div>';
            }
            ?>
            </div>
        </div>
        <?php endif ?>
    </div>
    <script type="text/javascript" src="./js/post.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <script src="js/rader-chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</body>
</html>

