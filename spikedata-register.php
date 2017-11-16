<?php
require_once('./functions.php');
session_start();

$id = $_GET['id'];

// DB接続
$db = connectDB(); // ※ この関数はfunctions.phpに定義してある
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
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
            <link href="data-register.css" rel="stylesheet">
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
            <script src="./js/bootstrap.min.js"></script>
            <title>データ入力</title>
    </head>

    <body>
        <div class="container">
            <div class="box1">
            <h1><?php echo h($team['name']); ?></h1>
            <hr>
            </div>

            <div class="box2">
                <a href="servedata-register.php?id=<?php echo $team['id'];?>">
                <button type="button" class="btn btn-info btn-lg layout1">サーブ</button></a>

                <a href="./spikedata-register.php?id=<?php echo $team['id'];?>">
                <button type="button" class="btn btn-info btn-lg layout1">スパイク</button></a>

                <div class="row">
                    <ul style="list-style-type:none; padding-left: 4em;">
                        <?php foreach($members as $member): ?>
                            <li class='article'>
                                <button type="button" class="btn btn-default layout2">
                                <span class="glyphicon glyphicon-user"></span>
                                <?php echo h($member['play_number']); ?>
                            　   <?php echo h($member['nickname']); ?></button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="box4">
            <a href="./team.php?id=<?php echo $team['id'];?>">
            <button type="button" class="btn btn-danger btn-lg layout1">終了</button>
            </a>
            </div>

            <div class="box3-left">
                <button id ="hode" type="button" class="btn btn-default layout4" name="out1">out1</button>
            </div>

            <div class="box3">
                <a class="circle" name="left"></a>
                <a class="circle" name="center"></a>
                <a class="circle" name="right"></a>
                <br>
                
                <button id ="al" type="button" class="btn btn-default layout3" name="al">al</button>
                <button id ="ac" type="button" class="btn btn-default layout3" name="ac">ac</button>
                <button id ="ar" type="button" class="btn btn-default layout3" name="ar">ar</button><br>

                <button id ="hoge" type="button" class="btn btn-default layout3" name="fl">fl</button>
                <button id ="hoge" type="button" class="btn btn-default layout3" name="fc">fc</button>
                <button id ="hoge" type="button" class="btn btn-default layout3" name="fr">fr</button><br>

                <button id ="hoge" type="button" class="btn btn-default layout3" name="bl">bl</button>
                <button id ="hoge" type="button" class="btn btn-default layout3" name="bc">bc</button>
                <button id ="hoge" type="button" class="btn btn-default layout3" name="br">br</button><br>
                <button id ="hoge" type="button" class="btn btn-default layout6" name="out3">out3</button>
            </div>
            <div class="box3-right">
                <button id="hoge" type="button" class="btn btn-default layout5" name="out2">out2</button>

        </div>        

    </body>
    <script src="data-register.js"></script>
</html>