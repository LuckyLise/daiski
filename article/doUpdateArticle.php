<?php
if (!isset($_POST["id"])) {
    die("請走正門");
}

require_once("../pdo_connect.php");

$id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["content"];
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];



// 取得圖片不是用$_POST
if (isset($_FILES["images"]) &&  $_FILES["images"]["error"] == 0) {
    // 計算有幾張照片了，以方便sort排序
    $sql = "SELECT * FROM article_images WHERE article_id = $id";
    $stmt = $db_host->prepare($sql);

    try {
        $stmt->execute();
        $img_num = $stmt->rowCount();
        $sort = $img_num + 1;
    } catch (PDOException $e) {

        echo "預處理陳述式執行失敗！<br/>";
        echo "Error: " . $e->getMessage() . "<br/>";
        $db_host = NULL;
        exit;
    }

    // var_dump($_FILES["image"]);
    // PATHINFO_EXTENSION 只抓副檔名
    $ext = pathinfo($_FILES["images"]["name"], PATHINFO_EXTENSION);
    // 隨機當作檔名
    $filename = uniqid() . "." . $ext;
    if (move_uploaded_file($_FILES["images"]["tmp_name"], "./article_imgs/" . $filename)) {
        $sql = "INSERT INTO article_images (name,sort,article_id) VALUES ('$filename','$sort',$id)";
        $stmt = $db_host->prepare($sql);

        try {
            $stmt->execute();
            header("location:article.php?id=$id");
        } catch (PDOException $e) {

            echo "預處理陳述式執行失敗！<br/>";
            echo "Error: " . $e->getMessage() . "<br/>";
            $db_host = NULL;
            exit;
        }
    } else {
        echo "upload file fail";
        exit;
    }
} else {
    echo "圖片上傳錯誤";
}



// $sql = "UPDATE article SET title='$title', content='$content',  startDate='$startDate', endDate='$endDate' WHERE id=$id";
// $stmt = $db_host->prepare($sql);

// try {
//     $stmt->execute();
//     header("location:article.php?id=$id");
// } catch (PDOException $e) {

//     echo "預處理陳述式執行失敗！<br/>";
//     echo "Error: " . $e->getMessage() . "<br/>";
//     $db_host = NULL;
//     exit;
// }
