<?
// 將收到的表單資料新增至資料庫

require_once("../db_connect.php");

if (!isset($_POST["name"])) {
    die("請從正門進入");
}

$name = $_POST["name"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$now = date("Y-m-d H:i:s");

$sql = "INSERT INTO users (name, phone, email, creat_at) VALUES ('$name','$phone','$email', '$now')";

if ($conn->query($sql) === TRUE) {
    // 查詢ID
    $last_id = $conn->insert_id;
    echo "新增資料成功, id為$last_id";
} else {
    echo "新增資料失敗";
}

$conn->close();

// 跳轉回表單
header("location: create-user.php");
