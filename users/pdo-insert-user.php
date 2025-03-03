<?php
session_start();

require_once('../pdo_connect.php');

$name=$_POST["name"];
$account=$_POST["account"];
$password=$_POST["password"];
$repassword=$_POST["repassword"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$createdtime=date("Y-m-d H:i:s");
$isCoach=$_POST["isCoach"];



$sql = "SELECT * FROM users WHERE account=:account";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute([
        ":account" => $account
    ]);
    $userCount = $stmt->rowCount(); // $result->num_rows
    // echo $userCount;
    if ($userCount == 1) {
        // 將錯誤訊息存入 session
        $_SESSION["error"] = "該帳號已經存在";
        // 導回創建使用者頁面
        header("Location: create-user.php");
        exit();
        // die("該帳號已經存在");
        // header("location:create-user.php");
    }
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

$sqlInsert = "INSERT INTO users ( name, account, password, phone, email, createdtime,isCoach ) VALUES ( :name, :account, :password, :phone, :email, :createdtime, :isCoach )";
$stmt = $db_host->prepare($sqlInsert);

try {
    $stmt->execute([
        ":name" => $name,
        ":account" => $account,
        ":password" => $password,
        ":phone" => $phone,
        ":email" => $email,
        ":createdtime"=>$createdtime,
        ":isCoach" => $isCoach
    ]);

    $lastId = $db_host->lastInsertId();
    echo "last id: $lastId";
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

$db_host = NULL;
header("location: pdo-users.php");
