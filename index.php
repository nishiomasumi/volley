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
					<li><button class="menu-btn" onclick="location.href='index.php'"><span class="glyphicon glyphicon-home">
			</span> TOP</button></li>
					<li><button class="menu-btn" onclick="location.href='login.php'">ログイン</button></li>
					<li><button class="menu-btn" onclick="location.href='user-register.php'">アカウント登録</button></li>
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
		<!--<div class="row">-->
			<div id="nav">
        	<ul style="list-style-type:none; padding-left: 1em;">
            <?php foreach($teams as $team): ?>
                <li>
           			<!--<a href="./team.php?id=<?php echo $team['id'];?>">-->
           			<button class="index-btn" onclick="location.href='team.php?id=<?php echo $team['id'];?>'">
       				<?php echo h($team['name']); ?>
       				</button>
           			<!--</a>-->
                </li>
            <?php endforeach; ?>
        	</ul>
        	</div>
    	<!--</div>-->
    	<div id="center">
		<a class="plus" href="team_register.php">＋<br></a>
		</div>
		<!--<button class="btn btn-default" onclick="location.href='https://docs.google.com/forms/d/e/1FAIpQLScERUClyJHePNdJrzBASOxHo9H0Pz1n_aqoYszbXsdqwqEAvg/viewform?usp=sf_link'">システムに関するアンケート</button>
		<button class="btn btn-default" onclick="location.href='https://docs.google.com/forms/d/e/1FAIpQLSc2rpKeUmKAeqd6otaj8IpaRWoX2PsWv86YwoBkUWYCPmJtoA/viewform?usp=sf_link'">記録用紙に関するアンケート</button>
		<button class="btn btn-default" onclick="location.href='https://docs.google.com/forms/d/e/1FAIpQLSfuNfrd-dqUY36UeCPjEL4zibHnEClnm02X4smlhyrmJnAlug/viewform?usp=sf_link'">
		比較アンケート</button>-->
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>