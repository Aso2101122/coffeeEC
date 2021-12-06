<?php
require './dbmanager.php';
$pdo = getDb();
if(isset($_POST['item_name'])){
    $sql = $pdo->prepare('INSERT INTO m_items(item_name,price,item_description,item_img_url,country_id,category_id,point,bitter,sweet,acidity,rich,scent) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)');
    $sql->execute([$_POST['item_name'],$_POST['price'],$_POST['item_description'],$_POST['item_img_url'],$_POST['country_id'],$_POST['category_id'],$_POST['point'],$_POST['bitter'],$_POST['sweet'],$_POST['acidity'],$_POST['rich'],$_POST['scent']]);
    //重複防止
    header('Location:./item_insert.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品追加</title>
</head>
<body>
<h1>商品追加</h1>
<form action="item_insert.php" method="post">
    <table>
        <tr>
            <td>商品名</td>
            <td><input type="text" name="item_name"/></td>
        </tr>
        <tr>
            <td>価格</td>
            <td><input type="number" name="price"/></td>
        </tr>
        <tr>
            <td>商品詳細</td>
            <td><input type="text" name="item_description"/></td>
        </tr>
        <tr>
            <td>商品画像パス</td>
            <td><input type="text" name="item_img_url"/></td>
        </tr>
        <tr>
            <td>生産国id</td>
            <td><input type="number" name="country_id"/></td>
        </tr>
        <tr>
            <td>カテゴリid</td>
            <td>
                <select name="category_id">
                    <option value="01">豆(01)</option>
                    <option value="02">器具(02)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>ポイント(1%)</td>
            <td><input type="number" name="point"/></td>
        </tr>
        <tr>
            <td>苦味</td>
            <td><input type="number" name="bitter"/></td>
        </tr>
        <tr>
            <td>甘味</td>
            <td><input type="number" name="sweet"/></td>
        </tr>
        <tr>
            <td>酸味</td>
            <td><input type="number" name="acidity"/></td>
        </tr>
        <tr>
            <td>コク</td>
            <td><input type="number" name="rich"/></td>
        </tr>
        <tr>
            <td>香り</td>
            <td><input type="number" name="scent"/></td>
        </tr>
    </table>
    <button type="submit" value="保存">追加する</button>
</form>
<?php
//sqlを準備($sqlがPDOStatement)
$sql = $pdo->query('SELECT * FROM m_items');
$resultList = $sql->fetchAll(PDO::FETCH_NUM);
//行数取得
$sql->rowCount();

echo '<table>';
    echo '<tr>';
        echo '<th>商品id</th>';
        echo '<th>商品名</th>';
        echo '<th>価格</th>';
        echo '<th>商品詳細</th>';
        echo '<th>商品画像パス</th>';
        echo '<th>生産国id</th>';
        echo '<th>カテゴリid</th>';
        echo '<th>ポイント</th>';
        echo '<th>苦味</th>';
        echo '<th>甘味</th>';
        echo '<th>酸味</th>';
        echo '<th>コク</th>';
        echo '<th>香り</th>';
        echo '</tr>';
    //取り出したデータを挿入する
    for($i=0; $i<$sql->rowCount(); $i++) {
    echo '<tr>';
        echo '<td>',$i+1,'</td>';
        for ($j = 1; $j<=12; $j++) {
        echo '<td>', $resultList[$i][$j], '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';

$pdo=null;
?>
</body>