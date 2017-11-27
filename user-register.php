<?php
// functions.phpを読み込む. よく使う処理をまとめた関数を定義している
require_once('./functions.php');
// セッションを利用する
session_start();

/*
 * 普通にアクセスした場合: GETリクエスト
 * 登録フォームからSubmitした場合: POSTリクエスト
 */
// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 送られた値を変数に格納
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password-confirmation'];

    /**
     * 入力値チェック
     */
    // 未入力の項目があるか
    if (empty($username) || empty($password) || empty($password_confirmation)) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: user-register.php");
        return;
    }

    // パスワードとパスワード確認が一致しているか
    if ($password !== $password_confirmation) {
        $_SESSION["error"] = "パスワードが一致しません";
        header("Location: user-register.php");
        return;
    }


    /**
     * 登録処理
     */
    // DB接続
    $db = connectDb();  // ※ この関数はfunctions.phpに定義してある
    // DBにインサート
    $sql = "INSERT INTO users(username, password) VALUES(:username, :password)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':username' => $username,
        ':password' => crypt($password),
    ]);
    if (!$result) {
        die('Database Error');
    }

    // セッションにメッセージを格納
    $_SESSION["success"] = "登録が完了しました。ログインしてください。";
    // ログイン画面に遷移
    header("Location: login.php");
}
?>

<html lang="ja">
<head>
    <meta charset="utf-8">
        <link href="user-register.css" rel="stylesheet">
        <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
        <title>チーム新規作成</title>
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
                        <li><button class="menu-btn" onclick="location.href='index.php'">トップページ</button></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle menu-btn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo h(loginUser()['username']); ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="./logout.php">ログアウト</a></li>
                                <li><a href="./mypage.php">マイページ</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            </div>
        </header>
    <!-- Error Message -->
    <?php if(!empty($_SESSION['error'])): ?>
        <div>
            <pre><?php echo $_SESSION['error']; ?></pre>
            <?php $_SESSION['error'] = null; ?>
        </div>
    <?php endif; ?>
    <div class="boxWrap">
            <div class="box">
    <!-- 登録フォーム -->
    <form method="post" action="" id="form">
        <div align="center">
            <h2>アカウント登録</h2>
            <input type="text" name="username" class="formstyle" id="username-input" placeholder="ユーザ名">
            <input type="password" name="password" class="formstyle" id="password-input" placeholder="パスワード">
            <input type="password" name="password-confirmation" class="formstyle" id="password-confirmation-input" placeholder="パスワード確認">
        </div>
        <input type="submit" class="menu-btn" value="登録">
    </form>
</div>
</div>

</body>
</html>
