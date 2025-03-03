<?php
require_once("../pdo_connect.php");

$id=$_GET["id"];

try{
    $sql = "UPDATE coach SET valid= 0 WHERE id=$id";
    $stmt = $db_host->prepare($sql);
    $stmt->execute();
}catch (PDOException $e) {
    echo "更新失敗..." . $e->getMessage();
}
header("location: coaches.php");
