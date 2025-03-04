<?php
include '../pdo_connect.php';

$uploadDir = "./courseImages/"; // 設定圖片上傳目錄

// **處理新增課程**
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_course'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $difficulty = $_POST['difficulty'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $location_id = $_POST['location_id'];
    $coach_id = !empty($_POST['coach_id']) ? $_POST['coach_id'] : NULL; // 允許 coach_id 為 NULL
    $max_participants = isset($_POST['max_participants']) ? (int)$_POST['max_participants'] : 1;
    // **處理圖片上傳**
    $uploadedImages = []; // 用來存放已上傳的圖片路徑
    if (!empty($_FILES['image']['name'][0])) { // 確保有選擇圖片
        foreach ($_FILES['image']['tmp_name'] as $key => $tmpName) {
            if (!empty($tmpName)) {
                // 產生唯一的圖片名稱，避免覆蓋
                $imageName = time() . "_" . bin2hex(random_bytes(4)) . "." . pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION);
                $targetFile = $uploadDir . $imageName;
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $uploadedImages[] = $targetFile; // 儲存圖片路徑
                }
            }
        }
    }

    // ** 新增課程到 `course`**
    $stmt = $db_host->prepare("INSERT INTO course (name, description) VALUES (:name, :description)");
    $stmt->execute(['name' => $name, 'description' => $description]);
    $course_id = $db_host->lastInsertId();

    // ** 新增課程圖片到 `courseimages`**
    if (!empty($uploadedImages)) {
        $stmt = $db_host->prepare("INSERT INTO courseimages (course_id, image_url) VALUES (:course_id, :image)");
        foreach ($uploadedImages as $imagePath) {
            $stmt->execute(['course_id' => $course_id, 'image' => $imagePath]);
        }
    }

    // ** 新增課程變體到 `coursevariants`**
    $stmt = $db_host->prepare("INSERT INTO coursevariants 
        (course_id, type, difficulty, duration, price, location_id, coach_id, max_participants) 
        VALUES (:course_id, :type, :difficulty, :duration, :price, :location_id, :coach_id, :max_participants)");
    $stmt->execute([
        'course_id'   => $course_id,
        'type'        => $type,
        'difficulty'  => $difficulty,
        'duration'    => $duration,
        'price'       => $price,
        'location_id' => $location_id,
        'coach_id'    => $coach_id,
        'max_participants' => $max_participants,
    ]);

    header("Location: courses.php");
    exit();
}

// 獲取地點列表
$locations_stmt = $db_host->query("SELECT id, name FROM locations");
$locations = $locations_stmt->fetchAll(PDO::FETCH_ASSOC);

// 獲取教練列表
$coaches_stmt = $db_host->query("SELECT id, name FROM coach");
$coaches = $coaches_stmt->fetchAll(PDO::FETCH_ASSOC);

// **處理篩選條件**
$filter = "";
$bindParams = [];
if (!empty($_GET['search'])) {
    $filter .= " AND (c.name LIKE :search OR c.description LIKE :search)";
    $bindParams[':search'] = "%" . $_GET['search'] . "%";
}
if (isset($_GET['type']) && $_GET['type'] !== 'all') {
    $filter .= " AND cv.type = :type";
    $bindParams[':type'] = $_GET['type'];
}
if (isset($_GET['difficulty']) && !empty($_GET['difficulty'])) {
    $filter .= " AND cv.difficulty = :difficulty";
    $bindParams[':difficulty'] = $_GET['difficulty'];
}
if (isset($_GET['location_id']) && !empty($_GET['location_id'])) {
    $filter .= " AND cv.location_id = :location_id";
    $bindParams[':location_id'] = $_GET['location_id'];
}

// **設定每頁顯示的課程數量**
$limit = 5;

// 取得當前頁數（如果沒有提供，則預設為 1）
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// **計算「篩選後」的總筆數**
$count_sql = "
    SELECT COUNT(DISTINCT c.id) AS total
    FROM coursevariants AS cv
    JOIN course AS c ON cv.course_id = c.id 
    LEFT JOIN courseimages AS ci ON ci.course_id = c.id
    JOIN locations AS l ON cv.location_id = l.id
    LEFT JOIN coach AS co ON cv.coach_id = co.id
    WHERE cv.valid = 1 $filter
