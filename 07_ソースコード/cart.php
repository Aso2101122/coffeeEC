<?php
session_start();
require_once 'dbmanager.php';
$pdo = getDb();
$count = 0;

if(isset($_POST['delete'])){
    //カート内商品削除
    unset($_SESSION['cart'][$_POST['delete']]);
}else if(isset($_POST['quantity-change'])){
    //個数変更
    $_SESSION['cart'][$_POST['cart-num']]['quantity'] = $_POST['quantity-change'];
}

$count = count($_SESSION['cart']);
//金額計算
$item_total = 0;
$postage_total = 0;
$amount_total = 0;
$earned_point = 0;
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
            <?php foreach($_SESSION['cart'] as $key => $row){?>
            <?php
                if(isset($_SESSION['cart'][$key]['item_id'])){
                    //カートの中身がある場合
                    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url , point from m_items where item_id=?');
                    $sql->bindValue(1,$_SESSION['cart'][$key]['item_id']);
                    $sql->execute();
                    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $item_price = $result[0]['price'] * $_SESSION['cart'][$key]['quantity'] * $_SESSION['cart'][$key]['gram'] / 100;
                    $item_total += $item_price;
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

                        <span class="item-gram"><?= $_SESSION['cart'][$key]['gram'] ?>g</span>
                    </div>
                    <span class="item-price"><?= $item_price  ?>円（税込）</span>
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
        <?php
        //計算処理をする
        if($item_total >= 5000){
            $postage_total = 0;
        }else{
            $postage_total = 550;
        }
        $amount_total = $item_total+$postage_total;
        $earned_point = $amount_total/100;
        ?>

        <div class="main-right">
            <div class="row">
                <span class="item-total-text">商品合計</span>
                <span class="item-total-amount"><?= $item_total ?>円</span>
            </div>
            <div class="row">
                <span class="postage-total-text">送料合計</span>
                <span class="postage-total-amount"><?= $postage_total ?>円</span>
            </div>
            <div class="border"></div>
            <div class="row">
                <span class="total-text">合計金額</span>
                <span class="total-amount"><?= $amount_total ?>円</b></span>
            </div>
            <div class="row">
                <span class="earned-points-text">獲得ポイント</span>
                <span class="earned-points"><?= $earned_point ?>pt</span>
            </div>
            <button type="submit" class="order" value="send">ご注文手続き<img src="img/yazi3_white.png" class="order-img"></button>
        </div>
    </div>
    <?php endif ?>
</div>
</body>

</html>
