<?

require_once("../db_connect.php");
$id = $_GET["id"];

$sql = "UPDATE users SET valid=0 WHERE id=$id";


if ($conn->query($sql) === TRUE) {
    echo "資料刪除成功";
    $conn->close();
    header("location:users2.php");
} else {

    echo "Error: " . $sql . "<br>" . $conn->error;
}


