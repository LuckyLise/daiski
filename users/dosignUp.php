<?php
require_once('../pdo_connect.php');

if(!isset($_POST["account"])){
    die("請循正常管道進入此頁");
}

$account=$_POST["account"];
$password=$_POST["password"];
$repassword=$_POST["repassword"];

$patternAccount="/^.{4,10}$/";
// echo strlen($account);
// if(strlen($account)<4 || strlen($account)>20){
//     die("請輸入4~20字元的帳號");
// }
if(!preg_match($patternAccount, $account)){
    die("請輸入4~10字元的帳號");
}

$sql="SELECT * FROM users WHERE account='$account'";
$stmt = $db_host->prepare($sql);
$userCount = $stmt->rowCount();
// echo $userCount;
if($userCount==1){
    die("該帳號已經存在");
}

if(strlen($password)<4 || strlen($password)>10){
    die("請輸入4~10字元的密碼");
}
if($password!=$repassword){
    die("密碼不一致");
}
// 加密,(還有雜湊的方式可參考)
$password=md5($password);

$now=date("Y-m-d H:i:s");
$sql="INSERT INTO users (account, password, createdtime, valid)
	VALUES ('$account', '$password', '$now', 1)";

// if ($db_host->prepare($sql) === TRUE) {
   
// } else {
//     echo "Error: " . $sql . "<br>" . $conn ->error ;
//     die;
// }




try {
	$stmt->execute();

} catch (PDOException $e) {
	echo "預處理陳述式執行失敗！ <br/>";
	echo "Error: " . $e->getMessage() . "<br/>";
	$db_host = NULL;
	exit;
}

$db_host = NULL;

header("location: pdo-users.php");