<?php
header("Content-Type: application/json");
require_once("../pdo_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!isset($_POST["id"])) {
    echo json_encode(["success" => false, "message" => "缺少規格 ID"]);
    exit;
  }
  $spec_id = $_POST["id"];
  // 軟刪除：更新該規格的 valid 欄位為 0
  $stmt = $db_host->prepare("UPDATE product_specs SET valid = 0 WHERE id = ?");
  $stmt->execute([$spec_id]);
  echo json_encode(["success" => true, "message" => "規格已軟刪除"]);
} else {
  echo json_encode(["success" => false, "message" => "請使用 POST"]);
}
?>