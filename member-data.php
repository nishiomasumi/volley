<?php
require_once('./functions.php');
session_start();

$id = $_GET['id'];
$member_id = $_GET['member_id'];
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
            <link href="member-data.css" rel="stylesheet">
            <link href="index.css" rel="stylesheet">
            <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
            <script src="./js/bootstrap.min.js"></script>
            <title>メンバーデータ</title>
            <script>
                var data = {};
                function setType(type){
                    //data['member_id'] = <?php echo $member_id; ?>;
                    data['type'] = type;
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
                function send(){
                    $.ajax({
                        type: "POST",
                        url: "test.php?member_id=<?php echo $member_id;?>",
                        data: data,
                        dataTypr: "json",
                        success:function(responce) {
                        // post.php 内で echo されたものが一応帰ってくる。
                        var paneldata = JSON.parse(responce);
                        console.log(paneldata);
                        var positions = ['al','ac','ar','fl','fc','fr','bl','bc','br'];
                        positions.forEach(function(value){
                            document.getElementById(value).style.backgroundColor = paneldata[value].color;
                            var info = document.getElementById(value);
                            info.textContent = paneldata[value].count;
                        });
                        /*for(var i = 0; i < 9; i++){
                            document.getElementById(i).style.backgroundColor = paneldata[i].color;
                            var info = document.getElementById(i);
                            var textNode = document.createTextNode(paneldata[i].count);
                            info.replaceChild(textNode, firstChild); 
                        }*/
                        },
                        error:function(){
                        // 通信失敗時の処理
                        console.log("通信に失敗しました。");
                        }
                    });  
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
            <h1 id="yoko"><?php echo h($team['name']); ?></h1>
            <hr>
            </div>

            <div class="box2">
                <button id="serve" type="button" name="serve" class="btn btn-info btn-lg layout1 typebtn" onclick="setType('serve')">サーブ</button></a>

                <button id="spike" type="button" name="spike" class="btn btn-info btn-lg layout1 typebtn" onclick="setType('spike')">スパイク</button></a>
            </div>

            <div class="box4">
            </div>

            <div class="box3-left">
               <div id ="out1" class="panel4 color" name="out1"></div> 
            </div>

            <div class="box3">
                <a id="left" class="circle frombtn" name="left" onclick="setAttackPosition('left'), send()"></a>
                <a id="center" class="circle frombtn" name="center" onclick="setAttackPosition('center'), send()"></a>
                <a id="right" class="circle frombtn" name="right" onclick="setAttackPosition('right'), send()"></a>
                <br>
                
                <div id ="al" class="panel1 color count" name="0"></div>
                <div id ="ac" class="panel1 color count" name="1"></div>
                <div id ="ar" class="panel1 color count" name="2"></div>
                
                <div id ="fl" class="panel1 color count" name="fl"></div>
                <div id ="fc" class="panel1 color count" name="fc"></div>
                <div id ="fr" class="panel1 color count" name="fr"></div>
                
                <div id ="bl" class="panel1 color count" name="bl"></div>
                <div id ="bc" class="panel1 color count" name="bc"></div>
                <div id ="br" class="panel1 color count" name="br"></div>

                <div id ="out3" class="panel2 color" name="out3"></div>
            </div>
            <div class="box3-right">
                <div id ="out2" class="panel3 color" name="out2"></div>
        </form>
        </div>        

    </body>
</html>