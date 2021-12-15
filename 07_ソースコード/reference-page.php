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
        <h1 class="recommendation-reference"><span>おすすめ解説動画</span></h1>
        <div class="reference-page1">
            <div class="text1-1"><h2 class="text1-2">初心者の方は先ずはこの動画</h2></div>
            <iframe width="800" height="450" src="https://www.youtube-nocookie.com/embed/68rTkR7qabk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <a>基本的なペーパードリップでの淹れ方です。必要な道具や中細挽きがのコーヒー豆の粒子なども解説しているので、初心者さんにもわかりやすくなっています。</a>
        </div>
        <div class="reference-page2">
            <div class="text1-1"><h2 class="text1-2">器具がないという方はこちらの動画</h2></div> 
            <iframe width="800" height="450" src="https://www.youtube-nocookie.com/embed/3OZkPfPqH-A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <a>美味しいコーヒーが飲みたいでも器具を持っていないそのような方向けの動画です。</a>
        </div>
        <div class="reference-page3">
            <div class="text1-1"><h2 class="text1-2">自宅で本格的なコーヒーが飲みたい方はこちらの動画</h2></div>
            <iframe width="800" height="450" src="https://www.youtube-nocookie.com/embed/o3eMg4DYLKo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <a>自宅でもお店で飲むような本格的なコーヒーを楽しみたいそのような方向けの動画です</a>
        </div>
        
        <div class="reference-page4">
            <div class="text1-1"><h2 class="text1-2">新しくコーヒー生活を始める方はこちらの動画</h2></div>
            <iframe width="800" height="450" src="https://www.youtube-nocookie.com/embed/FNDnh7Zo7Ec" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <a>新しくコーヒー生活を始めたいけれど必要な器具がわからないそのよう方向けの動画です</a>
        </div>
    </div>  
</body>

</html>