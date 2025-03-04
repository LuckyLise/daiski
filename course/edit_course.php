<?php
// 編輯課程用php
include '../pdo_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id   = $_POST['course_id'];
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = $_POST['price'];
    $type        = $_POST['type'];
    $difficulty  = $_POST['difficulty'];
    $duration    = $_POST['duration'];
    $coach_id    = !empty($_POST['coach_id']) ? $_POST['coach_id'] : NULL;
    $max_participants = $_POST['max_participants'];
    $location_id = isset($_POST['location_id']) ? $_POST['location_id'] : NULL;
    // **更新課程名稱與描述**
    $stmt = $db_host->prepare("UPDATE course SET name = :name, description = :description WHERE id = :course_id");
    $stmt->execute([
        'name'        => $name,
        'description' => $description,
        'course_id'   => $course_id
    ]);

    // **更新課程變體（類型、難度、時長、價格、教練、最大人數）**
    $stmt = $db_host->prepare("UPDATE coursevariants 
                               SET type = :type, difficulty = :difficulty, duration = :duration, 
                                   price = :price, coach_id = :coach_id, max_participants = :max_participants,
                                   location_id = :location_id
                               WHERE course_id = :course_id");
    $stmt->execute([
        'type'       => $type,
        'difficulty' => $difficulty,
        'duration'   => $duration,
        'price'      => $price,
        'coach_id'   => $coach_id,
        'max_participants' => $max_participants,
        'location_id' => $location_id,
        'course_id'  => $course_id
    ]);

    // **處理上傳新圖片**
    if (!empty($_FILES['new_images']['name'][0])) {
        $uploadDir = "./courseImages/";
        foreach ($_FILES['new_images']['tmp_name'] as $key => $tmpName) {
            if (!empty($tmpName)) {
                $imageName  = time() . "_" . bin2hex(random_bytes(4)) . "." . pathinfo($_FILES['new_images']['name'][$key], PATHINFO_EXTENSION);
                $targetFile = $uploadDir . $imageName;
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $stmt = $db_host->prepare("INSERT INTO courseimages (course_id, image_url) VALUES (:course_id, :image)");
                    $stmt->execute(['course_id' => $course_id, 'image' => $targetFile]);
                }
            }
        }
    }
    header("Location: courses.php");
    exit();
}
?>
