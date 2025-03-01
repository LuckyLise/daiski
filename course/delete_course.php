<?php
include '../pdo_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $course_id = $_GET['id'];

    try {
        $db_host->beginTransaction();

        // **1️⃣ 刪除課程圖片**
        $stmt = $db_host->prepare("DELETE FROM courseimages WHERE course_id = :course_id");
        $stmt->execute(['course_id' => $course_id]);

        // **2️⃣ 刪除課程變體**
        $stmt = $db_host->prepare("DELETE FROM coursevariants WHERE course_id = :course_id");
        $stmt->execute(['course_id' => $course_id]);

        // **3️⃣ 刪除課程**
        $stmt = $db_host->prepare("DELETE FROM course WHERE id = :course_id");
        $stmt->execute(['course_id' => $course_id]);

        $db_host->commit();

        // **刪除成功，重新導向回課程管理頁面**
        header("Location: courses.php?delete_success=1");
        exit();
    } catch (Exception $e) {
        $db_host->rollBack();
        die("刪除失敗：" . $e->getMessage());
    }
} else {
    die("錯誤：未提供課程 ID");
}
?>
