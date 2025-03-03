<?php 
session_start();
require_once("../pdo_connect.php");

if (!isset($_POST['id']) || !isset($_POST['action'])) {
    die("缺少必要參數");
}

$productId = intval($_POST['id']);
$action = $_POST['action'];
$now = date("Y-m-d H:i:s");

try {
    $db_host->beginTransaction();

    if ($action === 'publish') {
        // 更新 publishAt 為目前時間，unpublishAt 設為 NULL
        $sql = "UPDATE products SET publishAt = ?, unpublishAt = NULL WHERE id = ?";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([$now, $productId]);
        $_SESSION['message'] = "商品已上架";

    } elseif ($action === 'unpublish') {
        // 更新 unpublishAt 為目前時間，publishAt 設為 NULL
        $sql = "UPDATE products SET unpublishAt = ?, publishAt = NULL WHERE id = ?";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([$now, $productId]);
        $_SESSION['message'] = "商品已下架";

    } elseif ($action === 'delete') {
        // 更新 deleteAt 為目前時間，publishAt 和 unpublishAt 設為 NULL
        $sql = "UPDATE products SET deleteAt = ?, publishAt = NULL, unpublishAt = NULL WHERE id = ?";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([$now, $productId]);
        $_SESSION['message'] = "商品已刪除";

    } else {
        die("無效的操作");
    }

    $db_host->commit();

    // 重新導向回商品列表頁面
    header("Location: product-list.php");
    exit;
    
} catch (PDOException $e) {
    $db_host->rollBack();
    die("操作失敗: " . $e->getMessage());
}
?>