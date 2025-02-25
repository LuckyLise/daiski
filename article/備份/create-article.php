<?
require_once("../pdo_connect.php");
$sql = "SELECT category FROM article_categories GROUP BY category";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($categories);
} catch (PDOException $e) {

    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

?>


<!doctype html>
<!-- 建立表單，按下"送出"按鈕後，將表單資料以"post"形式送給doCreate.php -->

<html lang="en">

<head>
    <title>新增文章</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <? include("../css.php") ?>
</head>

<body>
    <div class="container">
        <div class="py-2">
            <a class="btn btn-primary" href="articles.php"><i class="fa-solid fa-list fa-fw"></i>文章列表</a>
        </div>
        <?= $_GET["p"] ?>
        <form action="doCreate.php" method="post">
            <table class="table table-bordered">

                <tr>
                    <th>類別</th>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" href="#" type="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                選擇分類

                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <? foreach ($categories as $category): ?>
                                    <li><a class="dropdown-item" href="creat-article.php?p=123"><?= $category["category"] ?></a></li>
                                <? endforeach; ?>

                            </ul>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>標題</th>
                    <td>
                        <input type="text" class="form-control" name="title">
                    </td>
                </tr>
                <tr>
                    <th>內容</th>
                    <td>
                        <textarea type="text" class="form-control article_content" name="content"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>圖片</th>
                    <td>
                        <input type="file" class="form-control" name="images" accept=".jpg, .jpeg, .png">
                    </td>

                </tr>
                <tr>
                    <th>影片</th>

                    <td>
                        <input type="file" class="form-control" name="videos" accept=".mp4 .mkv .wmv">
                    </td>

                </tr>
                <table class="table table-bordered">
                    <th>發布/結束</th>
                    <td>
                        <label for="startDate">發布時間</label>
                        <input type="date" class="form-control" name="startDate"
                            value="">

                    </td>
                    <td>
                        <label for="endDate">結束時間</label>
                        <input type="date" class="form-control" name="endDate"
                            value="">
                    </td>
                </table>


            </table>
            <button class="btn btn-primary" type="submit">送出</button>
        </form>

    </div>




    <!-- <tr>

                                <th>標題</th>
                                <td>
                                    <input type="text" class="form-control" name="title"
                                        value="<?= $row["title"] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>內容</th>
                                <td>
                                    <textarea type="text" class="form-control article_content" name="content">
                                    <?= $row["content"] ?>
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>圖片</th>
                                <td>
                                    <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
                                        <? foreach ($article_imgs as $img): ?>
                                            <div class="col">
                                                <?
                                                // 檢查路徑是否有檔案
                                                $img_PATH = "article_imgs/" . $img["name"];
                                                if (file_exists($img_PATH)):
                                                ?>
                                                    <div class="ratio ratio-1x1">
                                                        <img class="object-fit-cover" src="article_imgs/<?= $img["name"] ?>" alt="">
                                                    </div>
                                                    <h3 class="h4"><?= $img["name"] ?></h3>
                                                <? endif; ?>
                                            </div>
                                        <? endforeach; ?>
                                    </div>
                                    <input type="file" class="form-control" name="images" accept=".jpg, .jpeg, .png">
                                </td>

                            </tr>
                            <tr>
                                <th>影片</th>

                                <td>
                                    <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
                                        <? foreach ($article_videos as $video): ?>
                                            <div class="col">
                                                <?
                                                // 檢查路徑是否有檔案
                                                $video_PATH = "article_videos/" . $video["name"];
                                                if (file_exists($video_PATH)):
                                                ?>
                                                    <div class="ratio ratio-1x1">
                                                        <img class="object-fit-cover" src="article_videos/<?= $video["name"] ?>" alt="">
                                                    </div>
                                                    <h3 class="h4"><?= $video["name"] ?></h3>
                                                <? endif; ?>
                                            </div>
                                        <? endforeach; ?>
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
                        -->


    <? include("../js.php") ?>
</body>

</html>