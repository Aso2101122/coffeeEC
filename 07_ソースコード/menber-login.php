<?php
require("./dbmanager.php");
session_start();
if(!empty($POST)){
    //    入力情報をチェック
    if ($_POST['email'] === "") {
        $error['email'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }
    //メールアドレスの重複検知
    if(!isset($error)){
        $member = $pdo -> prepare('SELECT COUNT(*) as cnt FROM m_user WHERE email=?');
        
    }

}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Biginners coffee</title>
    <link rel="stylesheet" href="./css/sanitize.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/menber-add-style.css" />
</head>

<body>
    <?php require "global-menu.php" ?>
    <!-- <div class="main-content"> -->
    <div class="menber-ship-form">
        <form action="menber-login.php" method="post">
            <h1>ログイン</h1>
            <div class="form-parts">
                <span class="tag">メールアドレス</span>
                <input type="text" name="email" class="input-text" /><br>
            </div>
            <div class="form-parts">
                <span class="tag">パスワード</span>
                <input type="password" name="password" class="input-text" /><br>
            </div>
            <div class="submit-button">
                <button type="submit" class="black-button">ログイン</button>
            </div>

        </form>
    </div>
    <div class="transition-form">
        <h1>初めてのご利用の方はこちら</h1>
        <button class="normal-button">新規会員登録へ</button>
    </div>
    <!-- </div> -->
</body>

</html>