";
$count_stmt = $db_host->prepare($count_sql);
foreach ($bindParams as $key => $value) {
    $count_stmt->bindParam($key, $value);
}
$count_stmt->execute();
$total_rows = $count_stmt->fetchColumn();
$total_pages = ceil($total_rows / $limit);

// 確保 $page 不會超過 $total_pages
if ($total_pages > 0 && $page > $total_pages) {
    $page = $total_pages;
}
$offset = ($page - 1) * $limit;

// **設定排序條件**
$orderBy = "";
if (isset($_GET['sort'])) {
    if ($_GET['sort'] === "price_asc") {
        $orderBy = "ORDER BY cv.price ASC";
    } elseif ($_GET['sort'] === "price_desc") {
        $orderBy = "ORDER BY cv.price DESC";
    } elseif ($_GET['sort'] === "created_at") {
        $orderBy = "ORDER BY cv.created_at DESC";
    }
}

// **查詢課程**
$sql = "
    SELECT c.name, c.description, c.id,
           GROUP_CONCAT(ci.image_url SEPARATOR ',') AS images, 
           cv.type, 
           cv.difficulty, 
           cv.duration, 
           cv.price, 
           cv.location_id,
           cv.max_participants,
           l.name AS location_name, 
           co.name AS coach_name
    FROM coursevariants AS cv
    JOIN course AS c ON cv.course_id = c.id 
    LEFT JOIN courseimages AS ci ON ci.course_id = c.id
    JOIN locations AS l ON cv.location_id = l.id
    LEFT JOIN coach AS co ON cv.coach_id = co.id
    WHERE cv.valid = 1 $filter
    GROUP BY cv.id
    $orderBy
    LIMIT :limit OFFSET :offset
