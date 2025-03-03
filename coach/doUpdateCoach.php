<?php
if (!isset($_POST["name"])) {
    die("錯!!!!!!");
}

require_once("../pdo_connect.php");

$id = $_POST["id"];
$name = $_POST["name"];
$email = $_POST["email"];
$bio = $_POST["bio"];
$experience = $_POST["experience"];
$language = $_POST["language"];
$license = array_filter($_POST["license"]);

$languageNum = [
    "英文" => 1,
    "中文" => 2,
    "日文" => 3,
    "韓文" => 4,
    "粵語" => 5,
    "台語" => 6
];
if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $filename = time() . "." . $ext;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], "../coach/images/" . $filename)) {
            // echo "upload file success!";
        } else {
            echo "upload file fail..";
            exit;
        }
    } else {
        // echo "圖片上傳錯誤";
        // header("location: coach.php?id=$id");
    }


try{
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
    $sql="UPDATE coach SET name = '$name', email = '$email', bio = '$bio', experience = '$experience', profilephoto = '$filename'
    WHERE id = $id";
    }else{
        $sql="UPDATE coach SET name = '$name', email = '$email', bio = '$bio', experience = '$experience'
    WHERE id = $id";
    }
    $stmt = $db_host->prepare($sql);
    $stmt->execute();

    // header("location: coach.php?id=$id");
} catch(PDOException $e) {
    echo "更新失敗..." . $e->getMessage();
}
for ($i = 0; $i < count($language); $i++) {
    // print_r($languageNum[$language[$i]]);
    $language[$i] = ($languageNum[$language[$i]]);
}
//刪除語言
try {
    $sql = "DELETE FROM language_coach WHERE coach_id = $id
    ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute();
} catch (PDOException $e) {
    echo "更新失敗..." . $e->getMessage();
}
//更新語言
try {
    for ($i = 0; $i < count($language); $i++) {
        $sql = "INSERT INTO language_coach (language_id, coach_id) VALUES ('$language[$i]', $id)";
        $stmt = $db_host->prepare($sql);
        $stmt->execute();
    }
} catch (PDOException $e) {
    echo "更新失敗..." . $e->getMessage();
}

try {
    $sql = "DELETE FROM license_coach WHERE coach_id = $id
    ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute();
} catch (PDOException $e) {
    echo "更新失敗..." . $e->getMessage();
}

try {
    for ($i = 0; $i < count($license); $i++) {
        $sql = "SELECT * FROM license 
    WHERE name =  '$license[$i]'";
        $stmt = $db_host->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            // echo "沒重複耶!";
            $sql = "INSERT INTO license (name) VALUES ('$license[$i]')";
            $stmt = $db_host->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            $lic = $db_host->lastInsertId();
            $sql = "INSERT INTO license_coach (license_id, coach_id) VALUES ('$lic', $id)";
            $stmt = $db_host->prepare($sql);
            $stmt->execute();
        } else {
            // echo "可惡";
            $row = $stmt->fetch();
            $lic = ($row["id"]);
            $sql = "INSERT INTO license_coach (license_id, coach_id) VALUES ('$lic', $id)";
            $stmt = $db_host->prepare($sql);
            $stmt->execute();
        }
    }
} catch (PDOException $e) {
    echo "更新失敗..." . $e->getMessage();
}
header("location: coach.php?id=$id");