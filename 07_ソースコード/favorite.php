<?php
session_start();
require("./dbmanager.php");
$pdo = getDb();
if (isset($_SESSION['user'])) {
    //お気に入りの商品に追加している商品を取得
    $user_id = $_SESSION['user']['user_id'];
    $sql = $pdo->prepare('select f.item_id, i.item_name, i.price, i.item_img_url from t_favorite_items f, m_items i where f.item_id = i.item_id AND user_id=? ORDER BY register_at asc');
    $sql->bindValue(1,$user_id);
    $sql->execute();
    $favorite_item = $sql->fetchALL(PDO::FETCH_ASSOC);
}


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee：カート</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/favorite-style.css">
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
</head>

<body>
<?php require 'global-menu.php';?>
<div class="main-content">
    <h1 class="heading">お気に入り商品</h1>
    <?php
    $count = count($favorite_item);
    if ($count === 0){
        echo '<div class="not-find">該当する商品がありません</div>';
    } else {
        for ($i=0; $i < $count; $i+=4){
            echo '<div class="item-row">';
            for ($j=0; $j < 4; $j++){
                echo '<div class="merchandises">';
                echo '<div class="item-hover">';
                echo '<a href="item-detail.php?id='.$favorite_item[$j+$i]['item_id'].'" class="item-link">';
                echo '<img src="./img/item-img/'.$favorite_item[$j+$i]['item_img_url'].'" class="item-img">';
                echo '<div class="info">';
                echo '<span>'.$favorite_item[$j+$i]['item_name'].'</span><br>';
                echo '<div class="price">';
                echo '<span>'.$favorite_item[$j+$i]['price'].'(税込)</span>';
                echo '</div>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
                echo '<button type="button" onclick="" class="order"><img src="./img/cart_cart_icon.png" class="cart-image">カートに入れる</button>';
                echo '</div>';
                if($j+$i == $count-1){
                    break;
                }
            }
            echo '</div>';

        }
    }
    ?>
</div>

</body>