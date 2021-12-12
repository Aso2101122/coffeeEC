<?php
//セッションの管理の開始
session_start();

//①セッション変数の解除
$_SESSION = array();

//②ブラウザにクッキーとして記録されているセッションIDを破棄する
if(isset($_COOKIE[session_name()])==true){
    setcookie(session_name(),'',time()-42000,'/');
}
//③サーバー側のセッションを破壊する
session_destroy();

header('Location: ./index.php');
exit();
?>