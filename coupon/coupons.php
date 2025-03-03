<?php
require_once("../pdo_connect.php");

// 總數
$sqlAll = "SELECT COUNT(*) FROM coupon ";
$stmtAll = $db_host->prepare($sqlAll);
$stmtAll->execute();
$couponCount = $stmtAll->fetchColumn();

// 類型分類
$sqlTarget = "SELECT * FROM coupon_target ";
$stmtTarget = $db_host->prepare($sqlTarget);
$stmtTarget->execute();
$targets = $stmtTarget->fetchAll(PDO::FETCH_ASSOC);

// 金錢分類
$sqlType = "SELECT DISTINCT `type` FROM coupon_type ";
$stmtType = $db_host->prepare($sqlType);
$stmtType->execute();
$types = $stmtType->fetchAll(PDO::FETCH_ASSOC);

$q          = $_GET["q"] ?? '';
$startAt    = $_GET["startAt"] ?? '';
$endAt      = $_GET["endAt"] ?? '';
$coupon_type = $_GET["coupon_type"] ?? '';
$coupon_target = $_GET["coupon_target"] ?? '';
$p          = isset($_GET["p"]) ? (int)$_GET["p"] : 1;
$order      = isset($_GET["order"]) ? (int)$_GET["order"] : 1;




$sql = "SELECT coupon.*, coupon_type.amount AS coupon_amount,  coupon_type.type AS coupon_type, coupon_target.target AS coupon_target FROM coupon
LEFT JOIN coupon_type ON coupon.type_id = coupon_type.id
LEFT JOIN coupon_target ON coupon.coupon_target_id = coupon_target.id";

$where = [];
$params = [];

// 收尋
if (isset($_GET["q"])) {
    $q = $_GET["q"];

    if ($q !== "") {
        $where[] = "coupon.name LIKE :like_q";
        $params[":like_q"] = "%$q%";
    }
}

// 開始時間 結束時間篩選
if (!empty($_GET["startAt"])) {
    $startAt = $_GET["startAt"] ?? '';
    $where[] = "coupon.startAt >= :startAt";
    $params[":startAt"] = $startAt;
}
if (!empty($_GET["endAt"])) {
    $endAt = $_GET["endAt"] ?? '';
    $where[] = "coupon.endAt <= :endAt";
    $params[":endAt"] = $endAt;
}

// 分類
if (!empty($_GET["coupon_type"])) {
    $coupon_type = $_GET["coupon_type"];
    $where[] = "coupon_type.type = :coupon_type";
    $params[":coupon_type"] = $coupon_type;
}
if (!empty($_GET["coupon_target"])) {
    $coupon_target = $_GET["coupon_target"];
    $where[] = "coupon_target.target = :coupon_target";
    $params[":coupon_target"] = $coupon_target;
}

// 把上面加起來
if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}


// 分頁 排序
$orderClause = "";
$perPage = 6;
$startItem = 0;


switch ($order) {
    case 1:
        $orderClause = " ORDER BY id ASC";
        break;
    case 2:
        $orderClause = " ORDER BY id DESC";
        break;
    case 3:
        $orderClause = " ORDER BY startAt ASC";
        break;
    case 4:
        $orderClause = " ORDER BY startAt DESC";
        break;
    case 5:
        $orderClause = " ORDER BY endAt ASC";
        break;
    case 6:
        $orderClause = " ORDER BY endAt DESC";
        break;
    case 7:
        $orderClause = " ORDER BY usageLimit ASC";
        break;
    case 8:
        $orderClause = " ORDER BY usageLimit DESC";
        break;
    case 9:
        $orderClause = " ORDER BY minPurchase ASC";
        break;
    case 10:
        $orderClause = " ORDER BY minPurchase DESC";
        break;
}

$startItem = ($p - 1) * $perPage;
$totalPage = ceil($couponCount / $perPage);

// 篩選後的總數
$sqlCount = "SELECT COUNT(*) FROM coupon
LEFT JOIN coupon_type ON coupon.type_id = coupon_type.id
LEFT JOIN coupon_target ON coupon.coupon_target_id = coupon_target.id";
if (count($where) > 0) {
    $sqlCount .= " WHERE " . implode(" AND ", $where);
}
$stmtCount = $db_host->prepare($sqlCount);
$stmtCount->execute($params);
$couponCount = $stmtCount->fetchColumn();
$totalPage = ceil($couponCount / $perPage);

$sql .= $orderClause;
$sql .= " LIMIT $startItem, $perPage";
// echo $sql;

$queryParams = [];
if ($q !== '') {
    $queryParams['q'] = $q;
}
if ($startAt !== '') {
    $queryParams['startAt'] = $startAt;
}
if ($endAt !== '') {
    $queryParams['endAt'] = $endAt;
}
if ($coupon_type !== '') {
    $queryParams['coupon_type'] = $coupon_type;
}
if ($coupon_target !== '') {
    $queryParams['coupon_target'] = $coupon_target;
}
// order 參數也要保留，因為分頁連結中已有 order
$queryParams['order'] = $order;

