<?php
require_once("./pdo_connect.php");
$sqlAll = "SELECT * FROM article";
$stmtAll = $db_host->prepare($sqlAll);
try {
    $stmtAll->execute();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}
// 預設為所有筆數，若有q再改變
$userCount = $stmtAll->rowCount();




// q搜尋、p頁數
$order = 1;
if (isset($_GET["q"]) && isset($_GET["p"]) && isset($_GET["order"])) {
    $q = $_GET["q"];
    $order = $_GET["order"];
    // 每頁顯示數量
    $p = $_GET["p"];
    $perPage = 5;
    $startItem = ($p - 1) * $perPage;
    $totalPage = ceil($userCount / $perPage);
    switch ($order) {
        case 1:
            $orderBytext = "id";
            $ordertext = "ASC";
            break;
        case 2:
            $orderBytext = "id";
            $ordertext = "DESC";
            break;
        case 3:
            $orderBytext = "startDate";
            $ordertext = "ASC";
            break;
        case 4:
            $orderBytext = "startDate";
            $ordertext = "DESC";
            break;
    }


    $sql = "SELECT article.*, article_categories.category
    FROM article 
    LEFT JOIN article_categories ON article_categories.article_id = article.id
    WHERE article.title LIKE '%$q%' OR article_categories.category LIKE '%$q%'
    ORDER BY $orderBytext $ordertext
    LIMIT $startItem,$perPage
    ";
} else if (isset($_GET["p"]) && isset($_GET["order"])) {
    $order = $_GET["order"];

    // 每頁顯示數量
    $p = $_GET["p"];

    $perPage = 5;
    $startItem = ($p - 1) * $perPage;
    $totalPage = ceil($userCount / $perPage);

    switch ($order) {
        case 1:
            $orderBytext = "id";
            $ordertext = "ASC";
            break;
        case 2:
            $orderBytext = "id";
            $ordertext = "DESC";
            break;
        case 3:
            $orderBytext = "startDate";
            $ordertext = "ASC";
            break;
        case 4:
            $orderBytext = "startDate";
            $ordertext = "DESC";
            break;
    }
    $sql = "SELECT article.*, article_categories.category
    FROM article 
    LEFT JOIN article_categories ON article_categories.article_id = article.id
    ORDER BY $orderBytext $ordertext
    LIMIT $startItem,$perPage
    
    ";
} else {
    header("location:articles.php?p=1&order=1");
}

$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

// 預設為所有筆數，若有q再改變
if (isset($_GET["q"])) {
    $userCount = $stmt->rowCount();
}

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
<html lang="en">

<head>
    <title>users</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>
    <style>
        .article_content {

            /* 超出的隱藏 */
            overflow: auto;
            /* 固定邊框大小 */
            display: block;

            max-width: 30vw;
            height: 15vh;
        }
    </style>
</head>

