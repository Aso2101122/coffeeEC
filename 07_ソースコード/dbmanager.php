<?php
function getDb()
{
    // データベースへの接続を確認
    $dsn = 'mysql:host=mysql152.phy.lolipop.lan;
    dbname=LAA1290588-coffeeec;
    charset=utf8';
    $username = 'LAA1290588';
    $password = 'Aso5han';
    $pdo = new PDO($dsn, $username, $password);
    return $pdo;
}
