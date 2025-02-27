<?
// 將收到的表單資料新增至資料庫

require_once("../pdo_connect.php");

if (!isset($_POST["title"])) {
    die("請輸入標題");
}

$title = $_POST["title"];
$content = $_POST["content"];
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];
$now = date("Y-m-d H:i:s");

$sql = "INSERT INTO article (title, content, startDate, endDate) VALUES (:title,:content,:startDate, :endDate)";

$stmt = $db_host->prepare($sql);


try {
    $stmt->execute(
        [
            ":title" => $title,
            ":content" => $content,
            ":startDate" => $startDate,
            ":endDate" => $endDate,
        ]
    );
    $article = $stmt->fetch();
    $userCount = $stmt->rowCount();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}



if (isset($_FILES["images"]) && $_FILES["images"]["error"] == 0) {
    $i = 1;
    // var_dump($_FILES["image"]);
    // 只抓副檔名
    $ext = pathinfo($_FILES["images"]["name"], PATHINFO_EXTENSION);
    $filename = time() . "." . $ext;
    echo $ext;
    if (move_uploaded_file($_FILES["images"]["tmp_name"], "../images/" . $filename)) {
        echo "上傳OK";
    } else {
        echo "upload file fail";
        exit;
    }
    // $sql = "INSERT INTO article_images (name, sort, article_id) VALUES ('$name', '$i','$filename')";
    // try {
    //     $stmt->execute();
    // } catch (PDOException $e) {
    //     echo "預處理陳述式執行失敗！<br/>";
    //     echo "Error: " . $e->getMessage() . "<br/>";
    //     $db_host = NULL;
    //     exit;
    // }
} else {
    echo "圖片上傳錯誤";
}





// 跳轉回表單
header("location: article.php");
