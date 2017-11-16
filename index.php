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
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="index.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		<title>Volley Analysis</title>
	</head>
	<body>
		<div class="container">
		<nav class="navbar navbar-right">
  		<ul class="nav navbar-nav">
  			<li class="active"><a href="#">HOME</a></li>
 			<li><a href="#">SERVICE</a></li>
  			<li><a href="#">BLOG</a></li>
  			<li><a href="#">ABOUT</a></li>
  			<li><a href="#">ABOUT</a></li>
  		</ul>
		</nav>
	    <div class="box1">
		<h1>Volley Analysis</h1>
        </div>
		<div class="row">
        	<ul style="list-style-type:none; padding-left: 1em;">
            <?php foreach($teams as $team): ?>
                <li class='article'>
           			<a href="./team.php?id=<?php echo $team['id'];?>">
           				<?php echo h($team['name']); ?>
           			</a>
                    <hr>
                </li>
            <?php endforeach; ?>
        	</ul>
    	</div>

		<a href="team_register.php">
		<button type="button" class="btn btn-info btn-lg layout">
			<span class="glyphicon glyphicon-edit layout">
			</span>
			チームを新規作成
		</button>
		</a>
		</div>
	</body>
</html>