<?php
require_once('./functions.php');
session_start();

$id = $_GET['id'];

// DB接続
$db = connectDB(); // ※ この関数はfunctions.phpに定義
$sql1 = "SELECT * FROM data WHERE team_id = $id ORDER BY id";
// SQLを実行
$statement1 = $db->query($sql1);
// 以下4行で、取得した記事を配列$articlesに格納している
$datas = [];
foreach ($statement1->fetchAll(PDO::FETCH_ASSOC) as $data ) {
    $datas[]= $data;
}

$sql2 = 'SELECT * FROM teams WHERE id = :id';
// SQLを実行
$statement2 = $db->prepare($sql2);
$statement2->execute(['id' => $_GET['id']]);
$team = $statement2->fetch(PDO::FETCH_ASSOC);

if(isset($_GET['action'])&& $_GET['action'] == 'delete' && $_GET['dataid'] > 0){
	try{
	$db->beginTransaction();
	$dataid = $_GET['dataid'];
	$sql = "DELETE FROM data WHERE id = $dataid";
	$stmh = $db->prepare($sql);
	$stmh->bindValue(':id', $dataid, PDO::PARAM_INT);
	$stmh->execute();
	$db->commit();
	/*print"データを".$stmh->rowCount()."件、削除しました。<br>";*/
	}catch(PDOException $Exception){
	$db->rollBack();
	print"エラー：".$Exception->getMessage();
	header("Location: delete.php?id=$id");
	}
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8"/>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
            <link href="delete.css" rel="stylesheet">
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
            <script src="./js/bootstrap.min.js"></script>
            <title>削除画面</title>
    </head>

    <body>
        <div class="container">
        <form name="form">
            <div class="box1">
            <h1><?php echo h($team['name']); ?>データ一覧</h1>
            </div>
            <div class="row">
                    <ul style="list-style-type:none; padding-left: 4em;">
                        <?php foreach($datas as $data): ?>
                            <li class='article'>
                            	<a href="delete.php?id=<?php echo $team['id'];?>&action=delete&dataid=<?php echo $data['id'];?>">
                                <button id="<?php echo($data['id']) ?>" type="button" class="btn btn-default trashbtn" >
                                <span class="glyphicon glyphicon-trash"></span></button></a>
                                <td>ID：<?php echo h($data['id']); ?></td>
                                <td>TYPE：<?php echo h($data['type']); ?></td>
                                <td>PLAYER：<?php echo h($data['member_id']); ?></td>
                            </li>
                        <?php endforeach; ?>
                    </ul>
            </div>
	</body>
</html>
