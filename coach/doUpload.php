<?php
require_once("../pdo.connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}
$name = $_POST["name"];
if ($_FILES["image"]["error"] == 0) {
    $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $filename = time() . "." . $ext;
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../images/" . $filename)) {
        // echo "upload file success!";
    } else {
        echo "upload file fail..";
        exit;
    }
} else {
    echo "圖片上傳錯誤";
}
$sql="UPDATE coach SET profilephoto = '$filename' WHERE name = '$name'";
echo $sql;
try {
    $stmt = $db_host->prepare($sql);
    $stmt->execute();
    
} catch (PDOException $e) {
    echo "錯誤: " . $e->getMessage();
    exit;
}
header("location: create-coach.php");
