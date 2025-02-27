<?php
include '../pdo_connect.php';

if(isset($_GET['photo_id'])) {
    $photo_id = $_GET['photo_id'];

    // 可選：先取得圖片路徑以便刪除伺服器檔案
    $stmt = $db_host->prepare("SELECT image_url FROM courseimages WHERE id = :photo_id");
    $stmt->execute(['photo_id' => $photo_id]);
    $photo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // 刪除資料庫記錄
    $stmt = $db_host->prepare("DELETE FROM courseimages WHERE id = :photo_id");
    if($stmt->execute(['photo_id' => $photo_id])) {
        // 若資料庫刪除成功，並且有圖片路徑，則刪除檔案
        if($photo && file_exists($photo['image_url'])){
            unlink($photo['image_url']);
        }
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
