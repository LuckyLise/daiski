<?php

require_once("../pdo_connect.php");
$id = $_GET["id"];

$sql = "DELETE FROM article WHERE id=$id";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    var_dump("刪除成功!等待自動跳轉，或手動點擊");
    header("location:articles.php");
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}
