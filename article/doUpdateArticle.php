<?
if (!isset($_POST["id"])) {
    die("請走正門");
}

require_once("../pdo_connect.php");

$id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["content"];
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];

$sql = "UPDATE article SET title='$title', content='$content',  startDate='$startDate', endDate='$endDate' WHERE id=$id";
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
