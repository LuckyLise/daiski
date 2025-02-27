<?
require_once("../db_connect.php");
$sql = "SELECT * FROM images ORDER BY id DESC";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
    <title>File upload</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <? include("../css.php") ?>
</head>

<body>
    <div class="container">
        <!-- 有設定 enctype="multipart/form-data" 才能從表單上傳檔案 -->
        <form action="doUpload.php" method="post" enctype="multipart/form -data">
            <div class="mb-2">
                <label for="" class="form-label">檔案名稱</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="mb-2">
                <label for="" class="form-lable">選取檔案</label>
                <!-- accept 接受檔案類型 -->
                <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png">
            </div>
            <button class="btn btn-primary" type="submit">送出</button>
        </form>


        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
            <? foreach ($rows as $row): ?>
                <div class="col">
                    <div class="ratio ratio-1x1">
                        <img class="object-fit-cover" src="/img/<?= $row["image"] ?>" alt="<?= $row["name"] ?>">
                    </div>
                    <h3 class="h4"><?= $row["name"] ?></h3>
                </div>
            <? endforeach; ?>

        </div>

    </div>


    <? include("../js.php") ?>
</body>

</html>