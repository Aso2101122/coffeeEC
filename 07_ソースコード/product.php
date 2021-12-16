<?php
session_start();
require("./dbmanager.php");
$pdo = getDb();

//検索文言保存
$word = '';
$resultcount = 0;
if (isset($_GET['category'])) {
    //カテゴリ別で商品を取得
    $category = $_GET['category'];
    $sql = $pdo->prepare('select i.item_id , i.item_name, i.price, i.item_img_url from m_items i where category_id=?');
    $sql->bindValue(1,$category);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
} else if (isset($_GET['keyword'])){
    //検索用処理
    $keyword = $_GET['keyword'];
    $sql = $pdo->prepare('select i.item_id , i.item_name, i.price, i.item_img_url from m_items i where item_name LIKE "%'.$keyword.'%"');
    $sql->execute();
    //エリア検索
    $result_item = $sql->fetchALL(PDO::FETCH_ASSOC);
    $sql = $pdo->prepare('select i.item_id, item_name, i.price, i.item_img_url , c.area_id from m_items i,m_country c, m_area a where i.country_id = c.country_id AND c.area_id = a.area_id AND a.area_name LIKE "%'.$keyword.'%"');
    $sql->bindValue(1,$keyword);
    $sql->execute();
    $result_area = $sql->fetchALL(PDO::FETCH_ASSOC);
    //国名検索
    $sql = $pdo->prepare('select i.item_id, item_name, i.price, i.item_img_url , c.area_id from m_items i,m_country c where i.country_id = c.country_id AND c.country_name LIKE "%'.$keyword.'%"');
    $sql->bindValue(1,$keyword);
    $sql->execute();
    $result_country = $sql->fetchALL(PDO::FETCH_ASSOC);
    $result = array_merge($result_item, $result_area, $result_country);
    $resultcount = count($result);

    $word = $keyword;
} else if (isset($_GET['country'])){
    //国idで検索
    $country_id = $_GET['country'];
    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url from m_items where country_id=?');
    $sql->bindValue(1,$country_id);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
    $resultcount = count($result);
    $sql = $pdo->prepare('select country_name from m_country where country_id = ?');
    $sql->bindValue(1,$country_id);
    $sql->execute();
    $country_name = $sql->fetchALL(PDO::FETCH_ASSOC);
    $word = $country_name[0]['country_name'];
} else if(isset($_GET['area'])){
    //エリアidで検索
    $area_id = $_GET['area'];
    $sql = $pdo->prepare('select i.item_id, item_name, i.price, i.item_img_url , c.area_id from m_items i,m_country c, m_area a where i.country_id = c.country_id AND c.area_id = a.area_id AND a.area_id = ?;');
    $sql->bindValue(1,$area_id);
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
//    表示用のエリア名を取得
    $sql = $pdo->prepare('select area_name from m_area where area_id = ?');
    $sql->bindValue(1,$area_id);
    $sql->execute();
    $area_name = $sql->fetchALL(PDO::FETCH_ASSOC);
    $word = $area_name[0]['area_name'];
    $resultcount = count($result);
} else if(isset($_GET['recommend'])){
    //おすすめを表示
    $sql = $pdo->prepare('select item_id, item_name, price, item_img_url from m_items where featured_flag=1');
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
    $resultcount = count($result);
    $word = '入門者におすすめ';
} else if(isset($_GET['rank'])){
    //ランキングを表示
    $sql = $pdo->prepare('select i.item_id, i.item_name, i.price, i.item_img_url, sum(quantity) as seles_count from m_items i left outer join t_order_detail o on i.item_id = o.item_id where i.category_id = 01 group by i.item_id order by seles_count desc;');
    $sql->execute();
    $result = $sql->fetchALL(PDO::FETCH_ASSOC);
    $resultcount = count($result);
    $word = 'ランキング';
}

//ソートのセレクトボックスの初期値
$selected0 = "";
$selected1 = "";
$selected2 = "";
$selected3 = "";
$selected4 = "";
//ソートする
if(isset($_POST['sort'])){
    switch($_POST['sort']){
        case 0:
            $selected0 = 'selected';
            break;
        case 1:
            //価格の降順
            foreach ($result as $key => $value) {
                $sort[$key] = $value['price'];
            }
            array_multisort($sort, SORT_ASC, $result);
            $selected1 = 'selected';
            break;
        case 2:
            //価格の昇順
            foreach ($result as $key => $value) {
                $sort[$key] = $value['price'];
            }
            array_multisort($sort, SORT_DESC, $result);
            $selected2 = 'selected';
            break;
        case 3:
            //名前の昇順
            foreach ($result as $key => $value) {
                $sort[$key] = $value['item_name'];
            }
            array_multisort($sort, SORT_ASC, $result);
            $selected3 = 'selected';
            break;
        case 4:
            //名前の降順
            foreach ($result as $key => $value) {
                $sort[$key] = $value['item_name'];
            }
            array_multisort($sort, SORT_DESC, $result);
            $selected4 = 'selected';
            break;
    }
}

//ソートのformのurlを作成
if(isset($_GET)){
    $get = array_keys($_GET);
    $get_key = $get[0];
    $get_url = $get_key.'='.$_GET[$get_key] ;
}

$pdo= null;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee：商品一覧</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/list-style.css">
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
</head>

<body>
<?php require 'global-menu.php'; ?>
<div class="main-content">
    <?php
    if(isset($_GET['category'])){
        echo '<div class="headder">';
        if($_GET['category'] === '01'){
            echo '<img src="./img/item-list_beans-header_img.png" class="headder-img">';
        }else if($_GET['category'] === '02'){
            echo '<img src="./img/item-list_utensils-header_img.png" class="headder-img">';
        }
        echo '</div>';
    }else{
        echo '<div class="heading-search">';
        echo '<span class="heading">'.$word.'の検索結果</span>';
        echo '<span class="search-count">（'.$resultcount.'件）</span>';
        echo '</div>';
    }
    ?>
    <div class="sort">
            <form action="./product.php?<?= $get_url ?>" method="post">
                <span class="display">表示順:<span>
                    <select name="sort" class="sort-select" onchange="submit(this.form)">
                        <option value="0" <?= $selected0 ?>>指定なし</option>
                        <option value="1" <?= $selected1 ?>>価格の安い順</option>
                        <option value="2" <?= $selected2 ?>>価格の高い順</option>
                        <option value="3" <?= $selected3 ?>>名前の昇順</option>
                        <option value="4" <?= $selected4 ?>>名前の降順</option>
                    </select>
            </form>
    </div>
    <hr class="line">
    <?php
    $count = count($result);
    if ($count === 0){
        echo '<div class="not-find">該当する商品がありません</div>';
    } else {
        echo '<div class="item-container">';
        for ($i=0; $i < $count; $i+=4){
            echo '<div class="item-row">';
            for ($j=0; $j < 4; $j++){
                echo '<div class="merchandises">';
                echo '<a href="item-detail.php?id='.$result[$j+$i]['item_id'].'" class="item-link">';
                echo '<img src="./img/item-img/'.$result[$j+$i]['item_img_url'].'" class="item-img">';
                echo '<div class="info">';
                echo '<span>'.$result[$j+$i]['item_name'].'</span><br>';
                echo '<div class="price">';
                echo '<span>'.$result[$j+$i]['price'].'円(税込)</span>';
                echo '</div>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
                if($j+$i == $count-1){
                    break;
                }
            }
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
</div>
</body>

</html>