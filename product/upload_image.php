<?php
header("Content-Type: application/json");
require_once("./PDO_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["product_images"])) {
    // 從 GET 取得商品 ID
    if (!isset($_GET['id'])) {
        echo json_encode(["success" => false, "message" => "缺少商品 ID"]);
        exit;
    }
    $product_id = $_GET['id'];
    
    // 設定上傳目錄 (資料夾一定存在)
    $uploadDir = "./productImages/" . $product_id . "/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $new_images = [];
    // 取得目前該商品圖片的最大排序值
    $stmt = $db_host->prepare("SELECT MAX(sortOrder) as maxOrder FROM product_images WHERE product_id = ? AND valid = 1");
    $stmt->execute([$product_id]);
    $row = $stmt->fetch();
    $max_order = ($row && $row['maxOrder'] !== null) ? $row['maxOrder'] : -1; // 如果無圖片，預設為 -1
    
    // 逐一處理上傳檔案
    foreach ($_FILES["product_images"]["tmp_name"] as $key => $tmpName) {
        if ($_FILES["product_images"]["error"][$key] !== UPLOAD_ERR_OK) {
            continue; // 若有錯誤則略過
        }
        $originalName = $_FILES["product_images"]["name"][$key];
        $fileExt = pathinfo($originalName, PATHINFO_EXTENSION);
        $newFileName = uniqid() . "." . $fileExt;
        $destination = $uploadDir . $newFileName;
        if (move_uploaded_file($tmpName, $destination)) {
            // 新增時將排序值加 1
            $max_order++;
            $stmt = $db_host->prepare("INSERT INTO product_images (product_id, url, sortOrder, valid) VALUES (?, ?, ?, 1)");
            $stmt->execute([$product_id, $destination, $max_order]);
            $new_id = $db_host->lastInsertId();
            $new_images[] = ["id" => $new_id, "url" => $destination, "sortOrder" => $max_order];
        }
    }
    
    if (count($new_images) > 0) {
        // 回傳的新最大排序值為 $max_order，下拉選單的選項數量則應為 ($max_order + 1)
        echo json_encode(["success" => true, "new_images" => $new_images, "max_sort_order" => $max_order]);
    } else {
        echo json_encode(["success" => false, "message" => "圖片上傳失敗"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "請使用 POST 方式上傳圖片"]);
}
?>