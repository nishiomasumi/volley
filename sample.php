<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <script>

        var data = {};
        function addMenu(menu) {

            // 受け取った変数 menu を用いて
            // data['rice'] = 'rice' のようになるように代入
            data[menu] = menu;

            // 確認用に表示
            console.log(data);
        }

        function sendMenu() {
            // 送信する
            // data['rice'] = 'rice' および data['misoshiru'] = 'misoshiru' は、
            // 送信先のpost.phpで $_POST['rice'] や $_POST['misoshiru'] のようにすると
            // 取り出すことができる。
            $.ajax({
                type: "POST",
                url: "past.php",
                data: data,
                success:function(responce) {
                    // post.php 内で echo されたものが一応帰ってくる。
                    console.log(responce);
                },
                error:function(){
                    // 通信失敗時の処理
                    alert("通信に失敗しました。");
                }
            });
        }

    </script>
</head>
<body>

    <h1>ご飯と味噌汁を送信してください</h1>
    <p>※コンソールログをみてください。</p>

    <!-- data['rice'] に 'rice' を追加 -->
    <button onclick="addMenu('rice')">ごはん</button>

    <!-- data['rice'] に 'rice' を追加 -->
    <button onclick="addMenu('misoshiru')">味噌汁</button>

    <!-- 送信 (post.php に 現時点での data を非同期で送信する) -->
    <button onclick="sendMenu()">送信</button>
</body>
</html>
