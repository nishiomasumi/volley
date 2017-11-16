<?php

// DB接続
function connectDB()
{
    $config = require_once('config.php');
    $dsn = "mysql:dbname=" . $config['db']['database'] . ";host=" . $config['db']['host'];

    try {
        $db = new PDO($dsn, $config['db']['user'], $config['db']['password']);
    } catch (PDOException $e) {
        die('Connecting database failed:' . $e->getMessage());
    }

    return $db;
}

// ユーザーから入力された文字を安全な文字列に変換する(HTMLエスケープ)
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}