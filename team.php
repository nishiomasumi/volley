<?php
require_once('./functions.php');
session_start();

// URLに含まれている記事のIDを取得
$id = $_GET['id'];

// DB接続
$db = connectDB(); // ※ この関数はfunctions.phpに定義してある
// 全記事を昇順に取得するSQL文

$sql1 = "SELECT * FROM members WHERE team_id = $id ORDER BY play_number";
// SQLを実行
$statement1 = $db->query($sql1);
// 以下4行で、取得した記事を配列$articlesに格納している
$members = [];
foreach ($statement1->fetchAll(PDO::FETCH_ASSOC) as $member ) {
    $members[]= $member;
}

$sql2 = 'SELECT * FROM teams WHERE id = :id';
// SQLを実行
$statement2 = $db->prepare($sql2);
$statement2->execute(['id' => $_GET['id']]);
$team = $statement2->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="UTF-8"/>
		<link href="index.css" rel="stylesheet">
		<link href="team.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		<title><?php echo h($team['name']); ?></title>
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
					<button type="button" class="menu-btn">ログイン</button>
					<button type="button" class="menu-btn">ログアウト</button>
					<button type="button" class="menu-btn">アカウント登録</button>
			</div>
		</header>
	<div class="container">
		<h1><?php echo h($team['name']); ?></h1>
		<hr>
		<div class="container-fluid">
				<div class="row">
					<a href="data-register.php?id=<?php echo $team['id'];?>">
						<div class="col-lg-3 col-lg-offset-2 input-box">
							<span class="glyphicon glyphicon-edit layout white">
							</span>
							<p class="layout">データを入力</p>
						</div>
					</a>
					<a href="data.php?id=<?php echo $team['id'];?>">
						<div class="col-lg-3 col-lg-offset-2 data-box">
							<span class="glyphicon glyphicon-signal layout white">	
							</span>
							<p class="layout">データを見る</p>
						</div>
					</a>
				</div>
		</div>
		<hr>
		<h2>メンバー</h2>

		<div class="row">
        	<ul style="list-style-type:none; padding-left: 1em;">
            <?php foreach($members as $member): ?>
                <li class='article'>
           				<p>背番号：<?php echo h($member['play_number']); ?>
           				　　　名前：<?php echo h($member['nickname']); ?></p>
                    <hr>
                </li>
            <?php endforeach; ?>
        	</ul>
    	</div>


		<a href="./member_register.php?id=<?php echo $team['id']; ?>">
		<button type="button" class="btn btn-info btn-lg article">
		<span class="glyphicon glyphicon-edit white">
			</span>
			編集する
		</button>
        </a>
        </div>
	</body>
</html>