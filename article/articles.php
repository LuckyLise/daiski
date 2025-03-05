<?php
require_once("../pdo_connect.php");
// 計算總文章數
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


// q搜尋、p頁數、order排序、category分類(跟搜尋同原理)
$order = 1;
if (isset($_GET["p"]) && isset($_GET["order"])) {
    if (isset($_GET["q"])) {
        $q = $_GET["q"];
    } else if (isset($_GET["category"])) {
        $category = $_GET["category"];
    }

    $order = $_GET["order"];

    $p = $_GET["p"];
} else {
    header("location:articles.php?p=1&order=1");
}

$where = "";
if (isset($_GET["q"])) {
    $q = $_GET["q"];
}
$where_search = (isset($_GET["q"])) ? "article.title LIKE '%$q%' " : "";
if (isset($_GET["category"])) {
    $category = $_GET["category"];
}
$where_category = (isset($_GET["category"])) ? "article_categories.category LIKE '%$category%' " : "";

$where_and = (isset($_GET["category"]) && (isset($_GET["q"]))) ? " AND " : "";

if (isset($_GET["q"]) || isset($_GET["category"])) {
    $where = "WHERE " . $where_search . $where_and . $where_category;
}

// 篩選後重新計算文章數
$sql = "SELECT article.*, article_categories.category
FROM article 
LEFT JOIN article_categories ON article_categories.article_id = article.id
$where
";

$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $userCount = $stmt->rowCount();
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}


// 每頁顯示數量
$perPage = 5;
$startItem = ($p - 1) * $perPage;
$totalPage = ceil($userCount / $perPage);
switch ($order) {
    case 1:
        $orderBytext = "startDate";
        $ordertext = "DESC";
        break;
    case 2:
        $orderBytext = "startDate";
        $ordertext = "ASC";
        break;
    case 3:
        $orderBytext = "endDate";
        $ordertext = "DESC";
        break;
    case 4:
        $orderBytext = "endDate";
        $ordertext = "ASC";
        break;
}

$sql = "SELECT article.*, article_categories.category
FROM article 
LEFT JOIN article_categories ON article_categories.article_id = article.id
$where
ORDER BY $orderBytext $ordertext
LIMIT $startItem,$perPage
";


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



// 抓類別
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
    <title>articles</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>
    <style>
        .article_content {

            /* 限制幾行 */
            -webkit-line-clamp: 3;
            /* 超出的隱藏 */
            overflow: hidden;

            /* 固定邊框大小 */
            display: -webkit-box;
            /* 垂直固定 */
            -webkit-box-orient: vertical;

            line-height: 1.75em;
            max-height: calc(1.5em * 4);
            /* 限制顯示四行 */

            max-width: 30vw;
            /* height: 15vh; */
        }
    </style>



</head>

<body>
    <!-- Loading 畫面 -->
    <div id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    <div class="d-flex flex-column" id="mainContent">
        <?php include("./new_head_mod.php") ?>
        <div class="d-flex flex-row w-100 myPage">
            <?php include("./new_side_mod.php") ?>

            <div class="container ">

                <div class="pb-2">
                    <!-- fa-fw 固定icon寬度 -->
                    <a class="btn btn-primary" href="create-article.php"><i class="fa-solid fa-user-plus fa-fw"></i>新增文章</a>
                </div>



                <div class="py-2 row g-3 align-items-center">

                    <div class="col-md-6">
                        <div class="hstack gap-2 align-items-center">
                            <?php if (isset($_GET["q"]) || isset($_GET["category"])): ?>
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
                                <input type="search" class="form-control" name="q" placeholder="請輸入文章標題"
                                    <?php $q = $_GET["q"] ?? ""; ?>
                                    value="<?= $q ?>">

                                <input type="hidden" class="form-control" name="p"
                                    <?php $p = "1"; ?>
                                    value="<?= $p ?>">
                                <?php if (isset($_GET["category"])): ?>
                                    <input type="hidden" class="form-control" name="category"
                                        value="<?= $_GET["category"] ?>">
                                <?php endif;  ?>
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

                        <?php
                        if (isset($_GET["q"])) {
                            $q = "q=" . $_GET["q"] . "&";
                        } else {
                            $q = "";
                        }
                        if (isset($_GET["category"])) {
                            $category = "&category=" . $_GET["category"];
                        } else {
                            $category = "";
                        } ?>

                        <!-- 根據網址的order排序決定給哪個按鈕"active" -->
                        <a class="btn btn-primary <?php if ($order == 1) echo "active" ?>" href="articles.php?<?= $q ?>p=<?= $p ?>&order=1<?= $category ?>">發布降冪<i class="fa-solid fa-arrow-down-1-9 fa-fw"></i></a>
                        <a class="btn btn-primary <?php if ($order == 2) echo "active" ?>" href="articles.php?<?= $q ?>p=<?= $p ?>&order=2<?= $category ?>">發布升冪<i class="fa-solid fa-arrow-down-9-1" fa-fw></i></a>
                        <a class="btn btn-primary <?php if ($order == 3) echo "active" ?>" href="articles.php?<?= $q ?>p=<?= $p ?>&order=3<?= $category ?>">結束降冪<i class="fa-solid fa-arrow-down-a-z" fa-fw></i></a>
                        <a class="btn btn-primary <?php if ($order == 4) echo "active" ?>" href="articles.php?<?= $q ?>p=<?= $p ?>&order=4<?= $category ?>">結束升冪<i class="fa-solid fa-arrow-down-z-a" fa-fw></i></a>
                    </div>

                    <div class="dropdown">
                        <button class="btn_category btn btn-primary dropdown-toggle" href="#" type="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                            if (isset($_GET["category"]) && $_GET["category"] == "") {
                                echo "全部";
                            } else if (isset($_GET["category"])) {
                                echo $_GET["category"];
                            } else {
                                echo "選擇分類";
                            }
                            ?>

                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php if (isset($_GET["q"])) {
                                $q = "q=" . $_GET["q"] . "&";
                            } ?>
                            <li><a class="btn_category_choose dropdown-item" href="articles.php?p=1&order=<?= $order ?>&<?= $q ?>category=">全部</a></li>

                            <?php foreach ($categories as $category): ?>
                                <li><a class="btn_category_choose dropdown-item" href="articles.php?p=1&order=<?= $order ?>&<?= $q ?>category=<?= $category["category"] ?>"><?= $category["category"] ?></a></li>
                            <?php endforeach; ?>

                        </ul>
                    </div>



                </div>

                <?php if ($userCount > 0): ?>
                    <table class="table table-bordered table-hover table ">
                        <thead class=" text-center">
                            <tr>
                                <th>狀態</th>
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
                                            echo '<span class="text-light">未發布</span>';
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
                                    <?php $category = (isset($_GET["category"])) ? "&category=" . $_GET["category"] : ""; ?>
                                    <?php $q = (isset($_GET["q"])) ? "&q=" . $_GET["q"] : ""; ?>
                                    <li class="page-item <?= $active ?>"><a class="page-link" href="articles.php?p=<?= $i ?>&order=<?= $order ?><?= $category ?><?= $q ?>"><?= $i ?></a></li>
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

</body>

</html>