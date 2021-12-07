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
        $member = $pdo->prepare('SELECT COUNT(*) as cnt FROM m_user WHERE mail=?');
        $member->execute(array(
            $_POST['mail']
        ));
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['mail'] = 'duplicate';
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

    <!-- <div class="main-content"> -->
    <div class="menber-ship-form">
        <form action="menber-login.php" method="post">
            <h1>ログイン</h1>
            <div class="form-parts">
                <span class="tag">メールアドレス</span>
                <input type="text" id="mail" name="mail" class="input-text" placeholder="メールアドレスを入力" ><br>
                <?php if (!empty($error["mail"]) && $error['mail'] === 'blank'): ?>
                    <p class="error">＊メールアドレスを入力してください</p>
                <?php elseif (!empty($error["mail"]) && $error['mail'] === 'duplicate'): ?>
                    <p class="error">＊このメールアドレスはすでに登録済みです</p>
                <?php endif ?>
            </div>
            <div class="form-parts">
                <span class="tag">パスワード</span>
                <input type="password" id="password" name="password" class="input-text" placeholder="パスワードを入力"/><br>
                <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
                    <p class="error">＊パスワードを入力してください</p>
                <?php endif ?>
            </div>
            <div class="submit-button">
                <input type="submit" id="login" name="login" class="black-button"value="ログイン">
            </div>
        </form>
    </div>
    <div class="transition-form">
        <h1>初めてのご利用の方はこちら</h1>
        <button onclick ="location.href='menber-add.php'"class="normal-button">新規会員登録へ</button>
    </div>
    <!-- </div> -->
</body>
</html>