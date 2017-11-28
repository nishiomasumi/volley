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
    header('Location: team.php?id=$id'); 
}   

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="UTF-8"/>
		<link href="member_register.css" rel="stylesheet">
		<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		<script src="./js/bootstrap.min.js"></script>
		<title>メンバー編集</title>
        <style type="text/css">

            body {
                background-color: #191970;
            }

        </style>
	</head>
	<body>
        <header class="main-header sticky">
            <div id="container">
            <a href="index.php">
                <div id="itemA">
                    <div class="pen-title-text">
                    <img src="volleyball.svg" id="volleyball" width="60" height="60">
                    <h1 class="textstyle">Volley Analysis</h1>
                    </div>
                </div>
            </a>
            <div id="itemB">
                <nav>
                     <ul class="nav nav-pills pull-right">
                    <li><button class="menu-btn" onclick="location.href='index.php'"><span class="glyphicon glyphicon-home">
            </span> TOP</button></li>
                    <li><button class="menu-btn" onclick="location.href='login.php'">ログイン</button></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle dropdown-btn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo h(loginUser()['username']); ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="./logout.php">ログアウト</a></li>
                                <li><a href="./mypage.php">マイページ</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="boxWrap">
            <div class="box">
		      <form action="" method="post" id="form">
                <div align="center">
                    <h1 id="color">メンバー新規作成</h1>
			     <input type="text" name="play_number" class="formstyle" id="teamname" placeholder="背番号">
			     <input type="text" name="nickname" class="formstyle" id="teamname" placeholder="名前">
                 </div>
			     <input type="submit" class="menu-btn" value="登録">
		      </form>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
	</body>
</html>