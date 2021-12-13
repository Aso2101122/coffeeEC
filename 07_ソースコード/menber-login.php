<?php /*ob_start();*/
session_start();
require("./dbmanager.php");
$pdo = getDb();
if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['mail'] === "") {
        $error['mail'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }
    if (!isset($error)) {
        $member = $pdo->prepare('SELECT * FROM m_user WHERE mail=? AND password=?');
        $member->execute(array($_POST['mail'], $_POST['password']));
        $cnt = $member->rowCount();
        $record = $member->fetchALL(PDO::FETCH_ASSOC);
        //検索結果が0件の時や複数件あったとき
        if ($cnt != 1) {
            $error['result'] = 'mismatch';
        }
    }
    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $sql = $pdo->prepare('SELECT * FROM t_favorite_items WHERE user_id=?');
        $sql->execute([$record[0]['user_id']]);
        $favorite_items = $sql->fetchALL(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $record[0];   // フォームの内容をセッションで保存
        $_SESSION['favorite'] = $favorite_items;
        header('Location: ./index.php');
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
<?php require './global-menu.php'; ?>
<div class="menber-ship-form">
    <form action="menber-login.php" method="post">
        <h1>ログイン</h1>
        <div class="form-parts">
            <span class="tag">メールアドレス</span>
            <input type="text" id="mail" name="mail" class="input-text"><br>
        </div>
        <?php if (!empty($error["mail"]) && $error['mail'] === 'blank') : ?>
            <p class="error">＊メールアドレスを入力してください</p>
        <?php endif ?>
        <div class="form-parts">
            <span class="tag">パスワード</span>
            <input type="password" id="password" name="password" class="input-text" /><br>
            <?php if (!empty($error["password"]) && $error['password'] === 'blank') : ?>
                <p class="error">＊パスワードを入力してください</p>
            <?php endif ?>
        </div>
        <?php if (!empty($error["result"]) && $error['result'] === 'mismatch') : ?>
            <p class="error">＊メールアドレスかパスワードが間違っています。</p>
        <?php endif ?>
        <div class="submit-button">
            <button class="black-button" value="ログイン">ログイン</button>
        </div>
    </form>
</div>
<div class="transition-form">
    <h1>初めてのご利用の方はこちら</h1>
    <button onclick="location.href='menber-add.php'" class="normal-button">新規会員登録へ</button>
</div>
</body>

</html>