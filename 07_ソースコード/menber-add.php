<?php ob_start();
session_start();
require("./dbmanager.php");
$pdo = getDb();
$error = null;
$post_data[] = ['mail'=>'a','password'=>'a','first-name'=>'a','last-name'=>'a'];
$post_key = array('mail', 'password', 'first-name', 'last-name');
if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    for ($i = 0; $i < 4; $i++) {
        if (isset($_POST[$post_key[$i]])) {
            if ($_POST[$post_key[$i]] === "") {
                $error[$post_key[$i]] = "blank";
            } else {
                $post_data[0][$post_key[$i]] = $_POST[$post_key[$i]];
            }
        } else {
            $error[$post_key[$i]] = "blank";
            $post_data[0][$post_key[$i]] = "";
        }
    }


    /* メールアドレスの重複を検知 */
    if (!isset($error)) {
        $sql = $pdo->prepare('SELECT COUNT(*) as cnt FROM m_user WHERE mail=?');
        $sql->execute(array($_POST['mail']));
        $record = $sql->fetchAll(PDO::FETCH_ASSOC);
        if ($record[0]['cnt'] != 0) {
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
}else {
    for($i = 0; $i < 4; $i++) {
        $post_data[0][$post_key[$i]] = "";
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
                    <input type="text" placeholder="山田" name="first-name" class="lastname value="<?= $post_data[0]['first-name'] ?>" /><br>
                    <input type="text" placeholder="太郎" name="last-name" class="firstname value="<?= $post_data[0]['last-name'] ?>" /><br>
                </div>
                <?php if (isset($error['last-name']) || isset($error['first-name'])){ ?>
                    <span class="error">＊お名前が入力されていません</span>
                <?php } ?>
            </div>
            <div class="form-parts">
                <span class="tag">メールアドレス</span>
                <span class="mandatory">必須</span><br>
                <input type="mail" name="mail" class="input-text" value="<?= $post_data[0]['mail'] ?>"/><br>
                <?php if (isset($error['mail'])){
                    if($error['mail'] == 'mismatch'){
                ?>
                    <span class="error">＊このメールアドレスはすでに登録済みです</span>
                <?php
                    }
                }
                ?>
                <?php if (isset($error['mail'])){
                    if($error['mail'] == 'blank'){
                ?>
                    <span class="error">＊メールアドレスが入力されていません</span>
                <?php
                    }
                }
                ?>
            </div>

            <div class="form-parts">
                <span class="tag">パスワード</span>
                <span class="mandatory">必須</span><br>
                <input type="password" name="password" class="input-text" value="<?= $post_data[0]['password'] ?>"/>
                <?php if (isset($error['password'])){ ?>
                    <span class="error">＊パスワードが入力されていません</span>
                <?php } ?>
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