<?php
require_once("../pdo_connect.php");

// if(!isset($_GET["id"])){
//     die("沒有這優惠卷");
// }

$id = $_GET["id"];

$sql = "DELETE FROM coupon WHERE id = :id";
$stmt = $host_db->prepare($sql);
$stmt->execute([":id" => $id]);
if(isset($_GET["header"])){
    header("Location: coupons.php");
}


if(!isset($_GET["header"])){
    echo json_encode(["status" => "success", "message" => "優惠券已刪除"]);
}



$host_db = NULL;

