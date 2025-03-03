<?php
require_once('../pdo_connect.php');
session_start();

$sqlALL = "SELECT * FROM users WHERE valid=1";
$stmtALL = $db_host->prepare($sqlALL);
$stmtALL->execute();


if (!isset($_POST["account"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$account = $_POST["account"];
$password = $_POST["password"];

if (strlen($account) < 4 || strlen($account) > 10) {
    $error = "請輸入4~10字元的帳號";
    $_SESSION["error"]["message"] = $error;
    header("location: sign-in.php");
    exit;
}

if (strlen($password) < 4 || strlen($password) > 10) {
    $error = "請輸入4~10字元的密碼";
    $_SESSION["error"]["message"] = $error;
    header("location: sign-in.php");
    exit;
}

// $password=md5($password);

// $sql="SELECT * FROM users WHERE account='$account' AND password='$password'";
// $stmt = $db_host->prepare($sql);
if($account == "admin" && $password == "12345"){
    header("location: pdo-users.php");
}else{
    if(!isset($_SESSION["error"]["times"])){
        $_SESSION["error"]["times"]=1;
    }else{
        $_SESSION["error"]["times"]++;
    }
    
    $error = "帳號或密碼錯誤";
    $_SESSION["error"]["message"] = $error;
    header("location: sign-in.php");
    exit;
}

// try {
//     $stmt->execute();
//     $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     $userCount = $stmtALL->rowCount();
//     // echo "<pre>"; 會將結果展開，自動換行
//     // print_r($rows);會將結果用陣列的方式顯現出來
//     // echo "</pre>";
// } catch (PDOException $e) {
//     echo "預處理陳述式執行失敗！ <br/>";
//     echo "Error: " . $e->getMessage() . "<br/>";
//     $db_host = NULL;
//     exit;
// }


if($userCount==0){
    // if(!isset($_SESSION["error"]["times"])){
    //     $_SESSION["error"]["times"]=1;
    // }else{
    //     $_SESSION["error"]["times"]++;
    // }

    // $error = "帳號或密碼錯誤";
    // $_SESSION["error"]["message"] = $error;
    // header("location: sign-in.php");
    // exit;
};

// unset($_SESSION["error"]);
// $_SESSION["user"]=$row;

// $db_host = NULL;
// header("location: pdo-users.php");
