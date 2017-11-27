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
//print_r($members);
$nickname = array_column($members, 'nickname');
$member_id = array_column($members, 'id');
//print_r($member_id);

$jsontest = json_encode($nickname);

$sql2 = 'SELECT * FROM teams WHERE id = :id';
// SQLを実行
$statement2 = $db->prepare($sql2);
$statement2->execute(['id' => $_GET['id']]);
$team = $statement2->fetch(PDO::FETCH_ASSOC);


//サーブ総数
$servetotals = [];
foreach($member_id as $i){
    $sql3 = "SELECT COUNT(*) FROM data WHERE member_id = $i AND type = 'serve'";
    $statement3 = $db->query($sql3);
    $servetotal = $statement3->fetchColumn();
    //print($servetotal);
    $servetotals[] = $servetotal;   
}

//print_r($servetotals);
$jsontest1 = json_encode($servetotals);

//サーブ決まった数
$servescores = [];
foreach($member_id as $j){
    $sql4 = "SELECT COUNT(*) FROM data WHERE member_id = $j AND type = 'serve' AND scored = '1'";
    $statement4 = $db->query($sql4);
    $servescore = $statement4->fetchColumn();
    $servescores[] = $servescore;
}
//print_r($servescores);
$jsontest2 = json_encode($servescores);

//スパイク総数
$spiketotals = [];
foreach ($member_id as $k) {
    $sql4 = "SELECT COUNT(*) FROM data WHERE member_id = $k AND type = 'spike'";
    $statement4 = $db->query($sql4);
    $spiketotal = $statement4->fetchColumn();
    $spiketotals[] = $spiketotal;
}
//print_r($spiketotals);
$jsontest3 = json_encode($spiketotals);

//スパイクが決まった数
$spikescores = [];
foreach($member_id as $l){
    $sql5 = "SELECT COUNT(*) FROM data WHERE member_id = $l AND type = 'spike' AND scored = '1'";
    $statement5 = $db->query($sql5);
    $spikescore = $statement5->fetchColumn();
    $spikescores[] = $spikescore;
}
//print_r($spikescores);
$jsontest4 = json_encode($spikescores);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8"/>
        <link href="index.css" rel="stylesheet">
		<link href="data.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
		<title><?php echo h($team['name']); ?></title>
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
                    <button type="button" class="menu-btn">ログイン</button>
                    <button type="button" class="menu-btn">ログアウト</button>
                    <button type="button" class="menu-btn">アカウント登録</button>
            </div>
    </header>   
	<div class="container">
		<h1><?php echo h($team['name']); ?></h1>
		<div class="box1">
		<h2>サーブ得点率</h2>
		<canvas id="graph-serve"></canvas>
    <script>
		var ctx = document.getElementById("graph-serve");
		var nickname=JSON.parse('<?php echo  $jsontest; ?>');
        var servetotal = JSON.parse('<?php echo $jsontest1; ?>');
        var servescore = JSON.parse('<?php echo $jsontest2; ?>');
        var n = 2;
        var serverate = [];
        for(var i = 0; i < nickname.length; i++){
            var a = servescore[i]/servetotal[i]*100;
            serverate[i] = Math.floor((a*Math.pow(10,n))/Math.pow(10,n));
            //document.write(a);
        }
		var myChart = new Chart(ctx, {
    		type: 'bar',
    		data: {
        		labels: nickname,
        	datasets: [{
            	label: '%',
            	data: serverate,
            	backgroundColor: [
                	'rgba(0, 192, 239, 0.2)',
                	'rgba(0, 192, 239, 0.2)',
                	'rgba(0, 192, 239, 0.2)',
                	'rgba(0, 192, 239, 0.2)',
                	'rgba(0, 192, 239, 0.2)',
                    'rgba(0, 192, 239, 0.2)',
                    'rgba(0, 192, 239, 0.2)'
            	],
            	borderColor: [
                	'rgba(0, 192, 239, 1)',
                	'rgba(0, 192, 239, 1)',
                	'rgba(0, 192, 239, 1)',
                	'rgba(0, 192, 239, 1)',
                	'rgba(0, 192, 239, 1)',
                    'rgba(0, 192, 239, 1)',
                    'rgba(0, 192, 239, 1)'
            	],
            	borderWidth: 1
        	}]
    		},
    		options: {
        		scales: {
            		yAxes: [{
                		ticks: {
                    	beginAtZero:true,
                        min: 0,
                        max: 50
                		}
            		}]
        		}
    		}
		});
		</script>
		</div>
		<div class="box2">
		<h2>スパイク決定率</h2>
		<canvas id="graph-spike"></canvas>
		<script>
		var ctx = document.getElementById("graph-spike");
        var spiketotal = JSON.parse('<?php echo $jsontest3; ?>');
        var spikescore = JSON.parse('<?php echo $jsontest4; ?>');
        var spikerate = [];
        for(var i = 0; i < nickname.length; i++){
            var a = spikescore[i]/spiketotal[i]*100;
            var n = 2;
            spikerate[i] = Math.floor((a*Math.pow(10,n))/Math.pow(10,n));
            //document.write(a);
        }
		var myChart = new Chart(ctx, {
    		type: 'bar',
    		data: {
        		labels: nickname,
        	datasets: [{
            	label: '%',
            	data: serverate,
            	backgroundColor: [
                	'rgba(255, 140, 0, 0.2)',
                	'rgba(255, 140, 0, 0.2)',
                	'rgba(255, 140, 0, 0.2)',
                	'rgba(255, 140, 0, 0.2)',
                	'rgba(255, 140, 0, 0.2)',
                	'rgba(255, 140, 0, 0.2)',
                    'rgba(255, 140, 0, 0.2)',
                    'rgba(255, 140, 0, 0.2)'
            	],
            	borderColor: [
                	'rgba(255,140,0,1)',
                	'rgba(255,140,0,1)',
                	'rgba(255,140,0,1)',
                	'rgba(255,140,0,1)',
                	'rgba(255,140,0,1)',
                	'rgba(255,140,0,1)',
                    'rgba(255, 140, 0, 1)',
                    'rgba(255, 140, 0, 1)'
            	],
            	borderWidth: 1
        	}]
    		},
    		options: {
        		scales: {
            		yAxes: [{
                		ticks: {
                    	beginAtZero:true,
                        min: 0,
                        max: 50
                		}
            		}]
        		}
    		}
		});
		</script>
		</div>
        <div class="box3">
            <?php foreach($members as $member): ?>
                <a href="member-data.php?id=<?php echo $team['id'];?>&member_id=<?php echo $member['id'];?>">
                <div class="col-sm-2">    
                <div class="panel panel-primary color">
                    <span class="glyphicon glyphicon-user layout"></span>
                <div class="panel-body text-center"><?php echo h($member['nickname']); ?></div>
                </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
	</body>
</html>

