<?php
require("./dbmanager.php");
$pdo = getDb();
session_start();
//ログイン状態の場合ログイン後のページにリダイレクト
if (isset($_SESSION["login"])) {
  session_regenerate_id(TRUE);
  header("Location: index.php");
  exit();
}

//postされて来なかったとき
if (count($_POST) === 0) {
  $message = "エラー";
}
//postされて来た場合
else {
  //メールアドレスまたはパスワードが送信されて来なかった場合
  if(empty($_POST["mail"]) || empty($_POST["password"])) {
    $message = "メールアドレスとパスワードを入力してください";
  }
  //メールアドレスとパスワードが送信されて来た場合
  else {
    //post送信されてきたユーザー名がデータベースにあるか検索
    try {
      $stmt = $pdo -> prepare('SELECT * FROM m_users WHERE mail=?');
      $stmt -> bindParam(1, $_POST['user_id'], PDO::PARAM_STR, 10);
      $stmt -> execute();
      $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOExeption $e) {
      exit('データベースエラー');
    }


    //検索したユーザー名に対してパスワードが正しいかを検証
    //正しくないとき
    if (!isset($row['mail'])) {
      echo 'メールアドレス又はパスワードが間違っています。';
      return false;
    }
    //パスワード確認後sessionにメールアドレスを渡す
    if (password_verify($_POST['password'], $row['password'])) {
      session_regenerate_id(true); //session_idを新しく生成し、置き換える
      $_SESSION['mail'] = $row['mail'];
      echo 'ログインしました';
    } else {
      echo 'メールアドレス又はパスワードが間違っています。';
      return false;
    }
    
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
                <input type="text" name="mail" class="input-text" /><br>
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
        <button onclick ="location.href='menber-add.php'"class="normal-button">新規会員登録へ</button>
    </div>
    <!-- </div> -->
</body>

</html>