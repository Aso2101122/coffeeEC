<?php
session_start();
require_once 'dbmanager.php';
$pdo = getDb();
$count = 0;
$display_cart_count = 0;
if(isset($_POST['delete'])){
    //カート内商品削除
    unset($_SESSION['cart'][$_POST['delete']]);
}else if(isset($_POST['quantity-change'])){
    //個数変更
    $_SESSION['cart'][$_POST['cart-num']]['quantity'] = $_POST['quantity-change'];
}
if(isset($_SESSION['cart'])){
    //カートの配列の数
    $count = count($_SESSION['cart']);
    //表示用個数
    foreach($_SESSION['cart'] as $item){
        $display_cart_count += $item['quantity'];
    }
}
$owned_points = 0;
if(isset($_SESSION['user'])){
    $owned_points = $_SESSION['user']['owned_points'];
}

//金額計算
$item_total = 0;
//送料合計
$postage_total = 0;
//小計
$subtotal = 0;
//合計金額
$amount_total = 0;
//獲得ポイント
$earned_point = 0;
//使用ポイント
$use_point = 0;

//合計金額計算
if(isset($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $key => $row) {
        if (isset($_SESSION['cart'][$key]['item_id'])) {
            //カートの中身がある場合
            $sql = $pdo->prepare('select item_id, item_name, price, point , category_id from m_items where item_id=?');
            $sql->bindValue(1, $_SESSION['cart'][$key]['item_id']);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            if ($result[0]['category_id'] == '01') {
                $item_price = $result[0]['price'] * $_SESSION['cart'][$key]['quantity'] * $_SESSION['cart'][$key]['gram'] / 100;
            } else {
                $item_price = $result[0]['price'] * $_SESSION['cart'][$key]['quantity'];
            }
            $item_total += $item_price;
        }
    }
}

//計算処理をする
if ($item_total >= 5000) {
    $postage_total = 0;
} else {
    $postage_total = 550;
}
//小計を計算
$subtotal = $item_total + $postage_total;
if (isset($_POST['use-point']) && isset($_SESSION['user']['user_id'])) {
    //使用ポイントが保有ポイントを上回らないか
    if ($_POST['use-point'] <= $_SESSION['user']['owned_points']) {
        //上回らないとき
        $use_point = $_POST['use-point'];
    } else {
        //上回るとき
        $use_point = $_SESSION['user']['owned_points'];
    }
    //使用ポイントが小計金額を上回るか
    if($_POST['use-point'] >= $subtotal){
        //上回るとき
        $use_point = $subtotal;
    }
    //使用ポイントがある場合はポイントを引く
    $amount_total = $subtotal - $use_point;
} else {
    //使用ポイントがない場合は小計をそのまま入れる
    $amount_total = $subtotal;
}
//獲得ポイント計算
$earned_point = floor($amount_total / 100);


