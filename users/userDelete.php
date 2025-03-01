<?php
require_once("../pdo_connect.php");
$id=$_GET["id"];


$sql="UPDATE users SET valid=0 WHERE id='$id'";
$stmt = $db_host->prepare($sql);
try {
	$stmt->execute();
	$row = $stmt->fetch();
	// echo "<pre>";
	// print_r($row);
	// echo "</pre>";

} catch (PDOException $e) {
	echo "預處理陳述式執行失敗！ <br/>";
	echo "Error: " . $e->getMessage() . "<br/>";
	$db_host = NULL;
	exit;
}
$db_host = NULL;
header("location:pdo-users.php");