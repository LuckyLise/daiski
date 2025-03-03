<?php
// 系統注重防呆，要給使用者好的體驗
if (!isset($_GET["id"])) {
    header("location: articles.php");
}


// GET是抓網址，需在網址後面加上 "?id=1"
$id = $_GET["id"];


require_once("../pdo_connect.php");

// 主表接受各方單一選項。例如文章當主表，至多一個的"點閱率"、"類別"可以JOIN進來(如必有可以用JOIN，不一定有要用LEFT JOIN)，
// 但可能有很多的如"影片"、"圖片"則要另外SQL，不然表會用倍數成長(主表*圖片數，因為一個列只能填一張圖片，所以一列只能JOIN一張圖片)



// 主表、點閱率、分類
$sql = "SELECT article.*, COUNT(article_ctr.article_id) AS ctr, article_categories.category
FROM article
LEFT JOIN article_categories ON article_categories.article_id = article.id
LEFT JOIN article_ctr ON article_ctr.article_id = article.id
WHERE article.id=$id
GROUP BY article_ctr.article_id
";

$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $article = $stmt->fetch();
    $userCount = $stmt->rowCount();
} catch (PDOException $e) {
    $article = $stmt->fetch();
    print_r($row);
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

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
    <title>article</title>
    <?php include("./css.php") ?>

</head>

<body>

    <div class="d-flex flex-column">
        <?php include("./new_head_mod.php"); ?>

        <div class="d-flex flex-row w-100 ">
            <?php include("./new_side_mod.php"); ?>

            <div class="container myPage">
                <div class="py-2 ">
                    <a class="btn btn-primary" href="articles.php"><i class="fa-solid fa-list fa-fw"></i>文章列表</a>
                </div>
                <div class="row g-3">
                    <div class="clo-lg-4 col-md-9">
                        <?php if ($userCount > 0): ?>
                            <table class="table table-bordered">
                                <!-- (tr>th+td)*5 -->
                                <tr>
                                    <th>ID</th>
                                    <td><?= $article["id"] ?></td>
                                </tr>
                                <tr>
                                    <th>類別</th>
                                    <?php $category = ($article["category"]) ?  $article["category"] : "未分類" ?>
                                    <td><?= $category ?></td>
                                </tr>
                                <tr>
                                    <th>標題</th>
                                    <td><?= $article["title"] ?></td>
                                </tr>
                                <tr>
                                    <th>內容</th>
                                    <td><?= $article["content"] ?></td>
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
                                                        <h3 class="h4"><?= $img["name"] ?></h3>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>影片</th>
                                    <td>
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
                                    </td>
                                </tr>
                                <tr>
                                    <th>發布日期</th>
                                    <td><?= $article["startDate"] ?></td>
                                </tr>
                                <tr>
                                    <th>結束日期</th>
                                    <td><?= $article["endDate"] ?></td>
                                </tr>
                                <tr>
                                    <th>點閱率</th>
                                    <td><?= $article["ctr"] ?></td>
                                </tr>
                            </table>
                            <div class="">
                                <a class=" btn btn-primary" href="article-edit.php?id=<?= $article["id"] ?>"><i class="fa-regular fa-pen-to-square"></i>編輯</a>
                            </div>

                    </div>


                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include("./js.php") ?>
</body>

</html>