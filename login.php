<?php
require_once('./functions.php');
session_start();

/*
 * 普通にアクセスした場合: GETリクエスト
 * 登録フォームからSubmitした場合: POSTリクエスト
 */
// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 送られた値を取得
    $username = $_POST['username'];
    $password = $_POST['password'];

    /**
     * 入力値チェック
     */
    // 未入力の項目があるか
    if (empty($username) || empty($password)) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: login.php");
        return;
    }

    /**
     * 認証
     */
    $db = connectDb();
    // 送られたusernameを使ってDBを検索する
    $sql = 'SELECT * FROM users WHERE username = :username';
    $statement = $db->prepare($sql);
    $statement->execute(['username' => $username]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // ユーザーが取得できなかったら、それは入力されたusernameが間違っているということ
    if (!$user) {
        $_SESSION["error"] = "入力した情報に誤りがあります。";
        header("Location: login.php");
        return;
    }

    // パスワードとパスワード確認が一致しているか
    if (crypt($password, $user['password']) !== $user['password']) {
        $_SESSION["error"] = "入力した情報に誤りがあります。";
        header("Location: login.php");
        return;
    }

    // ログイン処理
    // ユーザー情報をセッションに格納する
    $_SESSION["user"]["id"] = $user['id'];
    $_SESSION["user"]["username"] = $user['username'];

    $_SESSION["success"] = "ログインしました。";
    header("Location: index.php");
}

?>

<html lang="ja">
<head>
    <meta charset="utf-8">
        <link href="login.css" rel="stylesheet">
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

    <!-- Success Message -->
    <?php if(!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="success">
            <pre><?php echo $_SESSION['success']; ?></pre>
            <?php $_SESSION['success'] = null; ?>
        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if(!empty($_SESSION['error'])): ?>
        <div>
            <pre><?php echo $_SESSION['error']; ?></pre>
            <?php $_SESSION['error'] = null; ?>
        </div>
    <?php endif; ?>

    <div class="boxWrap">
            <div class="box">
                <form action="" method="post" id="form">
                    <div align="center">
                    <h1>ログイン</h1>
                    <input type="text" name="username" class="formstyle" id="username-input" placeholder="ユーザ名">
                    <br>
                    <input type="password" name="password" class="formstyle" id="password-input" placeholder="パスワード">
                    </div>
                    <input type="submit" class="menu-btn" value="ログイン">
                </form>
            </div>
    </div>


</body>
</html>