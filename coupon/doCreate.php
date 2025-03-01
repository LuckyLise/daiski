<?php
require_once("../pdo_connect.php");

if (!isset($_POST["name"])) {
    die("請循正常管道進入此頁");
}

$name = $_POST["name"];
$code = $_POST["code"];
$coupon_type = $_POST["coupon_type"];
$coupon_amount = $_POST["coupon_amount"];
$coupon_target = $_POST["coupon_target"];
$startAt = $_POST["startAt"];
$endAt = $_POST["endAt"];
$usageLimit = $_POST["usageLimit"];
$minPurchase = $_POST["minPurchase"];
$createdAt = date("Y-m-d H:i:s");


// 找尋coupon_type的資料表裡有沒有一樣的資料
$sqlType = "SELECT * FROM coupon_type
WHERE amount = :amount AND `type` = :type";
$stmt = $db_host->prepare($sqlType);
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
    $stmtInsert = $db_host->prepare($sqlInsert);
    $stmtInsert->execute([
        ':type'   => $coupon_type,
        ':amount' => $coupon_amount,
    ]);
    $coupon_type_id = $db_host->lastInsertId();
}


// 新增資料
$sql = "INSERT INTO coupon (name, code, startAt, endAt, usageLimit, minPurchase, createdAt, coupon_target_id, type_id)
    VALUES (:name, :code, :startAt, :endAt, :usageLimit, :minPurchase, :createdAt, :coupon_target_id, :coupon_type_id)
";
$stmt = $db_host->prepare($sql);

$couponTarget = [
    "課程" => 1,
    "商品" => 2,
    "全站" => 3,
];

$params = [
    ':name'         => $name,
    ':code'         => $code,
    ':coupon_target_id' => $couponTarget[$coupon_target],
    ':startAt'      => $startAt,
    ':endAt'        => $endAt,
    ':usageLimit'   => $usageLimit,
    ':minPurchase'  => $minPurchase,
    ':createdAt'    => $createdAt,
    ':coupon_type_id'   => $coupon_type_id
];
try {
    $stmt->execute($params);
    $coupon_id = $db_host->lastInsertId();

    echo "新資料新增成功";
    header("location: coupons.php?id=$id");
} catch (PDOException $e) {
    echo "Error: " . $sql . $e->getMessage() . "<br>";
    $db_host = NULL;
    exit;
}

//有不樣的資料的話寫入其id
$sqlUpdate = "UPDATE coupon SET type_id = :coupon_type_id WHERE $coupon_id ";
$stmtUpdate = $db_host->prepare($sqlUpdate);
$stmtUpdate->execute($params);

$db_host = NULL;
