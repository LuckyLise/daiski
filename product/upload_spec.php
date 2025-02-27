<?php
header("Content-Type: application/json");
require_once("./PDO_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!isset($_POST["product_id"])) {
    echo json_encode(["success"=> false, "message" => "缺少商品 ID"]);
    exit;
  }
  $product_id = $_POST["product_id"];
  $specName = $_POST["specName"] ?? "";
  $specValue = $_POST["specValue"] ?? "";
  if(trim($specName) == "" || trim($specValue) == "") {
    echo json_encode(["success"=> false, "message" => "請提供規格名稱與內容"]);
    exit;
  }
  // 取得目前該商品規格的最大排序值
  $stmt = $db_host->prepare("SELECT MAX(sortOrder) as maxOrder FROM product_specs WHERE product_id = ?");
  $stmt->execute([$product_id]);
  $row = $stmt->fetch();
  $max_order = ($row && $row["maxOrder"] !== null) ? $row["maxOrder"] : -1;
  $new_sort = $max_order + 1;
  
  // 插入新規格資料
  $stmt = $db_host->prepare("INSERT INTO product_specs (product_id, specName, specValue, sortOrder, createdAt) VALUES (?, ?, ?, ?, NOW())");
  $stmt->execute([$product_id, $specName, $specValue, $new_sort]);
  $new_id = $db_host->lastInsertId();
  
  echo json_encode(["success"=> true, "new_spec" => [
      "id" => $new_id,
      "specName" => $specName,
      "specValue" => $specValue,
      "sortOrder" => $new_sort
  ]]);
} else {
  echo json_encode(["success"=> false, "message" => "請使用 POST"]);
}
?>