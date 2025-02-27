<?php
if(!isset($_POST["name"])){
    die("請循正常管道進入此頁");
}
require_once("../pdo_connect.php");

$id = $_POST["id"];
$name = $_POST["name"];
$coupon_type = $_POST["coupon_type"];
$coupon_amount = $_POST["coupon_amount"];
$coupon_target = $_POST["coupon_target"];
$startAt = $_POST["startAt"];
$endAt = $_POST["endAt"];
$usageLimit = $_POST["usageLimit"];
$minPurchase = $_POST["minPurchase"];

$sqlType = "SELECT * FROM coupon_type
WHERE amount = :amount AND `type` = :type";
$stmt = $host_db->prepare($sqlType);
$stmt->execute([
    ":amount" => $coupon_amount,
    ":type" => $coupon_type
]);
$typeCount = $stmt->rowCount();

if ($typeCount == 1) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $coupon_type_id = $row['id'];
} else {
    $sqlInsert = "INSERT INTO coupon_type (type, amount) VALUES (:type, :amount)";
    $stmtInsert = $host_db->prepare($sqlInsert);
    $stmtInsert->execute([
        ':type'   => $coupon_type,
        ':amount' => $coupon_amount,
    ]);
    $coupon_type_id = $host_db->lastInsertId();
}

$sql = "UPDATE coupon AS c
JOIN coupon_type AS ty ON c.type_id = ty.id
SET c.name = :name, 
ty.type = :coupon_type, 
ty.amount = :coupon_amount, 
c.coupon_target_id = :coupon_target,
c.startAt = :startAt, 
c.endAt = :endAt, 
c.usageLimit = :usageLimit, 
c.minPurchase = :minPurchase, 
c.type_id = :coupon_type_id
WHERE c.id = :id";
// echo $sql;
$stmt = $host_db->prepare($sql);

$couponTarget = [
    "課程"=> 1,
    "商品"=> 2,
    "全站"=> 3,
];
// echo $couponTarget [$coupon_target];

$params = [
    ':id'           => $id,
    ':name'         => $name,
    ':coupon_type'  => $coupon_type,
    ':coupon_amount' => $coupon_amount,
    ':coupon_target' => $couponTarget [$coupon_target],
    ':startAt'      => $startAt,
    ':endAt'        => $endAt,
    ':usageLimit'   => $usageLimit,
    ':minPurchase'  => $minPurchase,
    ':coupon_type_id'   => $coupon_type_id
];

if ($stmt->execute($params)) {
    // echo "新資料更新成功";
    header("location: coupon.php?id=$id");
} else {
    echo "Error: " . $sql . "<br>";
}

// $sqlUpdate = "UPDATE coupon SET type_id = :coupon_type_id WHERE $coupon_id ";
// $stmtUpdate = $host_db->prepare($sqlUpdate);
// $stmtUpdate->execute($params);

$host_db = NULL;
