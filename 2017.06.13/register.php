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
    $game_name = $_POST['gamename'];
    $team_name = $_POST['teamname'];
    $place_name = $_POST['place'];
    /*$no_1 = $_POST['no1'];
    $no_2 = $_POST['no2'];
    $no_3 = $_POST['no3'];
    $no_4 = $_POST['no4'];
    $no_5 = $_POST['no5'];
    $no_6 = $_POST['no6'];
    $no_7 = $_POST['no7'];
    $no_8 = $_POST['no8'];
    $no_9 = $_POST['no9'];
    $no_10 = $_POST['no10'];
    $no_11 = $_POST['no11'];
    $no_12 = $_POST['no12'];
    $no_13 = $_POST['no13'];
    $no_14 = $_POST['no14'];
    $member_1 = $_POST['member1'];
    $member_2 = $_POST['member2'];
    $member_3 = $_POST['member3'];
    $member_4 = $_POST['member4'];
    $member_5 = $_POST['member5'];
    $member_6 = $_POST['member6'];
    $member_7 = $_POST['member7'];
    $member_8 = $_POST['member8'];
    $member_9 = $_POST['member9'];
    $member_10 = $_POST['member10'];
    $member_11 = $_POST['member11'];
    $member_12 = $_POST['member12'];
    $member_13 = $_POST['member13'];
    $member_14 = $_POST['member14'];
    */
    /**
     * 入力値チェック
     */
    // 未入力の項目があるか
    if (empty($game_name) || empty($team_name) || empty($place_name)) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: register.php");
        return;
    }

    // DB接続
    $db = connectDb();  // ※ この関数はfunctions.phpに定義してある
    // DBにインサート
    $sql = "INSERT INTO Gameinfo(gamename, teamname, place) VALUES(:gamename, :teamname, :place)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':gamename' => $game_name,
        ':teamname' => $team_name,
        ':place' => $place_name,
    ]);
    if (!$result) {
        die('Database Error');
    }

    // セッションにメッセージを格納
    $_SESSION["success"] = "登録が完了しました。ログインしてください。";
    // ログイン画面に遷移
    header("Location: input.php");
    }

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="UTF-8"/>
		<link href="register.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		<script src="./js/bootstrap.min.js"></script>
		<title>新規登録</title>
	</head>
	<body>
		<h1 class="text-center">新規登録</h1>
		<section id="main" class="container 75%">
            <div class="box">
			<form action="" method="post">
				<div class="form-group">
            		<!--<label class="control-label" for="gamename-input">試合名</label><br>-->
            		<input type="text" name="gamename" class="form-control1" id="gamename-input" placeholder="試合名"><br>
            		<!--<label for="teamname-input">チーム名</label><br>-->
            		<input type="text" name="teamname" class="form-control1" id="teamname-input" placeholder="チーム名"><br>
        			<!--<label for="place-input">試合会場</label><br>-->
        			<input type="text" name="place" class="form-control1" id="place-input" placeholder="試合会場"><br>


                    <!--<input type="text" name="no1" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member1" class="form-control2" id="member1-input" placeholder="メンバー"><br>

                    <input type="text" name="no2" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member2" class="form-control2" id="member2-input" placeholder="メンバー"><br>

                    <input type="text" name="no3" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member3" class="form-control2" id="member3-input" placeholder="メンバー"><br>

                    <input type="text" name="no4" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member4" class="form-control2" id="member4-input" placeholder="メンバー"><br>

                    <input type="text" name="no5" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member5" class="form-control2" id="member5-input" placeholder="メンバー"><br>

                    <input type="text" name="no6" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member6" class="form-control2" id="member6-input" placeholder="メンバー"><br>

                    <input type="text" name="no7" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member7" class="form-control2" id="member7-input" placeholder="メンバー"><br>

                    <input type="text" name="no8" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member8" class="form-control2" id="member8-input" placeholder="メンバー"><br>

                    <input type="text" name="no9" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member9" class="form-control2" id="member9-input" placeholder="メンバー"><br>

                    <input type="text" name="no10" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member10" class="form-control2" id="member10-input" placeholder="メンバー"><br>

                    <input type="text" name="no11" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member11" class="form-control2" id="member11-input" placeholder="メンバー"><br>

                    <input type="text" name="no12" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member12" class="form-control2" id="member12-input" placeholder="メンバー"><br>

                    <input type="text" name="no13" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member13" class="form-control2" id="member13-input" placeholder="メンバー"><br>

                    <input type="text" name="no14" class="form-control2" id="place-input" placeholder="背番号">
                    <input type="text" name="member14" class="form-control2" id="member14-input" placeholder="メンバー"><br>
                    -->
                </div>
        	<input type="submit" class="btn btn-info btn-lg" value="登録">
    		</form>
    		</div>
    	</section>
	</body>
</html>