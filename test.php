<?php
require_once('./functions.php');
session_start();

$db = connectDB();

$member_id = $_GET['member_id'];
$type = $_POST['type'];
$attack_from = $_POST['attack_from'];
//echo "member_id=".$member_id." type=".$type." attack_from=".$attack_from;
//$response = getScoredCount($member_id, $type, $attack_from, $position);

$positions = array('al','ac','ar','fl','fc','fr','bl','bc','br');
$counts = [];
$colors = [];
$datas = [];
foreach($positions as $position){
	$sql1 = "SELECT COUNT(*) FROM data WHERE member_id = '$member_id' AND type = '$type' AND attack_from = '$attack_from' AND attack_to = '$position'";
	$stmt1 = $db->query($sql1);
	$count = $stmt1->fetchColumn();
    $counts[] = $count;
    if($count == 0){
        $color =  "#fff4f4";
    }else if($count > 0 && $count < 5){
        $color = "#ff8080";
    }else{
        $color =  "#ff0000";
    }
    $colors[] = $color;
    $datas[$position] = [
        'count' => $count,
        'color' => $color,
    ];
}
$data = json_encode($datas);
echo $data;
?>