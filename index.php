<?php
require_once('./functions.php');
session_start();

// DB接続
$db = connectDB(); // ※ この関数はfunctions.phpに定義してある
// 全記事を降順に取得するSQL文
$sql = 'SELECT * FROM teams ORDER BY id';
// SQLを実行
$statement = $db->query($sql);
// 以下4行で、取得した記事を配列$articlesに格納している
$teams = [];
foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $team ) {
    $teams[]= $team;
}

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="UTF-8"/>
		<link href="index.css" rel="stylesheet">
		<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		<title>Volley Analysis</title>
		<style type="text/css">

            body {
                background-color: #ffdc00;
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
		<div class="container">
		<div class="row">
			<div class="list-group">
        	<ul style="list-style-type:none; padding-left: 1em;">
            <?php foreach($teams as $team): ?>
                <li class='article'>
           			<a href="./team.php?id=<?php echo $team['id'];?>" class="list-group-item">
           				<?php echo h($team['name']); ?>
           			</a>
                </li>
            <?php endforeach; ?>
        	</ul>
        	</div>
    	</div>

		<a href="team_register.php">
		<button type="button" class="btn btn-info btn-lg">
			<span class="glyphicon glyphicon-edit">
			</span>
			チームを新規作成
		</button>
		</a>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>