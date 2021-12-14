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
            <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/68rTkR7qabk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <a class="text1">【初心者向け】美味しいコーヒーの淹れ方</a>
        </div>
        <div class="reference-page2"> 
            <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/3OZkPfPqH-A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <a class="text2">キッチン用品だけでコーヒーを淹れる方法</a>
        </div>
        <div class="reference-page3">
            <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/o3eMg4DYLKo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <a class="text3">世界一美味しいコーヒーの淹れ方</a>
        </div>
        <div class="reference-page4">
            <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/FNDnh7Zo7Ec" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <a class="text4">最初に買うべき4つのマストアイテム</a>
        </div>
    </div>  
</body>

</html>