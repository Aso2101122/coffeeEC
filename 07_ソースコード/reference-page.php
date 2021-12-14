<?php
session_start();
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reference-style.css">
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <?php require './global-menu.php' ?>
    <div class="main-content">
        <h1 class="recommendation-reference"><span>おすすめ解説サイト</span></h1>
        <div class="reference-page1">
            <img src="img/reference_page_img1.jpg" class="reference-img1"><br>
            <a href="https://every-coffee.com/article/coffee-item.html">コーヒー初心者でも自宅で手軽にできる簡単なコーヒーの入れ方</a>
        </div>
        <div class="reference-page2"> 
            <img src="img/reference_page_img2.jpg" class="reference-img2"><br>
            <a href="https://cafend.net/teastrainer-coffee/">ドリッパーもフィルターも不要!?茶こしを使ってコーヒーをおいしく淹れる方法</a>
        </div>
        <div class="reference-page3">
            <img src="img/reference_page_img3.jpg" class="reference-img3"><br>
            <a href="https://cafict.com/make-coffee/coffee-tools/first-coffeetools/">一番美味しいコーヒーの入れ方】プロのハンドドリップ動画11選</a>
        </div>
        <div class="reference-page4">
            <img src="img/reference_page_img4.jpg" class="reference-img4"><br>
            <a href="https://every-coffee.com/article/coffee-drip.html">おうちで本格ハンドドリップコーヒーを 始めるために揃えるべき7つの道具。</a>
        </div>
    </div>  
</body>

</html>