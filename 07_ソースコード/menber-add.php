<?php ob_start();
session_start();
require("./dbmanager.php");
$pdo = getDb();
$error = null;
if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if(isset($_POST['mail'])){
        if ($_POST['mail'] === "") {
            $error['mail'] = "blank";
        }
    }
    if(isset($_POST['password'])){
        if ($_POST['password'] === "") {
            $error['password'] = "blank";
        }
    }
    /* メールアドレスの重複を検知 */
    if (!isset($error)) {
        $sql = $pdo->prepare('SELECT COUNT(*) as cnt FROM m_user WHERE mail=?');
        $sql->execute(array($_POST['mail'],$_POST['password']));
        $record = $sql->fetchAll();
        if ($record['cnt'] === 1) {
            $error['mail'] = 'mismatch';
        }
    }
 
//    エラーがなければ登録する
    if (!isset($error)) {
        $sql = $pdo->prepare('INSERT INTO m_user(mail, password, last_name, first_name) VALUES(?,?,?,?)');
        $sql->execute(array($_POST['mail'],$_POST['password'],$_POST['first-name'],$_POST['last-name']));

        //セッションに情報を追加
        $sql = $pdo->prepare('SELECT * FROM m_user WHERE mail=?');
        $sql->execute([$_POST['mail']]);
        $user_info = $sql->fetchALL(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $user_info[0];
        header('Location: index.php');   // check.phpへ移動
        exit();
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
    <!-- フォント読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <?php require "global-menu.php" ?>
    <!-- <div class="main-content"> -->
    <div class="menber-ship-form">
        <form action="./menber-add.php" method="post">
            <h1>新規会員登録</h1>
            <div class="form-parts">
                <span class="tag">お名前</span>
                <span class="mandatory">必須</span><br>
                <div class="name-contener">
                    <input type="text" placeholder="山田" name="first-name" class="lastname" />
                    <input type="text" placeholder="太郎" name="last-name" class="firstname" />
                </div>

            </div>
            <div class="form-parts">
                <span class="tag">メールアドレス</span>
                <span class="mandatory">必須</span><br>
                <input type="mail" name="mail" class="input-text"/><br>
                <?php if (isset($error['mail'])){
                    if($error['mail'] == 'mismatch'){
                ?>
                    <span class="error">＊このメールアドレスはすでに登録済みです</span>
                <?php
                    }
                }
                ?>
            </div>

            <div class="form-parts">
                <span class="tag">パスワード</span>
                <span class="mandatory">必須</span><br>
                <input type="password" name="password" class="input-text" /><br>
            </div>
            <div class="submit-button">
                <button type="submit" class="black-button">会員登録する</button>
            </div>

        </form>
    </div>
    <div class="transition-form">
        <h1>会員の方はこちら</h1>
        <button onclick="location.href='menber-login.php'" class="normal-button">ログインへ<img src="img/yazi3.png" class="arrow-img-black"></button>
    </div>
    <!-- </div> -->
</body>

</html>