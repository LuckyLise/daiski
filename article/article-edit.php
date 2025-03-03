<?php
// 系統注重防呆，要給使用者好的體驗
if (!isset($_GET["id"])) {
    header("location: articles.php");
}

$id = $_GET["id"];


require_once("../pdo_connect.php");
$sql = "SELECT * FROM article WHERE id = $id";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $row = $stmt->fetch();
} catch (PDOException $e) {

    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

$userCount = $stmt->rowCount();

// 圖片
$sql = "SELECT name, sort
FROM article_images
WHERE article_id=$id
";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $article_imgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}


// 影片
$sql = "SELECT name, sort
FROM article_videos
WHERE article_id=$id
";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $article_videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯文章</title>
    <?php include("./css.php") ?>
    <style>
        .article_content {
            height: 30vh;
        }
    </style>
</head>

<body>
    <!-- Loading 畫面 -->
    <div id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">系統資訊</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    確認要刪除文章? <br> 一經刪除將無法復原!
                </div>
                <div class="modal-footer">
                    <a href="articleDelete.php?id=<?= $row["id"] ?>" role="button" class="btn btn-danger">刪除</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>



    <div class="d-flex flex-column">
        <?php include("./new_head_mod.php"); ?>

        <div class="d-flex flex-row w-100 myPage">
            <?php include("./new_side_mod.php"); ?>


            <div class="container ">
                <div class="py-2">
                    <a class="btn btn-primary" href="article.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-list fa-fw"></i>上一步</a>
                </div>
                <div class="row">
                    <div class="clo-lg-4 col-md-9">
                        <?php if ($userCount > 0): ?>
                            <form action="doUpdateArticle.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <table class="table table-bordered">
                                    <!-- (tr>th+td)*5 -->
                                    <tr>
                                        <th>id</th>
                                        <td><?= $row["id"] ?></td>
                                    </tr>

                                    <tr>

                                        <th>標題</th>
                                        <td>
                                            <input type="text" class="form-control" name="title"
                                                value="<?= $row["title"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>內容</th>
                                        <td>
                                            <textarea type="text" class="form-control article_content" name="content"><?= trim($row["content"], " ") ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>圖片</th>
                                        <td>
                                            <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
                                                <?php foreach ($article_imgs as $img): ?>
                                                    <div class="col">
                                                        <?php
                                                        // 檢查路徑是否有檔案
                                                        $img_PATH = "article_imgs/" . $img["name"];
                                                        if (file_exists($img_PATH)):
                                                        ?>
                                                            <div class="ratio ratio-1x1">
                                                                <img class="object-fit-cover" src="article_imgs/<?= $img["name"] ?>" alt="">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <input type="file" multiple class="form-control" name="images" accept=".jpg, .jpeg, .png">
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>影片</th>

                                        <td>
                                            <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
                                                <?php foreach ($article_videos as $video): ?>
                                                    <div class="col">
                                                        <?php
                                                        // 檢查路徑是否有檔案
                                                        $video_PATH = "article_videos/" . $video["name"];
                                                        if (file_exists($video_PATH)):
                                                        ?>
                                                            <div class="ratio ratio-1x1">
                                                                <img class="object-fit-cover" src="article_videos/<?= $video["name"] ?>" alt="">
                                                            </div>
                                                            <h3 class="h4"><?= $video["name"] ?></h3>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <input type="file" class="form-control" name="videos" accept=".mp4 .mkv .wmv">
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>發布日期</th>
                                        <td>
                                            <input type="text" class="form-control" name="startDate"
                                                value="<?= $row["startDate"] ?>">
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>結束日期</th>
                                        <td>
                                            <input type="text" class="form-control" name="endDate"
                                                value="<?= $row["endDate"] ?>">
                                        </td>
                                    </tr>
                                </table>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk fa-fw"></i>儲存</button>

                                    <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="fa-solid fa-trash fa-fw"></i>刪除</a>
                                </div>
                            </form>

                        <?php else: ?>
                            <h2>使用者不存在</h2>
                        <?php endif; ?>
                    </div>
                </div>
                <?php include("./js.php") ?>
            </div>
        </div>
    </div>
    <?php include("./js.php") ?>
</body>

</html>