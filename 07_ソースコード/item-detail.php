<?php
require("./dbmanager.php");
$pdo = getDb();

if (isset($_GET['id'])) {
    //商品idをGETでを取得
    $item_id = $_GET['id'];
    //データベースから必要な情報を検索
    $sql = $pdo->prepare('  ');
    $sql->bindValue(1,$item_id);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
    echo '<pre>';
    print_r($result);
    echo '</pre>';
}else{
    echo '<p>該当する商品が見つかりませんでした。</p>';
}

$pdo= null;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/item-detail.css">
</head>
<body>
    <?php require './global-menu.php'; ?>

</body>
</html>

