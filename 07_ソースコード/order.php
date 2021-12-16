<?php
session_start();
require_once 'dbmanager.php';
$pdo = getDb();
$order_id = $_GET['order'];
$item_total = 0;
//注文情報を取得
$sql = $pdo->prepare('select * from t_order where order_id = ?');
$sql->bindValue(1,$order_id);
$sql->execute();
$order_result = $sql->fetchAll(PDO::FETCH_ASSOC);


$sql = $pdo->prepare('select * from t_order_detail where order_id = ?');
$sql->bindValue(1,$order_id);
$sql->execute();
$detail_result = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Beginners Coffee:注文確定</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart-style.css">
    <link rel="stylesheet" href="css/order.css">
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
</head>

<body>
<?php require 'global-menu.php'; ?>
<div class="main-content">
    <div class="order-msg-container">
        <span class="order-msg">ご注文が確定しました。</span>
        <span class="order-msg">ご購入ありがとうございました。</span>
        <button class="black-button" onclick="location.href='./index.php'">トップページに戻る</button>
    </div>
    <div class="buy-item-container">
        <span class="buy-item">購入した商品</span>
    </div>

    <div class="flex-container">
        <div class="main-left">
            <?php foreach($detail_result as $key => $row){?>
                <?php
                //商品の１つ1つの情報を取得
                if(isset($_GET['order'])){
                    //カートの中身がある場合
                    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url , category_id from m_items where item_id=?');
                    $sql->bindValue(1,$row['item_id']);
                    $sql->execute();
                    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $item_total += $row['price'];
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
                                    <span class="item-gram"><?= $row['gram'] ?>g</span>
                                <?php endif ?>
                            </div>
                            <span class="item-price"><?= $row['price'] ?>円（税込）</span>
                            <span class="item-stock">在庫あり</span>
                            <span class="item-stock">個数：<?= $row['quantity'] ?></span>
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
                <span class="postage-total-amount"><?= $order_result[0]['postage'] ?> 円</span>
            </div>
            <div class="border"></div>
            <div class="row">
                <span class="subtotal-text">小計</span>
                <span class="subtotal"><?= $item_total+$order_result[0]['postage'] ?> 円</span>
            </div>
            <div class="row">
                <span class="use-point-text">使用ポイント数</span>
                <span><?= $order_result[0]['use_point'] ?>P</span>
            </div>
            <div class="border"></div>
            <div class="row">
                <span class="total-text">合計金額</span>
                <span class="total-amount"><?= $order_result[0]['total_fee'] ?> 円</b></span>
            </div>
            <div class="row">
                <span class="earned-points-text">獲得ポイント</span>
                <span class="earned-points"><?= $order_result[0]['total_fee']/100 ?>pt</span>
            </div>
        </div>
</div>
</body>
</html>