//注文確定ボタンを押したとき
if(isset($_POST['order'])){
    if($_POST['order']){
        //ログイン状態か
        if(!isset($_SESSION['user']['user_id'])) {
            //ログイン状態ではないときはログイン画面へ遷移
            header('Location: ./member-login.php');
            exit;
        }
        //注文票に追加
        $sql = $pdo->prepare('insert into t_order(user_id,postage,total_fee,earne_point,use_point) VALUES(?,?,?,?,?)');
        $sql->bindValue(1,$_SESSION['user']['user_id']);
        $sql->bindValue(2,$postage_total);
        $sql->bindValue(3,$amount_total);
        $sql->bindValue(4,$_SESSION['user']['owned_points']);
        $sql->bindValue(5,$use_point);
        $sql->execute();
        //この注文を取得取得
        $sql = $pdo->query('select max(order_id) as order_id from t_order');
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        $order_id = $result[0]['order_id'];
        //注文詳細に追加
        foreach($_SESSION['cart'] as $key => $row){
            //商品単価を取得
            $sql = $pdo->prepare('select price from m_items where item_id=?');
            $sql->bindValue(1,$row['item_id']);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            $item_price = $result[0]['price'];
            //注文詳細テーブルに追加
            $sql = $pdo->prepare('insert into t_order_detail(order_id, item_id, gram, quantity, price) VALUES(?,?,?,?,?)');
            $sql->bindValue(1,$order_id);
            $sql->bindValue(2,$row['item_id']);
            $sql->bindValue(3,$row['gram']);
            $sql->bindValue(4,$row['quantity']);
            $sql->bindValue(5,$item_price);
            $sql->execute();
        }
        //ポイント情報を管理
        $_SESSION['user']['owned_points'] = $_SESSION['user']['owned_points'] - $use_point + $earned_point;
        $sql = $pdo->prepare('update m_user set owned_points = ? where user_id = ?');
        $sql->bindValue(1,$_SESSION['user']['owned_points']);
        $sql->bindValue(2,$_SESSION['user']['user_id']);

        $sql->execute();
        unset($_SESSION['cart']);
        header('Location: ./order.php?order='.$order_id);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Beginners Coffee:カート</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart-style.css">
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
</head>

<body>
<?php require 'global-menu.php'; ?>
<div class="main-content">
    <div class="heading-container">
        <span class="heading">カート</span>
        <span class="item-count">(<?= $display_cart_count ?>点の商品)</span>
    </div>
    <?php
    if($count == 0){
        echo '<div class="not-find">カート内に商品がありません</div>';
    }
    if($count != 0):
    ?>
    <div class="flex-container">
        <div class="main-left">
            <?php foreach($_SESSION['cart'] as $key => $row){?>
            <?php
                //商品の１つ1つの情報を取得
                if(isset($_SESSION['cart'][$key]['item_id'])){
                    //カートの中身がある場合
                    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url , category_id from m_items where item_id=?');
                    $sql->bindValue(1,$_SESSION['cart'][$key]['item_id']);
                    $sql->execute();
                    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                    if($result[0]['category_id'] == '01'){
                        $item_price = $result[0]['price'] * $_SESSION['cart'][$key]['quantity'] * $_SESSION['cart'][$key]['gram'] / 100;
                    }else{
                        $item_price = $result[0]['price'] * $_SESSION['cart'][$key]['quantity'];
                    }
            ?>
            <div class="item">
                <a href="item-detail.php?id=<?= $result[0]['item_id'] ?>">
                    <img src="./img/item-img/<?= $result[0]['item_img_url'] ?>" class="item-img"/>
                </a>

                <div class="item-info">
                    <div class="item-info-row">
                        <a href="item-detail.php?id=<?= $result[0]['item_id'] ?>">
                            <span class="item-name"><?= $result[0]['item_name'] ?></span>
                        </a>
                        <?php if($result[0]['category_id'] == '01'):?>
                            <span class="item-gram"><?= $_SESSION['cart'][$key]['gram'] ?>g</span>
                        <?php endif ?>
                    </div>
                    <span class="item-price"><?= $item_price ?>円（税込）</span>
                    <span class="item-stock">在庫あり</span>
                    <form action="./cart.php" method="post">
                        <button type="submit" class="item-delete" name="delete" value="<?= $key ?>" >削除</button>
                        <select name="quantity-change" class="quantity" onchange="submit(this.form)">
                            <?php
                            for($j=1; $j<100; $j++){
                                $selected = null;
                                if ( $_SESSION['cart'][$key]['quantity'] == $j ) {
                                    $selected = ' selected';
                                }
                                echo '<option value="'.$j.'"'.$selected.'>'.$j.'</option>';
                            }
                            ?>
                        </select>
                        <input type="hidden" name="cart-num" value="<?= $key ?>"/ >
                    </form>

                </div>
            </div>
            <?php
                }
            }
            ?>
            <?php
            $pdo = null;
            ?>
        </div>


        <div class="main-right">
            <div class="row">
                <span class="item-total-text">商品合計</span>
                <span class="item-total-amount"><?= $item_total ?> 円</span>
            </div>
            <div class="row">
                <span class="postage-total-text">送料合計</span>
                <span class="postage-total-amount"><?= $postage_total ?> 円</span>
            </div>
            <div class="border"></div>
            <div class="row">
                <span class="subtotal-text">小計</span>
                <span class="subtotal"><?= $subtotal ?> 円</span>
            </div>
            <div class="row">
                <span class="owned_points-text">保有ポイント数</span>
                <span class="owned_points"><?= $owned_points ?> P</span>
            </div>
            <div class="row">
                <span class="use-point-text">使用ポイント数</span>
                <div>
                    <form action="./cart.php" method="post">
                        <input type="number" class="point-box" name="use-point" value="<?= $use_point ?>" onchange="submit(this.form)"/>
                        <span class="p-text">P</span>
                </div>
            </div>
            <div class="border"></div>
            <div class="row">
                <span class="total-text">合計金額</span>
                <span class="total-amount"><?= $amount_total ?> 円</b></span>
            </div>
            <div class="row">
                <span class="earned-points-text">獲得ポイント</span>
                <span class="earned-points"><?= $earned_point ?>pt</span>
            </div>
            <button type="submit" class="order" name="order" value="order">注文を確定する<img src="img/yazi3_white.png" class="order-img"></button>
            </form>
        </div>
    <?php endif ?>
</div>
</body>

</html>
