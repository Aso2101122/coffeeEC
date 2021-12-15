<?php
session_start();
require_once "dbmanager.php";
//pdoインスタンス作成するメソッド
$pdo = getDb();
//エリアの情報を取得するsql文を生成、実行
$stmt = $pdo->query('select * from m_area');
//配列形式に変換
$result_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$jsonResultlist = json_encode($result_list, JSON_UNESCAPED_UNICODE);

//アフリカの商品情報と売り上げ取得するsql文を生成、実行（未完成）
// $stmt = $pdo->query('select i.item_id, item_name, i.price, i.item_img_url , c.area_id , count(*) as cnt from m_items i,m_country c, m_area a, t_order_detail o where i.country_id = c.country_id AND c.area_id = a.area_id AND i.item_id = o.item_id GROUP BY i.item_id ORDER BY count(*) desc, c.area_id asc;');

// アフリカの商品情報を取得するsql文を生成、実行
$stmt = $pdo->query('select i.item_id, item_name, i.price, i.item_img_url , c.area_id from m_items i,m_country c, m_area a where i.country_id = c.country_id AND c.area_id = a.area_id AND c.area_id = 01;');
$africa_item_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$JsonAfrica = json_encode($africa_item_list, JSON_UNESCAPED_UNICODE);

// 東南アジアの商品情報を取得するsql文を生成、実行
$stmt = $pdo->query('select i.item_id, item_name, i.price, i.item_img_url , c.area_id from m_items i,m_country c, m_area a where i.country_id = c.country_id AND c.area_id = a.area_id AND c.area_id = 02;');
$asia_item_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$JsonAsia = json_encode($asia_item_list, JSON_UNESCAPED_UNICODE);

// ラテンアメリカ（中南米）の商品情報を取得するsql文を生成、実行
$stmt = $pdo->query('select i.item_id, item_name, i.price, i.item_img_url , c.area_id from m_items i,m_country c, m_area a where i.country_id = c.country_id AND c.area_id = a.area_id AND c.area_id = 03;');
$latin_america_item_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$JsonLatainAmerica = json_encode($latin_america_item_list, JSON_UNESCAPED_UNICODE);
?>

<script type="text/javascript">
    var area_result = JSON.parse('<?php echo $jsonResultlist; ?>');
    var africa_item = JSON.parse('<?php echo $JsonAfrica; ?>');
    var asia_item = JSON.parse('<?php echo $JsonAsia; ?>');
    var latain_america_item = JSON.parse('<?php echo $JsonLatainAmerica; ?>');
    //jsonをparseしてJavaScriptの変数に代入
</script>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/coffee-world-map-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-rwdImageMaps/1.6/jquery.rwdImageMaps.min.js"></script>
</head>

