<!-- テスト用 -->
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
        <form action="menber-add.php" method="post">
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
                <input type="mail" name="mail" class="input-text" /><br>
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
        <button class="normal-button">ログインへ</button>
    </div>
    <!-- </div> -->
</body>

</html>