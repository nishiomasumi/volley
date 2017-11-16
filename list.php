<?php
require_once('./functions.php');
$db = connectDB();
$id = $_GET['id'];

if(isset($_GET['action'])&& $_GET['action'] == 'delete' && $_GET['dataid'] > 0){
	try{
	$db->beginTransaction();
	$dataid = $_GET['dataid'];
	$sql = "DELETE FROM data WHERE id = $dataid";
	$stmh = $db->prepare($sql);
	$stmh->bindValue(':id', $dataid, PDO::PARAM_INT);
	$stmh->execute();
	$db->commit();
	print"データを".$stmh->rowCount()."件、削除しました。<br>";
	}catch(PDOException $Exception){
	$db->rollBack();
	print"エラー：".$Exception->getMessage();
	}

}
?>