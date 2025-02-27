<?
require_once("../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請走正門";
    exit;
}

$name = $_POST["name"];

// 取得圖片不是用$_POST
if ($_FILES["image"]["error"] == 0) {
    // var_dump($_FILES["image"]);
    // 只抓副檔名
    $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $filename = time() . "." . $ext;
    echo $ext;
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../img/" . $filename)) {
        echo "上傳OK";
    } else {
        echo "upload file fail";
        exit;
    }
} else {
    echo "圖片上傳錯誤";
}


$sql = "INSERT INTO images (name,image) VALUES ('$name','$filename')";
if ($conn->query($sql) === TRUE) {
} else {
    echo "Error:" . $sql . "<br>" . $conn->error;
    die;
}

header("location:file-upload.php");
