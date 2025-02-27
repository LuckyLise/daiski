<?php
require_once("../daiski/pdo_connect.php");

$sql="SELECT * FROM users WHERE valid=1 LIMIT 8,4";
$stmt=$db_host->prepare($sql);
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
// print_r($rows);
echo "</pre>";

$db_host = NULL;
?>