<?php
// functions.phpを読み込む. よく使う処理をまとめた関数を定義している
require_once('functions.php');
// セッションを利用する
session_start();

$id = $_GET['id'];

if($_SERVER["REQUEST_METHOD"] === "POST"){

//$team_id = $_POST['$id'];
$type = $_POST['type'];
$member_id = $_POST['member_id'];
$attack_from = $_POST['attack_from'];
$attack_to = $_POST['attack_to'];
$scored = $_POST['scored'];
$login_id = $_POST['login_id'];

$db = connectDb();  // ※ この関数はfunctions.phpに定義してある
    
    $sql = "INSERT INTO data(team_id, member_id, type, attack_from, attack_to, scored, login_id) VALUES('$id', :member_id, :type, :attack_from, :attack_to, :scored, :login_id)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':member_id' => $member_id,
        ':type' => $type,
        ':attack_from' => $attack_from,
        ':attack_to' => $attack_to,
        ':scored' => $scored,
        ':login_id' => $login_id,
    ]);
    if (!$result) {
        die('Database Error');
    }
}

?>