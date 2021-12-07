<?php ob_start();
require("./dbmanager.php");
$pdo = getDb();
session_start();
if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['mail'] === "") {
        $error['mail'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }
    
    /* メールアドレスの重複を検知 */
    if (!isset($error)) {
        $member = $pdo->prepare('SELECT COUNT(*) as cnt FROM m_user WHERE mail=? and password=?');
        $member->execute(array(
            $_POST['mail'],$_POST{'password'}
        ));
        $record = $member->fetch();
        if ($record['cnt'] != 1) {
            $error['mail'] = 'mismatch';
        }
    }
 
    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $_SESSION['user'] = $_POST;   // フォームの内容をセッションで保存
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
                <input type="text" placeholder="山田" name="firstname" class="lastname" />
                <input type="text" placeholder="太郎" name="lastname" class="firstname" /><br>
            </div>
            <div class="form-parts">
                <span class="tag">メールアドレス</span>
                <span class="mandatory">必須</span><br>
                <input type="mail" name="email" class="input-text" /><br>
            </div>
            <?php if (!empty($error["mail"]) && $error['mail'] === 'mismatch'): ?>
                <p class="error">＊このメールアドレスはすでに登録済みです</p>
            <?php endif ?>
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
        <button onclick="location.href='menber-login.php'" class="normal-button">ログインへ</button>
    </div>
    <!-- </div> -->
</body>

</html>