<?php
require_once('../daiski/pdo_connect.php');

if(!isset($_GET["id"])){
    echo "參數缺失";
    exit;
}

$id=$_GET["id"];

$sql="SELECT * FROM users WHERE id=? AND valid=1";
$stmt=$db_host->prepare($sql);

try {
	$stmt->execute([$id]);
	$row = $stmt->fetch();
    echo "<pre>";
    print_r($row);
    echo "</pre>";

} catch (PDOException $e) {
	echo "預處理陳述式執行失敗！ <br/>";
	echo "Error: " . $e->getMessage() . "<br/>";
	$db_host = NULL;
	exit;
}