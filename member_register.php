<?php
// functions.phpを読み込む. よく使う処理をまとめた関数を定義している
require_once('functions.php');
// セッションを利用する
session_start();

$id = $_GET['id'];

// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 送られた値を変数に格納
    $play_number = $_POST['play_number'];
    $nickname = $_POST['nickname'];
    $team_id = $_POST['$id'];
   
 // 未入力の項目があるか
    /*if (empty($team_name)) {
        $_SESSION["error"] = "入力されていません";
        header("Location: team_register.php");
        return;
    }*/

    // DB接続
    $db = connectDb();  // ※ この関数はfunctions.phpに定義してある
	
    $sql = "INSERT INTO members(play_number, nickname, team_id) VALUES(:play_number, :nickname, '$id')";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':play_number' => $play_number,
        ':nickname' => $nickname,
    ]);
    if (!$result) {
        die('Database Error');
    }
    // セッションにメッセージを格納
    $_SESSION["success"] = "登録が完了しました。";
    // ログイン画面に遷移
    header("Location: team.php?id=$id"); 
}   

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="UTF-8"/>
		<link href="index.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		<script src="./js/bootstrap.min.js"></script>
		<title>メンバー編集</title>
	</head>
	<body>
		<div class="container">
		<h1>メンバー新規作成</h1>
		<form action="" method="post">
			<input type="text" name="play_number" class="form-control1" id="teamname" placeholder="背番号">
			<input type="text" name="nickname" class="form-control1" id="teamname" placeholder="名前"><br>
			<input type="submit" class="btn btn-info btn-lg" value="登録">
		</form>
		</div>
	</body>
</html>