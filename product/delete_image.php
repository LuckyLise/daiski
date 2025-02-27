<?php
header('Content-Type: application/json'); // 確保回傳 JSON
require_once("./PDO_connect.php");

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => '缺少圖片 ID']);
    exit;
}

$image_id = $_POST['id'];

try {
    // 檢查是否存在該圖片
    $stmt = $db_host->prepare("SELECT COUNT(*) FROM product_images WHERE id = ? AND valid = 1");
    $stmt->execute([$image_id]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        echo json_encode(['success' => false, 'message' => '圖片 ID 不存在或已刪除']);
        exit;
    }

    // 執行刪除（將 valid 設為 0）
    $stmt = $db_host->prepare("UPDATE product_images SET valid = 0 WHERE id = ?");
    $stmt->execute([$image_id]);

    echo json_encode(['success' => true, 'message' => '圖片已成功刪除']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => '資料庫錯誤: ' . $e->getMessage()]);
}
?>