$stmt = $db_host->prepare($sql);
$stmt->execute($params);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$db_host = NULL;

?>

<!doctype html>
<html lang="en">

<head>

    <title>coupons</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>

</head>

<body>
    <!-- Loading 畫面 -->
    <div id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <!-- 彈跳視窗 -->
    <div class="modal fade" tabindex="-1" id="infoModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">刪除優惠卷</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>確認刪除優惠卷?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deleteButton" href="#">確認</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column myPage" id="mainContent">
        <?php include("./new_head_mod.php"); ?>

        <div class="d-flex flex-row w-100 ">
            <?php include("./new_side_mod.php"); ?>

            <div class="container myPage">
                <!-- 標題 -->
                <div class="text-center py-3">
                    <h1>優惠卷清單</h1>
                </div>

                <!-- 使用者總數-->

                <div class="py-2">
                    <div>共<?= $couponCount ?>組優惠卷</div>
                </div>

                <!-- 分類 收尋 -->
                <div class="py-2 row g-3 align-items-center">
                    <div class="col-md-8">
                        <div class="gap-2 align-items-center">
                            <ul class="nav nav-underline">
                                <li class="nav-item">
                                    <?php
                                    $ifActive = "";
                                    if (!isset($_GET["coupon_target"]) && !isset($_GET["coupon_type"])) {
                                        $ifActive = "active";
                                    }
                                    ?>
                                    <a href="coupons.php" class="btn btn-primary <?= $ifActive ?>">全部</a>
                                </li>
                                <?php foreach ($targets as $target) : ?>
                                    <li class="nav-item">
                                        <?php
                                        $ifActive = "";
                                        if (isset($_GET["coupon_target"]) && $_GET["coupon_target"] == $target["target"]) {
                                            $ifActive = "active";
                                        }
                                        ?>
                                        <a href="coupons.php?p=1&order=1&coupon_target=<?= $target["target"] ?>" class="btn btn-primary <?= $ifActive ?>"><?= $target["target"] ?></a>
                                    </li>
                                <?php endforeach; ?>
                                <?php foreach ($types as $type) : ?>
                                    <li class="nav-item">
                                        <?php
                                        $ifActive = "";
                                        if (isset($_GET["coupon_type"]) && $_GET["coupon_type"] == $type["type"]) {
                                            $ifActive = "active";
                                        }
                                        ?>
                                        <a href="coupons.php?p=1&order=1&coupon_type=<?= $type["type"] ?>" class="btn btn-primary <?= $ifActive ?>"><?= $type["type"] ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <form action="" method="get">
                            <!-- 收尋完的返回 -->
                            <div>
                                <?php if (isset($_GET["q"])): ?>
                                    <a href="coupons.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
                                <?php endif; ?>
                            </div>
                            <div class="input-group">
                                <input type="search" class="form-control" name="q" <?php $q = $_GET["q"] ?? ""; ?> value="<?= $q ?>">
                                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass fa-fw"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 時間篩選 -->
                <div class="py-2">
                    <form action="">

                        <div class="row g-3 align-items-center">
                            <!-- 篩選完的返回 -->
                            <?php if (!empty($_GET["startAt"]) || (!empty($_GET["endAt"]))): ?>
                                <div class="col-auto">
                                    <a href="coupons.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
                                </div>
                            <?php endif; ?>

                            <input type="hidden" name="order" value="1">
                            <input type="hidden" name="p" value="1">


                            <div class="col-auto">
                                <?php $startAt = $_GET["startAt"] ?? ""; ?>
                                <input type="date" class="form-control" name="startAt" value="<?= $startAt ?>" min="<?= date('Y-m-d') ?>" id="startAt">

                            </div>

                            <div class="col-auto">
                                ~
                            </div>

                            <div class="col-auto">
                                <?php $endAt = $_GET["endAt"] ?? ""; ?>
                                <input type="date" class="form-control" name="endAt" value="<?= $endAt ?>" id="endAt">

                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass fa-fw"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- 新增使用者 -->
                <div class="py-2 text-end  ">
                    <a href="create-coupon.php" class="btn btn-primary">新增優惠卷</a>
                </div>

                <!-- 表格 -->
                <table class="table table-bordered py-2">
                    <thead>
                        <tr>
                            <th>ID <a href="#" class="sort-icon <?= (isset($_GET['order']) && ($_GET['order'] == 1 || $_GET['order'] == 2)) ? 'activeI' : '' ?>" data-field="id"><i class="fa-solid fa-sort"></i></a></th>
                            <th>優惠卷名稱</th>
                            <th>代碼</th>
                            <th>種類</th>
                            <th>折扣數</th>
                            <th>折扣對象</th>
                            <th>開始日期 <a href="#" class="sort-icon" data-field="startAt"><i class="fa-solid fa-sort <?= (isset($_GET['order']) && ($_GET['order'] == 3 || $_GET['order'] == 4)) ? 'activeI' : '' ?>"></i></a></th>
                            <th>結束日期 <a href="#" class="sort-icon" data-field="endAt"><i class="fa-solid fa-sort <?= (isset($_GET['order']) && ($_GET['order'] == 5 || $_GET['order'] == 6)) ? 'activeI' : '' ?>"></i></a></th>
                            <th>可領取次數 <a href="#" class="sort-icon" data-field="usageLimit"><i class="fa-solid fa-sort <?= (isset($_GET['order']) && ($_GET['order'] == 7 || $_GET['order'] == 8)) ? 'activeI' : '' ?>"></i></a></th>
                            <th>最低消費額 <a href="#" class="sort-icon" data-field="minPurchase"><i class="fa-solid fa-sort <?= (isset($_GET['order']) && ($_GET['order'] == 9 || $_GET['order'] == 10)) ? 'activeI' : '' ?>"></i></a></th>
                            <th>新增時間</th>
                            <!-- <th>優惠卷狀態</th> -->
                            <th>詳細資訊</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><?= $row["name"] ?></td>
                                <td><?= $row["code"] ?></td>
                                <td><?= $row["coupon_type"] ?></td>
                                <td><?= $row["coupon_amount"] ?></td>
                                <td><?= $row["coupon_target"] ?></td>
                                <td><?= $row["startAt"] ?></td>
                                <td><?= $row["endAt"] ?></td>
                                <td><?= $row["usageLimit"] ?></td>
                                <td><?= $row["minPurchase"] ?></td>
                                <td><?= $row["createdAt"] ?></td>
                                <!-- <td></td> -->
                                <td>
                                    <a href="coupon.php?id=<?= $row["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-eye fa-fw"></i></a>

                                    <a href="coupon-edit.php?id=<?= $row["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
                                    <a role="button" class="btn btn-danger deleteButton" data-bs-toggle="modal" data-bs-target="#infoModal" data-id="<?= $row["id"] ?>"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- 分頁 -->
                <?php if ($totalPage > 1) : ?>
                    <div>
                        <nav aria-label=" ">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++) :
                                    $queryParams['p'] = $i;
                                    $queryString = http_build_query($queryParams); ?>
                                    <?php
                                    $active = ($i == $p) ?
                                        "active" : "";
                                    ?>
                                    <li class="page-item <?= $active ?> "><a class="page-link" href="coupons.php?<?= $queryString ?>"><?= $i ?></a></li>
                                <?php endfor; ?>

                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <?php include("./js.php"); ?>
    <script>
        // 刪除
        const deleteButtons = document.querySelectorAll(".deleteButton")

        let deleteId = null;

        deleteButtons.forEach(button => {
            button.addEventListener("click", function() {
                deleteId = this.getAttribute("data-id");
                console.log("選擇刪除的 ID:", deleteId);
            });
        });

        $("#deleteButton").click(function() {
            if (deleteId) {
                $.ajax({
                    url: "delete_coupon.php",
                    type: "GET",
                    data: {
                        id: deleteId
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status === "success") {
                            // alert("優惠券已刪除！");
                            $("td[data-id='" + deleteId + "']").remove();
                            // header("Location: coupons.php");
                            window.location.replace("coupons.php");
                        } else {
                            alert("刪除失敗：" + data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("刪除失敗：", error);
                    }
                });
            }
        });

        //排序
        const sortIcons = document.querySelectorAll(".sort-icon");
        const sortMapping = {
            id: {
                asc: "1",
                desc: "2"
            },
            startAt: {
                asc: "3",
                desc: "4"
            },
            endAt: {
                asc: "5",
                desc: "6"
            },
            usageLimit: {
                asc: "7",
                desc: "8"
            },
            minPurchase: {
                asc: "9",
                desc: "10"
            },
        };
        sortIcons.forEach(a => {
            a.addEventListener("click", function(e) {
                const field = this.dataset.field;
                const urlParams = new URLSearchParams(window.location.search);
                let currentOrder = urlParams.get("order");
                let nextOrder;
                if (currentOrder === sortMapping[field].asc) {
                    nextOrder = sortMapping[field].desc;
                } else {
                    nextOrder = sortMapping[field].asc;
                }
                urlParams.set("order", nextOrder);
                window.location.href = window.location.pathname + "?" + urlParams.toString();

            })
        })

        // 時間限制
        const startAtInput = document.getElementById('startAt');
        startAtInput.addEventListener('change', function(){
            let selectedAt = this.value;
            let endAtInput = document.getElementById('endAt');
            endAtInput.setAttribute('min', selectedAt);
        })
    </script>
</body>

</html>