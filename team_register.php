<?php
// functions.phpを読み込む. よく使う処理をまとめた関数を定義している
require_once('functions.php');
// セッションを利用する
session_start();

/*
 * 普通にアクセスした場合: GETリクエスト
 * 登録フォームからSubmitした場合: POSTリクエスト
 */
// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 送られた値を変数に格納
    $team_name = $_POST['name'];

 // 未入力の項目があるか
    if (empty($team_name)) {
        $_SESSION["error"] = "入力されていません";
        header("Location: team_register.php");
        return;
    }

    // DB接続
    $db = connectDb();  // ※ この関数はfunctions.phpに定義してある
    // DBにインサート
    $sql = "INSERT INTO teams(name) VALUES(:name)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':name' => $team_name,
    ]);
    if (!$result) {
        die('Database Error');
    }

    // セッションにメッセージを格納
    $_SESSION["success"] = "登録が完了しました。";
    // ログイン画面に遷移
    header("Location: index.php");
    }   
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="UTF-8"/>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		<title>チーム新規作成</title>
	</head>
	<body>
        <div class="container">
		<h1>チーム新規作成</h1>
		<form action="" method="post">
			<input type="text" name="name" class="form-control1" id="teamname" placeholder="チーム名"><br>
			<input type="submit" class="btn btn-info btn-lg" value="登録">
		</form>
        </div>
	</body>
</html>
