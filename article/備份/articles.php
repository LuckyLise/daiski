<?
require_once("../pdo_connect.php");
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
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $sql = "SELECT * FROM article WHERE title LIKE '%$q%'";
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
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($rows);
    echo "預處理陳述式執行失敗！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

// 預設為所有筆數，若有q再改變
if (isset($_GET["q"])) {
    $userCount = $stmt->rowCount();
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

    <? include("../css.php") ?>
    <style>
        .article_content {

            /* 超出的隱藏 */
            overflow: auto;
            /* 固定邊框大小 */
            display: block;

            max-width: 30vw;
            max-height: 10vh;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="py-2">
            <!-- fa-fw 固定icon寬度 -->
            <a class="btn btn-primary" href="create-article.php"><i class="fa-solid fa-user-plus fa-fw"></i>新增文章</a>
        </div>

        <div class="py-2 row g-3 align-items-center">

            <div class="col-md-6">
                <div class="hstack gap-2 align-items-center">
                    <? if (isset($_GET["q"])): ?>
                        <a class="btn btn-primary" href="articles.php"><i class="fa-solid fa-arrow-left fa-fw"></i>回文章列表</a>

                    <? endif; ?>
                    <div> 共 <?= $userCount ?> 篇文章</div>
                </div>

            </div>
            <div class="col-md-6">
                <form action="" method="get">
                    <!-- php可以寫在div內 -->
                    <div class="input-group">
                        <!-- value 按下按鈕後欄位要顯示什麼，name代表網址後面加上q=表單內容 -->
                        <input type="search" class="form-control" name="q"
                            <?
                            $q = $_GET["q"] ?? "";

                            ?>

                            value="<?= $q ?>">

                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa-fw"></i>搜尋</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="py-2 text-end">
            <div class="btn-group">
                <!-- 根據網址的order排序決定給哪個按鈕"active" -->
                <a class="btn btn-primary <? if ($order == 1) echo "active" ?>" href="articles.php?p=<?= $p ?>&order=1">ID升冪<i class="fa-solid fa-arrow-down-1-9 fa-fw"></i></a>
                <a class="btn btn-primary <? if ($order == 2) echo "active" ?>" href="articles.php?p=<?= $p ?>&order=2">ID降冪<i class="fa-solid fa-arrow-down-9-1" fa-fw></i></a>
                <a class="btn btn-primary <? if ($order == 3) echo "active" ?>" href="articles.php?p=<?= $p ?>&order=3">發布升冪<i class="fa-solid fa-arrow-down-a-z" fa-fw></i></a>
                <a class="btn btn-primary <? if ($order == 4) echo "active" ?>" href="articles.php?p=<?= $p ?>&order=4">發布降冪<i class="fa-solid fa-arrow-down-z-a" fa-fw></i></a>
            </div>
        </div>

        <? if ($userCount > 0): ?>
            <table class="table table-bordered table-hover table ">
                <thead class="table-light text-center">
                    <tr>
                        <th>ID</th>
                        <th>類別</th>
                        <th>標題</th>
                        <th>內容</th>
                        <th>發布日期</th>
                        <th>結束日期</th>
                        <th>編輯/刪除</th>
                    </tr>
                </thead>

                <tbody>
                    <? foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $row["id"]; ?></td>
                            <? $category = ($row["category"]) ?  $row["category"] : "未分類" ?>
                            <td><?= $category ?></td>

                            <td><?= $row["title"]; ?></td>
                            <td class="article_content"><?= $row["content"]; ?></td>
                            <td><?= $row["startDate"]; ?></td>

                            <td><?
                                if ($row["endDate"] == "") {
                                    echo $row["endDate"];
                                } else {
                                    echo $row["endDate"];
                                }
                                ?></td>

                            <td class=" text-center">
                                <a class="btn btn-primary" href="article.php?id=<?= $row['id']; ?>"><i class="fa-regular fa-eye fa-fw"></i>查看</a>

                                <a class=" btn btn-primary" href="article-edit.php"><i class="fa-regular fa-pen-to-square fa-fw"></i>編輯</a>

                            </td>
                        </tr>
                    <? endforeach; ?>
                </tbody>
            </table>
            <? if (isset($_GET["p"])): ?>
                <!-- bs套件 pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <!--  加上active讓當前分頁有顏色 -->
                        <? for ($i = 1; $i <= $totalPage; $i++): ?>

                            <? $active = ($i == $_GET["p"]) ? "active" : ""; ?>

                            <li class="page-item <?= $active ?>"><a class="page-link" href="articles.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                        <? endfor; ?>


                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>




                    </ul>
                </nav>
            <? endif; ?>
        <? endif; ?>
    </div>


    <? include("../js.php") ?>
    </script>
</body>

</html>