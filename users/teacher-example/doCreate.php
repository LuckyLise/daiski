<?php
require_once("../daiski/pdo_connect.php");

if (!isset($_POST["name"])) {
    die("請循正常管道進入此頁");
}

$name = $_POST["name"];
$account = $_POST["account"];
$password = $_POST["password"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$isCoach = $_POST["isCoach"];
$now = date("Y-m-d H:i:s");

$sql = "INSERT INTO users (name,account,password, phone,email,createdtime,isCoach)
	VALUES ('$name', '$account','$password','$phone', '$email', '$now','$isCoach')";

$stmt = $db_host->prepare($sql);
try {
    $stmt->execute(
        
    );
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // if (isset($_GET["q"])) {
    //     $userCount = $stmt->rowCount();
    // }
    // echo "<pre>"; 會將結果展開，自動換行
    // print_r($rows);會將結果用陣列的方式顯現出來
    // echo "</pre>";
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

header("location: create-user.php");