<body>


    <div class="d-flex flex-column">
        <?php include("./new_head_mod.php") ?>
        <div class="d-flex flex-row w-100 ">
            <?php include("./new_side_mod.php") ?>

            <div class="container">

                <div class="pb-2">
                    <!-- fa-fw 固定icon寬度 -->
                    <a class="btn btn-primary" href="create-article.php"><i class="fa-solid fa-user-plus fa-fw"></i>新增文章</a>
                </div>



                <div class="py-2 row g-3 align-items-center">

                    <div class="col-md-6">
                        <div class="hstack gap-2 align-items-center">
                            <?php if (isset($_GET["q"])): ?>
                                <a class="btn btn-primary" href="articles.php"><i class="fa-solid fa-arrow-left fa-fw"></i>回文章列表</a>
                            <?php endif; ?>
                            <div> 共 <?= $userCount ?> 篇文章</div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <form action="" method="get">
                            <!-- php可以寫在div內 -->
                            <div class="input-group">
                                <!-- value 按下按鈕後欄位要顯示什麼，name代表網址後面加上q=表單內容 -->
                                <input type="search" class="form-control" name="q"
                                    <?php $q = $_GET["q"] ?? ""; ?>
                                    value="<?= $q ?>">

                                <input type="hidden" class="form-control" name="p"
                                    <?php $order = $_GET["p"] ?? "1"; ?>
                                    value="<?= $p ?>">

                                <input type="hidden" class="form-control" name="order"
                                    <?php $order = $_GET["order"] ?? "1"; ?>
                                    value="<?= $order ?>">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa-fw"></i>搜尋</button>

                            </div>

                        </form>

                    </div>
                </div>

                <div class="py-2 text-end">
                    <div class="btn-group">

                        <?php if (isset($_GET["q"])) {
                            $q = "q=" . $_GET["q"] . "&";
                        } ?>
                        <!-- 根據網址的order排序決定給哪個按鈕"active" -->
                        <a class="btn btn-primary <?php if ($order == 1) echo "active" ?>" href="articles.php?<?= $q ?>p=<?= $p ?>&order=1">ID升冪<i class="fa-solid fa-arrow-down-1-9 fa-fw"></i></a>
                        <a class="btn btn-primary <?php if ($order == 2) echo "active" ?>" href="articles.php?<?= $q ?>p=<?= $p ?>&order=2">ID降冪<i class="fa-solid fa-arrow-down-9-1" fa-fw></i></a>
                        <a class="btn btn-primary <?php if ($order == 3) echo "active" ?>" href="articles.php?<?= $q ?>p=<?= $p ?>&order=3">發布升冪<i class="fa-solid fa-arrow-down-a-z" fa-fw></i></a>
                        <a class="btn btn-primary <?php if ($order == 4) echo "active" ?>" href="articles.php?<?= $q ?>p=<?= $p ?>&order=4">發布降冪<i class="fa-solid fa-arrow-down-z-a" fa-fw></i></a>
                    </div>

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



                </div>

                <?php if ($userCount > 0): ?>
                    <table class="table table-bordered table-hover table ">
                        <thead class="table-light text-center">
                            <tr>
                                <th>狀態<i class="fa-solid fa-up-down fa-fw"></i></th>
                                <th>類別</th>
                                <th>標題</th>
                                <th>內容</th>
                                <th>發布日期</th>
                                <th>結束日期</th>
                                <th>查看/編輯</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <!-- 未發布、已發布、已結束 -->
                                    <td><?php
                                        $nowTime = time();
                                        $startTime = strtotime($row["startDate"]);
                                        $endTime = strtotime($row["endDate"]);


                                        if ($nowTime < $startTime || $row["startDate"] == "0000-00-00 00:00:00") {
                                            echo '<span class="text-dark">未發布</span>';
                                        } else if ($nowTime > $startTime && ($endTime == FALSE || $endTime > $nowTime)) {
                                            echo '<span class="text-success">發布中</span>';
                                        } else if ($nowTime > $endTime) {
                                            echo '<span class="text-danger">已結束</span>';
                                        }
                                        ?>
                                    </td>
                                    <?php $category = ($row["category"]) ?  $row["category"] : "未分類" ?>
                                    <td><?= $category ?></td>

                                    <td><?= $row["title"]; ?></td>
                                    <td class="article_content"><?= $row["content"]; ?></td>
                                    <td><?= $row["startDate"]; ?></td>

                                    <td><?php
                                        if ($row["endDate"] == "") {
                                            echo $row["endDate"];
                                        } else {
                                            echo $row["endDate"];
                                        }
                                        ?></td>

                                    <td class=" text-center">
                                        <a class="btn btn-primary" href="article.php?id=<?= $row['id']; ?>"><i class="fa-regular fa-eye fa-fw"></i>查看</a>

                                        <a class=" btn btn-primary" href="article-edit.php?id=<?= $row['id']; ?>"><i class="fa-regular fa-pen-to-square fa-fw"></i>編輯</a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if (isset($_GET["p"])): ?>
                        <!-- bs套件 pagination -->
                        <nav aria-label="Page navigation example">
                            <?php

                            $next = ($p == $totalPage) ? "disabled" : "";
                            $pre = ($p == 1)  ? "disabled" : "";

                            $p = $_GET["p"];
                            $order = $_GET["order"];

                            ?>
                            <ul class="pagination">
                                <!-- 上一頁 -->
                                <li class="page-item">
                                    <a class="page-link <?= $pre ?>" href="articles.php?p=<?= $p - 1 ?>&order=<?= $order ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <!--  加上active讓當前分頁有顏色 -->
                                <?php for ($i = 1; $i <= $totalPage; $i++): ?>

                                    <?php $active = ($i == $_GET["p"]) ? "active" : ""; ?>

                                    <li class="page-item <?= $active ?>"><a class="page-link" href="articles.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                                <?php endfor; ?>

                                <!-- 下一頁 -->
                                <li class="page-item">
                                    <a class="page-link  <?= $next ?> " href="articles.php?p=<?= $p + 1 ?>&order=<?= $order ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>




                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>




    <?php include("./js.php") ?>



    <script>
        VANTA.BIRDS({
            el: ".sidebar", // 指定作用的 HTML 元素 ID
            mouseControls: true, // 啟用滑鼠控制，使動畫會跟隨滑鼠移動
            touchControls: true, // 啟用觸控控制，使動畫可以隨觸控移動
            gyroControls: false, // 禁用陀螺儀控制（手機旋轉時不影響動畫）
            minHeight: 50.00, // 設定最小高度，確保畫面不會小於 200px
            minWidth: 50.00, // 設定最小寬度，確保畫面不會小於 200px
            scale: 1.00, // 設定一般裝置上的縮放比例
            scaleMobile: 2.0, // 在手機上放大 2 倍，以提升可視度
            separation: 100.00, // 調整鳥群之間的間隔，數值越大，距離越大
            color1: 0xffffff,
            birdSize: 0.10,
            quantity: 5,
            speedLimit: 2,
            alignment: 50
            // backgroundColor:0x4e73df
        });

        //VANTA.WAVES({ //目前註解掉
        //  el: "body", //綁在body上會使該網頁的modal跳出來時有問題 最好綁在你需要的class上
        //  mouseControls: true,
        //  touchControls: true,
        //  gyroControls: false,
        //  minHeight: 200.00,
        //  minWidth: 200.00,
        //  scale: 1.00,
        //  scaleMobile: 1.00,
        //  color:0xb2e2ff
        // })
    </script>



</body>

</html>