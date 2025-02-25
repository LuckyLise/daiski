<?php 
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "daiski_db";

try{
    $db_host=new PDO(
        "mysql:host={$servername};dbname={$dbname};charset=utf8", $username, $password
    );
}catch(PDOException $e){
    echo "資料庫連線失敗";
    echo $e->getMessage();
}
?>