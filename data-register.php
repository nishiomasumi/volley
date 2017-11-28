<?php
require_once('./functions.php');
session_start();

$id = $_GET['id'];
redirectIfNotLogin(); 
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
$login_id = loginUser()['id'];
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8"/>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
            <link href="data-register.css" rel="stylesheet">
            <link href="index.css" rel="stylesheet">
            <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
            <script src="./js/bootstrap.min.js"></script>
            <title>データ入力</title>
            <script>
            	var data = {};
                var clicked = false;    // クリック状態を保持するフラグ
                var login_id = <?php echo json_encode($login_id); ?>;
                function setType(type){
                    data['type'] = type;
                    data['login_id'] = login_id;
                    console.log(data);

                    // ボタンの色を戻す
                    var typebuttons = document.getElementsByClassName("typebtn");
                    for (var i = 0; i < typebuttons.length; i++) {
                        typebuttons[i].style.backgroundColor = "#49afcd";
                    }

                    // 押されたIDの色を変える
                    var typebutton = document.getElementById(type);
                    typebutton.style.backgroundColor = "#ff69b4";

                }
                function setMember(member_id){
                    data['member_id'] = member_id;

                    console.log(data);

                    // ボタンの色を戻す
                    var memberbuttons = document.getElementsByClassName("memberbtn");
                    for (var i = 0; i < memberbuttons.length; i++) {
                        memberbuttons[i].style.backgroundColor = "#ffffff";
                    }

                    // 押されたIDの色を変える
                    var memberbutton = document.getElementById(member_id);
                    memberbutton.style.backgroundColor = "#ff69b4";
                    }
            	function setAttackPosition(attack_from) {
                    data['attack_from'] = attack_from;

                    console.log(data);

                    // ボタンの色を戻す
                    var frombuttons = document.getElementsByClassName("frombtn");
                    for (var i = 0; i < frombuttons.length; i++) {
                        frombuttons[i].style.backgroundColor = "#ffffff";
                    }

                    // 押されたIDの色を変える
                    var frombutton = document.getElementById(attack_from);
                    frombutton.style.backgroundColor = "#ff69b4";

        		}

                function setPosition(attack_to){
                    data['attack_to'] = attack_to;

                    console.log(data);

                    var tobuttons = document.getElementsByClassName("typebtn");
                    for (var i = 0; i < tobuttons.length; i++) {
                        tobuttons[i].style.backgroundColor = "#49afcd";
                    }

                    var memberbuttons = document.getElementsByClassName("memberbtn");
                    for (var i = 0; i < memberbuttons.length; i++) {
                        memberbuttons[i].style.backgroundColor = "#ffffff";
                    }
                    
                    var tobuttons = document.getElementsByClassName("frombtn");
                    for (var i = 0; i < tobuttons.length; i++) {
                        tobuttons[i].style.backgroundColor = "#ffffff";
                    }

                    var tobuttons = document.getElementsByClassName("tobtn");
                    for (var i = 0; i < tobuttons.length; i++) {
                        tobuttons[i].style.backgroundColor = "#ffffff";
                    }

                    // 押されたIDの色を変える
                    var tobutton = document.getElementById(attack_to);
                    tobutton.style.backgroundColor = "#ff69b4";

                }

                function send(){
                    if (clicked) {
                        data['scored'] = 1;
                        clicked = false;
                        console.log(data);
                        $.ajax({
                        type: "POST",
                        url: "post.php?id=<?php echo $team['id'];?>",
                        data: data,
                        success:function(responce) {
                        // post.php 内で echo されたものが一応帰ってくる。
                        console.log(responce);
                        },
                        error:function(){
                        // 通信失敗時の処理
                        console.log("通信に失敗しました。");
                        }
                    });
                    return;
                    }

                    // シングルクリックを受理、300ms間だけダブルクリック判定を残す
                        clicked = true;
                    setTimeout(function () {
                    // ダブルクリックによりclickedフラグがリセットされていない
                    //     -> シングルクリックだった
                    if (clicked) {
                        //alert("single click!");
                        data['scored'] = 0;
                        console.log(data);
                        $.ajax({
                        type: "POST",
                        url: "post.php?id=<?php echo $team['id'];?>",
                        data: data,
                        success:function(responce) {
                        // post.php 内で echo されたものが一応帰ってくる。
                        console.log(responce);
                        },
                        error:function(){
                        // 通信失敗時の処理
                        console.log("通信に失敗しました。");
                        }
                    });
                    }

                        clicked = false;
                    }, 300);
                }

            </script>
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
        <div class="container">
        <form name="form">
            <div class="box1">
            <h1><?php echo h($team['name']); ?></h1>
            </div>
            

            <div class="box2">
                <button id="serve" type="button" name="serve" class="btn btn-info btn-lg layout1 typebtn" onclick="setType('serve')">サーブ</button></a>

                <button id="spike" type="button" name="spike" class="btn btn-info btn-lg layout1 typebtn" onclick="setType('spike')">スパイク</button></a>
                <div class="row">
                    <ul style="list-style-type:none; padding-left: 4em;">
                        <?php foreach($members as $member): ?>
                            <li class='article'>
                                <button id="<?php echo($member['id']) ?>" type="button" name="button3" class="btn btn-default layout2 memberbtn" onclick="setMember('<?php echo($member['id']) ?>')" >
                                <span class="glyphicon glyphicon-user"></span>
                                <?php echo h($member['play_number']); ?>
                            　   <?php echo h($member['nickname']); ?></button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="box4">
            <button id="miss" type="button" class="regi-btn" name="miss" onclick="setPosition('miss'), send()">ミス</button>
            <a href="./delete.php?id=<?php echo $team['id'];?>">
            <button type="button" class="regi-btn">修正</button></a>

            <!--<a href="./team.php?id=<?php echo $team['id'];?>">
            <button type="button" class="btn btn-danger btn-lg layout1">終了</button>
            </a>-->
            </div>
            <div class="box3-left">
                <button id ="out1" type="button" class="btn btn-default layout4" name="out1" onclick="setPosition('out1'), send(), loginUser()"></button>
            </div>

            <div class="box3">
                <a id="left" class="circle frombtn" name="left" onclick="setAttackPosition('left')"></a>
                <a id="center" class="circle frombtn" name="center" onclick="setAttackPosition('center')"></a>
                <a id="right" class="circle frombtn" name="right" onclick="setAttackPosition('right')"></a>
                <br>
             
                <button id ="al" type="button" class="btn btn-default layout3" name="al" onclick="setPosition('al'), send()"></button>
                <button id ="ac" type="button" class="btn btn-default layout3" name="ac" onclick="setPosition('ac'), send()"></button>
                <button id ="ar" type="button" class="btn btn-default layout3" name="ar" onclick="setPosition('ar'), send()"></button><br>

                <button id ="fl" type="button" class="btn btn-default layout3" name="fl" onclick="setPosition('fl'), send()"></button>
                <button id ="fc" type="button" class="btn btn-default layout3" name="fc" onclick="setPosition('fc'), send()"></button>
                <button id ="fr" type="button" class="btn btn-default layout3" name="fr" onclick="setPosition('fr'), send()"></button><br>

                <button id ="bl" type="button" class="btn btn-default layout3" name="bl" onclick="setPosition('bl'), send()"></button>
                <button id ="bc" type="button" class="btn btn-default layout3" name="bc" onclick="setPosition('bc'), send()"></button>
                <button id ="br" type="button" class="btn btn-default layout3" name="br" onclick="setPosition('br'), send()"></button><br>
                <button id ="out3" type="button" class="btn btn-default layout6" name="out3" onclick="setPosition('out3'), send()"></button>
            </div>
            <div class="box3-right">
                <button id="out2" type="button" class="btn btn-default layout5" name="out2" onclick="setPosition('out2'), send(), loginUser()"></button>
        </form>
        </div>        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>