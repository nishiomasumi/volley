<?php
// functions.phpを読み込む. よく使う処理をまとめた関数を定義している
require_once('functions.php');
// セッションを利用する
session_start();
//DB接続
$db = connectDB();
//ユーザーから受け取る
$member_id = '1';//$_GET['member_id'];
$type = 'serve';//$_POST['type'];
$attack_from = 'left'; //$_POST['attack_from'];
	//条件に従ってレコード数を取得
	function getScoredCount($member_id, $type, $attack_from, $position){
		$sql1 = "SELECT COUNT(*) FROM data WHERE member_id = '.$member_id.' AND type = '.$type.' AND attack_from = '.$attack_from.' AND attack_to = '.$position.'";
		$stmt1 = $db->query($sql1);
		$stmt1->fetchColumn();
	}
	//色分けするためにカラーコードを取得
	/*function getColor($count){
		if($count == 0){
			return "#fff4f4";
		}else{
			return "#ff0000";
		}
	}*/
	//attack_to(コートを９等分した場所の名前)
	$positions = array('al','ac','ar','fl','fc','fr','bl','bc','br');

	$datas = [];
	foreach ($positions as $position) {
		echo $position;
		$count[] = getScoredCount($member_id, $type, $attack_from, $position);
		//$color[] = getColor($count);
		$datas[] = [
			'count' => $count,
			//'color' => $color,
		];
	}
	print_r($datas);

?>