";
$stmt = $db_host->prepare($sql);
foreach ($bindParams as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>課程管理</title>
    <?php include("./css.php") ?>
</head>

<body>
    <div id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    <div class="d-flex flex-column" id="mainContent">
        <?php include("./new_head_mod.php") ?>
        <div class="d-flex flex-row w-100 ">

            <?php include("./new_side_mod.php") ?>
            <div class="container-fluid myPage">
                <div class="row justify-content-center p-5">
                    <div class="p-3">
                        <!-- 篩選表單 (保留排序參數) -->
                        <form method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="" class="text-white">關鍵字搜尋</label>
                                <input type="text" name="search" class="form-control" placeholder="輸入課程名稱或描述" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="" class="text-white">類型</label>
                                <select name="type" class="form-control">
                                    <option value="all" <?= (isset($_GET['type']) && $_GET['type'] === 'all') ? 'selected' : '' ?>>全部</option>
                                    <option value="雙板" <?= (isset($_GET['type']) && $_GET['type'] === '雙板') ? 'selected' : '' ?>>雙板</option>
                                    <option value="單板" <?= (isset($_GET['type']) && $_GET['type'] === '單板') ? 'selected' : '' ?>>單板</option>
                                </select>
                            </div>
                            <div class="col-md-3 ">
                                <label for="" class="text-white">難度</label>
                                <select name="difficulty" class="form-control">
                                    <option value="" <?= empty($_GET['difficulty']) ? 'selected' : '' ?>>全部</option>
                                    <option value="初級" <?= (isset($_GET['difficulty']) && $_GET['difficulty'] === '初級') ? 'selected' : '' ?>>初級</option>
                                    <option value="中級" <?= (isset($_GET['difficulty']) && $_GET['difficulty'] === '中級') ? 'selected' : '' ?>>中級</option>
                                    <option value="高級" <?= (isset($_GET['difficulty']) && $_GET['difficulty'] === '高級') ? 'selected' : '' ?>>高級</option>
                                </select>
                            </div>
                            <!-- 保留排序參數 -->
                            <input type="hidden" name="sort" value="<?= isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : '' ?>">
                            <div class="col-md-3 d-flex align-items-end gap-3">
                                <button type="submit" class="btn btn-primary">篩選</button>
                                <a href="courses.php" class="btn btn-secondary">重設</a>
                                <!-- 新增課程按鈕 -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                                    新增課程
                                </button>
                            </div>
                        </form>
                        <!-- 排序按鈕 -->
                        <?php
                        // 複製 GET 參數
                        $queryParams = $_GET;
                        unset($queryParams['page']); // 排序時重設分頁
                        ?>
                        <div class="d-flex justify-content-end my-3">
                            <?php
                            $queryParams['sort'] = 'price_asc';
                            $sortAscLink = "?" . http_build_query($queryParams);
                            $queryParams['sort'] = 'price_desc';
                            $sortDescLink = "?" . http_build_query($queryParams);
                            $queryParams['sort'] = 'created_at';
                            $sortCreatedLink = "?" . http_build_query($queryParams);
                            ?>
                            <a href="<?= $sortAscLink ?>" class="btn btn-outline-primary me-2 text-white">價格：低 → 高</a>
                            <a href="<?= $sortDescLink ?>" class="btn btn-outline-primary me-2 text-white">價格：高 → 低</a>
                            <a href="<?= $sortCreatedLink ?>" class="btn btn-outline-primary me-2 text-white">最新課程</a>
                            <a href="courses.php" class="btn btn-outline-secondary me-2 text-white">取消排序</a>
                        </div>
                        <!-- Bootstrap Modal（新增課程視窗） -->
                        <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addCourseModalLabel">新增課程</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="add_course" value="1">
                                            <div class="mb-3">
                                                <label>課程名稱</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>課程描述</label>
                                                <textarea name="description" class="form-control" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label>課程圖片</label>
                                                <input type="file" name="image[]" class="form-control" multiple>
                                            </div>
                                            <div class="mb-3">
                                                <label>單/雙板</label>
                                                <select name="type" class="form-control" required>
                                                    <option value="雙板">雙板</option>
                                                    <option value="單板">單板</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>難易度</label>
                                                <select name="difficulty" class="form-control" required>
                                                    <option value="初級">初級</option>
                                                    <option value="中級">中級</option>
                                                    <option value="高級">高級</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>時長（小時）</label>
                                                <select name="duration" class="form-control" required>
                                                    <option value="3">3小時</option>
                                                    <option value="4">4小時</option>
                                                    <option value="5">5小時</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>價格（元）</label>
                                                <input type="number" name="price" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>選擇教練</label>
                                                <select name="coach_id" class="form-control">
                                                    <option value="">不指定教練</option>
                                                    <?php foreach ($coaches as $coach): ?>
                                                        <option value="<?= $coach['id'] ?>"><?= htmlspecialchars($coach['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>地點</label>
                                                <select name="location_id" class="form-control" required>
                                                    <?php foreach ($locations as $location): ?>
                                                        <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>最大參與人數</label>
                                                <input type="number" name="max_participants" class="form-control" min="1" value="1" required>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                <button type="submit" class="btn btn-primary">提交</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 課程列表 -->
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr class="text-center">
                                    <th>圖片</th>
                                    <th>名稱</th>
                                    <th>類型</th>
                                    <th>難度</th>
                                    <th>時長</th>
                                    <th>價格</th>
                                    <th>教練</th>
                                    <th>地點</th>
                                    <th>最大人數</th>
                                    <th>編輯</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): ?>
                                    <tr class="text-center">
                                        <td class="">
                                            <?php
                                            $images = !empty($course['images']) ? explode(',', $course['images']) : [];
                                            if (!empty($images) && isset($images[0])):
                                                $modalId = "imageModal-" . htmlspecialchars($course['id']) . "-" . uniqid();
                                            ?>
                                                <img src="<?= htmlspecialchars($images[0]) ?>" width="100" height="100" class="img-thumbnail preview-img" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                                                <!-- Bootstrap Modal（顯示所有圖片） -->
                                                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">課程圖片</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <?php foreach ($images as $img): ?>
                                                                    <img src="<?= htmlspecialchars($img) ?>" class="img-fluid mb-2" style="max-height: 300px;">
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span>請確認是否上傳照片</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="w-25"><?= htmlspecialchars($course['name']) ?></td>
                                        <td><?= htmlspecialchars($course['type']) ?></td>
                                        <td><?= htmlspecialchars($course['difficulty']) ?></td>
                                        <td><?= htmlspecialchars($course['duration']) ?> 小時</td>
                                        <td>$<?= htmlspecialchars(number_format($course['price'])) ?></td>
                                        <td><?= !empty($course['coach_name']) ? htmlspecialchars($course['coach_name']) : "未指定" ?></td>
                                        <td><?= htmlspecialchars($course['location_name']) ?></td>
                                        <td><?= isset($course['max_participants']) ? htmlspecialchars($course['max_participants']) : '未設定' ?></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal-<?= htmlspecialchars($course['id']) ?>">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?= htmlspecialchars($course['id']) ?>">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-course-id="<?= htmlspecialchars($course['id']) ?>">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="modal fade" id="detailsModal-<?= htmlspecialchars($course['id']) ?>" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-start">課程詳情 - <?= htmlspecialchars($course['name']) ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <p><strong>描述：</strong><?= nl2br(htmlspecialchars($course['description'])) ?></p>
                                                            <p><strong>類型：</strong><?= htmlspecialchars($course['type']) ?></p>
                                                            <p><strong>難度：</strong><?= htmlspecialchars($course['difficulty']) ?></p>
                                                            <p><strong>時長：</strong><?= htmlspecialchars($course['duration']) ?> 小時</p>
                                                            <p><strong>價格：</strong>$<?= htmlspecialchars($course['price']) ?></p>
                                                            <p><strong>教練：</strong><?= !empty($course['coach_name']) ? htmlspecialchars($course['coach_name']) : "未指定" ?></p>
                                                            <p><strong>地點：</strong><?= htmlspecialchars($course['location_name']) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- 編輯課程的跳窗 -->
                        <?php foreach ($courses as $course): ?>
                            <div class="modal fade" id="editModal-<?= htmlspecialchars($course['id']) ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">編輯課程 - <?= htmlspecialchars($course['name']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="edit_course.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                                                <div class="mb-3">
                                                    <label>課程名稱</label>
                                                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($course['name']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>課程描述</label>
                                                    <textarea name="description" class="form-control" required><?= htmlspecialchars($course['description']) ?></textarea>
                                                </div>
                                                <?php
                                                // 查詢目前該課程的所有圖片
                                                $stmt_photos = $db_host->prepare("SELECT id, image_url FROM courseimages WHERE course_id = :course_id");
                                                $stmt_photos->execute(['course_id' => $course['id']]);
                                                $photos = $stmt_photos->fetchAll(PDO::FETCH_ASSOC);
                                                ?>
                                                <div class="mb-3">
                                                    <label>目前照片</label>
                                                    <div class="d-flex flex-wrap">
                                                        <?php foreach ($photos as $photo): ?>
                                                            <div class="position-relative m-2" style="width:150px; height:150px;">
                                                                <img src="<?= htmlspecialchars($photo['image_url']) ?>" alt="Course Photo" class="img-thumbnail" style="width:100%; height:100%; object-fit:cover;">
                                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-photo-btn" data-photo-id="<?= $photo['id'] ?>" style="border-radius:50%;">&times;</button>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>新增照片</label>
                                                    <input type="file" name="new_images[]" class="form-control" multiple>
                                                </div>
                                                <div class="mb-3">
                                                    <label>價格（元）</label>
                                                    <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($course['price']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>類型</label>
                                                    <select name="type" class="form-control" required>
                                                        <option value="雙板" <?= ($course['type'] == "雙板") ? 'selected' : '' ?>>雙板</option>
                                                        <option value="單板" <?= ($course['type'] == "snowboard") ? 'selected' : '' ?>>單板</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>難易度</label>
                                                    <select name="difficulty" class="form-control" required>
                                                        <option value="初級" <?= ($course['difficulty'] == "初級") ? 'selected' : '' ?>>初級</option>
                                                        <option value="中級" <?= ($course['difficulty'] == "中級") ? 'selected' : '' ?>>中級</option>
                                                        <option value="高級" <?= ($course['difficulty'] == "高級") ? 'selected' : '' ?>>高級</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>時長（小時）</label>
                                                    <select name="duration" class="form-control" required>
                                                        <option value="3" <?= ($course['duration'] == "3") ? 'selected' : '' ?>>3 小時</option>
                                                        <option value="4" <?= ($course['duration'] == "4") ? 'selected' : '' ?>>4 小時</option>
                                                        <option value="5" <?= ($course['duration'] == "5") ? 'selected' : '' ?>>5 小時</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>選擇教練</label>
                                                    <select name="coach_id" class="form-control">
                                                        <option value="">不指定教練</option>
                                                        <?php foreach ($coaches as $coach): ?>
                                                            <option value="<?= $coach['id'] ?>" <?= ($course['coach_name'] == $coach['name']) ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($coach['name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                <label>地點</label>
                                                <select name="location_id" class="form-control" required>
                                                    <?php foreach ($locations as $location): ?>
                                                        <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                                <div class="mb-3">
                                                    <label>最大參與人數</label>
                                                    <input type="number" name="max_participants" class="form-control" min="1"
                                                        value="<?= isset($course['max_participants']) ? htmlspecialchars($course['max_participants']) : 1 ?>" required>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">儲存修改</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- 分頁按鈕 -->
                        <?php
                        // 複製所有 GET 參數
                        $queryParams = $_GET;
                        unset($queryParams['page']);
                        $prevDisabled = ($page <= 1);
                        $nextDisabled = ($page >= $total_pages);
                        if (!$prevDisabled) {
                            $queryParams['page'] = $page - 1;
                            $prevLink = "?" . http_build_query($queryParams);
                        } else {
                            $prevLink = "#";
                        }
                        if (!$nextDisabled) {
                            $queryParams['page'] = $page + 1;
                            $nextLink = "?" . http_build_query($queryParams);
                        } else {
                            $nextLink = "#";
                        }
                        ?>
                        <div class="d-flex justify-content-center mt-4">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item <?= $prevDisabled ? 'disabled' : '' ?> ">
                                        <a class="page-link" href="<?= $prevLink ?>" aria-label="Previous">
                                            <span aria-hidden="true" class="text-black">&laquo; 上一頁</span>
                                        </a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <?php
                                        $queryParams['page'] = $i;
                                        $pageLink = "?" . http_build_query($queryParams);
                                        ?>
                                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                            <a class="page-link text-black" href="<?= $pageLink ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?= $nextDisabled ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= $nextLink ?>" aria-label="Next">
                                            <span aria-hidden="true" class="text-black">下一頁 &raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php include("./js.php") ?>
    <script>
        $(document).on("show.bs.modal", ".modal", function() {
            $("body").append($(this));
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            // 出場動畫：loading 畫面淡出
            gsap.to("#loadingOverlay", {
                opacity: 0,
                duration: 0.5,
                onComplete: function() {
                    document.getElementById("loadingOverlay").style.display = "none";
                }
            });

            //以下是自己網頁的入場動畫

            gsap.fromTo("#mainContent", {
                rotation: -10,
                opacity: 0
            }, {
                rotation: 0,
                opacity: 1,
                duration: 0.8,
                ease: "back.out(1.5)"
            });
            //還不錯

            // gsap.fromTo("#mainContent", 
            //   { scale: 0.8, opacity: 0 }, 
            //   { scale: 1, opacity: 1, duration: 0.8, ease: "power2.out" }
            // );
            //普通

            // gsap.fromTo("#mainContent", 
            //   { filter: "blur(5px)", opacity: 0 }, 
            //   { filter: "blur(0px)", opacity: 1, duration: 0.8, ease: "power2.out" }
            // );


            // gsap.from("#mainContent", {
            //   y: 100,
            //   duration: 0.8,
            //   ease: "elastic.out(1, 0.5)"
            // });

            // let elements = document.querySelectorAll("#mainContent div");
            // elements.forEach(el => {
            //     gsap.from(el, {
            //         x: gsap.utils.random(-50, 50),
            //         y: gsap.utils.random(-50, 50),
            //         duration: 1,
            //         ease: "back.out(1.5)"
            //     });
            // });
            //不怎麼好看但很炫

            // gsap.from("#mainContent", {
            //     rotateY: -90,
            //     duration: 1,
            //     ease: "back.out(1.7)"
            // });
            // 還不錯

        });
    </script>
</body>

</html>