<body>
    <?php require './global-menu.php'; ?>
    <div class="main-content">
        <img src="img/world-map_title_img.png" class="heading-img">
        <h1>世界のコーヒーマップ</h1>
        <p>産地の味の違いを楽しみながらコーヒーをお飲みください。</p>
        <div class="main-1">
            <div class="main-2">
                <img src="./img/world-map_world-map_img_00.png" alt="コーヒーワールドマップ" id="worldmap" usemap="#map" class="map-img" />
                <map name="map">
                    <area alt="アフリカ部分" shape="poly" coords="126,330,122,297,116,282,92,284,54,270,35,277,18,297,3,316,4,325,12,340,24,357,60,359,77,444,81,448,104,448,124,416,135,402,135,382,133,374,142,363,146,362,157,334,126,334,126,334" onclick="selectArea(1)" onmouseover="pictureChange(1)" onmouseout="pictureChange(0)" onfocus="pictureChange(1)" onblur="pictureChange(0)">

                    <area alt="マダガスカル部分" shape="poly" coords="155,396,148,393,137,405,133,415,133,421,135,425,140,427,144,427,148,420,156,399,386,413" onclick="selectArea(1)" onmouseover="pictureChange(1)" onmouseout="pictureChange(0)" onfocus="pictureChange(1)" onblur="pictureChange(0)">

                    <area alt="東南アジア1" shape="poly" coords="287,309,278,308,267,313,257,300,249,295,243,296,234,315,248,327,251,352,256,361,267,364,266,355,261,334,261,331,268,339,281,336,282,337,286,332,285,327,281,320,282,320,282,320" onclick="selectArea(2)" onmouseover="pictureChange(2)" onmouseout="pictureChange(0)" onfocus="pictureChange(2)" onblur="pictureChange(0)">

                    <area alt="東南アジア2" shape="poly" coords="270,365,266,365,262,369,265,373,273,379,279,385,290,384,292,381,292,378,285,376,283,375" onclick="selectArea(2)" onmouseover="pictureChange(2)" onmouseout="pictureChange(0)" onfocus="pictureChange(2)" onblur="pictureChange(0)">

                    <area alt="東南アジア3" shape="poly" coords="303,352,298,346,285,353,278,363,280,368,288,370,296,369,302,362,302,360" onclick="selectArea(2)" onmouseover="pictureChange(2)" onmouseout="pictureChange(0)" onfocus="pictureChange(2)" onblur="pictureChange(0)">

                    <area alt="東南アジア4" shape="poly" coords="344,386,346,373,340,368,327,364,326,366,330,376,341,385,341,385" onclick="selectArea(2)" onmouseover="pictureChange(2)" onmouseout="pictureChange(0)" onfocus="pictureChange(2)" onblur="pictureChange(0)">

                    <area alt="中南米1" shape="poly" coords="541,276,540,278,545,289,560,310,565,309,567,305,568,301,565,294,569,294,584,319,633,343,636,344,627,361,627,373,630,382,645,402,650,417,639,466,636,486,636,503,640,509,647,514,647,514,648,516,654,515,656,513,655,510,664,482,676,464,692,454,720,432,737,402,745,382,746,374,722,365,707,362,703,358,659,334,638,333,632,328,620,325,618,315,611,314,604,316,596,298,592,294,555,278" onclick="selectArea(3)" onmouseover="pictureChange(3)" onmouseout="pictureChange(0)" onfocus="pictureChange(3)" onblur="pictureChange(0)">

                    <area alt="中南米2" shape="poly" coords="647,312,640,305,623,304,619,306,622,312,631,317,647,322,651,321,650,314,649,311,643,308" onclick="selectArea(3)" onmouseover="pictureChange(3)" onmouseout="pictureChange(0)" onfocus="pictureChange(3)" onblur="pictureChange(0)">
                </map>
                <script>
                    //レスポンシブ対応
                    $('img[usemap]').rwdImageMaps();
                </script>
                <div class="origin-info">
                    <h2 class="area-name-off" id="area-name"></h2>
                    <p id="area-feature"></p>
                    <table class="area-table-off" id="area-table">
                        <tr class="area-tr-off" id="area-tr1">
                            <td class="table-heading" id="area-country-th"></td>
                            <td id="area-country"></td>
                        </tr>
                        <tr class="area-tr-off" id="area-tr2">
                            <td class="table-heading" id="area-beans-th"></td>
                            <td id="area-beans"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="main-3">
                <div class="recommend-item">
                    <h2 class="item-heading" id="item-heading">この産地のコーヒー豆</h2>
                    <div class="merchandise">
                        <a href="" class="item-link" id="item-link1">
                            <img src="./img/item-img/" class="item-img" id="item-img1">
                            <div class="info">
                                <span id="item-name1">商品名</span><br>
                                <div class="price">
                                    <span id="item-price1">500円(税込み)
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="merchandise">
                        <a href="" class="item-link" id="item-link2">
                            <img src="./img/item-img/" class="item-img" id="item-img2">
                            <div class="info">
                                <span id="item-name2">商品名</span><br>
                                <div class="price">
                                    <span id="item-price2">500円(税込み)
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <button type="button" class="normal-button" id="more-button">もっと見る</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src=".\js\world-map.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.rwdImageMaps.js"></script> -->
</body>

</html>