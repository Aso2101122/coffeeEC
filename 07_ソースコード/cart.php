<?php
session_start();
require_once 'dbmanager.php';
$pdo = getDb();
$count = 0;
if(isset($_SESSION['cart'])){
    $count = count($_SESSION['cart']);
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
        <span class="item-count">(<?= $count ?>点の商品)</span>
    </div>
    <?php
    if($count == 0){
        echo '<div class="not-find">カート内に商品がありません</div>';
    }
    if($count != 0):
    ?>
    <div class="flex-container">
        <div class="main-left">
            <?php for($i=0; $i<$count; $i++): ?>
            <?php
                $sql = $pdo->prepare('select item_id, item_name, price, item_img_url from m_items where item_id=?');
                $sql->bindValue(1,$_SESSION['cart'][$i]['item_id']);
                $sql->execute();
                $result = $sql->fetchAll(PDO::FETCH_ASSOC);
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

                        <span class="item-gram"><?= $_SESSION['cart'][$i]['gram'] ?>g</span>
                    </div>
                    <span class="item-price"><?= $result[0]['price'] ?>円（税込）</span>
                    <span class="item-stock">在庫あり</span>
                    <button type="button" class="item-delete" >削除</button>
                    <select name="quantity" class="quantity">
                        <?php
                        for($j=1; $j<100; $j++){
                            echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php endfor; ?>
            <?php
            $pdo = null;
            ?>
        </div>


        <div class="main-right">
            <div class="row">
                <span class="item-total-text">商品合計</span>
                <span class="item-total-amount">¥3550</span>
            </div>
            <div class="row">
                <span class="postage-total-text">送料合計</span>
                <span class="postage-total-amount">¥550</span>
            </div>
            <div class="border"></div>
            <div class="row">
                <span class="total-text">合計金額</span>
                <span class="total-amount">¥4,050</b></span>
            </div>
            <div class="row">
                <span class="earned-points-text">獲得ポイント</span>
                <span class="earned-points">40pt</span>
            </div>
            <button type="submit" class="order" value="send">ご注文手続き<img src="img/yazi3_white.png" class="order-img"></button>
        </div>
    </div>
    <?php endif ?>
</div>
</body>

</html>
