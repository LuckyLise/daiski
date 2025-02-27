<?php
require_once("../pdo.connect.php");

$id=$_GET["id"];

try{
    $sql = "DELETE FROM coach WHERE id=$id";
    $stmt = $db_host->prepare($sql);
    $stmt->execute();
}catch (PDOException $e) {
    echo "更新失敗..." . $e->getMessage();
}
header("location: coaches.php");
