<?php
if(!isset($_POST["name"])){
    die("請循正常管道進入此頁");
}

require_once('../pdo_connect.php');

$id=$_POST["id"];
$name=$_POST["name"];
$account=$_POST["account"];
$password=$_POST["password"];
$phone=$_POST["phone"];
$birthday=$_POST["birthday"];
$email=$_POST["email"];
$isCoach=$_POST["isCoach"];

$sql="UPDATE users SET name='$name',account='$account',password='$password', phone='$phone',birthday='$birthday', email='$email',isCoach='$isCoach' WHERE id='$id'";
// echo $sql;

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
header("location:pdo-user.php?id=$id");



