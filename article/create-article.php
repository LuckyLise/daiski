<?php
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

    <?php include("./css.php") ?>
</head>

<body>

    <div class="d-flex flex-column">
        <?php include("./new_head_mod.php"); ?>

        <div class="d-flex flex-row w-100 ">
            <?php include("./new_side_mod.php"); ?>


            <div class="container myPage">
                <div class="py-2">
                    <a class="btn btn-primary" href="articles.php"><i class="fa-solid fa-list fa-fw"></i>文章列表</a>
                </div>
                <form action="doCreateArticle.php" method="post">
                    <table class="table table-bordered">
                        <tr>
                            <th>類別</th>
                            <!-- <input type="text" class="form-control" name="title"> -->
                            <td>

                                <div class="dropdown">
                                    <button class="btn_category btn btn-light dropdown-toggle" href="#" type="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        選擇分類

                                    </button>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <?php foreach ($categories as $category): ?>
                                            <li><a class="btn_category_choose dropdown-item" href="#"><?= $category["category"] ?></a></li>
                                        <?php endforeach; ?>

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
                            <!-- draggable 允許GUI拖拉上傳 -->
                            <th>圖片</th>
                            <td>
                                <!-- multiple="multiple" draggable="true" -->
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
                                <input type="datetime-local" class="form-control" name="startDate"
                                    value="">

                            </td>
                            <td>
                                <label for="endDate">結束時間</label>
                                <input type="datetime-local" class="form-control" name="endDate"
                                    value="">
                            </td>
                        </table>

                    </table>
                    <button class="btn btn-primary" type="submit">送出</button>
                </form>

            </div>

        </div>
    </div>


    <?php include("./js.php") ?>
    <script>
        const btn_category_choose = document.querySelectorAll(".btn_category_choose");

        const btn_category = document.querySelector(".btn_category");

        btn_category_choose.forEach(function(category_choose) {
            category_choose.addEventListener("click", function() {
                btn_category.textContent = category_choose.textContent;
            })
        });
    </script>

</body>

</html>