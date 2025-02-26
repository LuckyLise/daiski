<?php
require_once("../pdo_connect.php");

$sqlAll = "SELECT COUNT(*) FROM coupon ";
$stmtAll = $host_db->prepare($sqlAll);
$stmtAll->execute();
$couponCount = $stmtAll->fetchColumn();


$q = isset($_GET["q"]) ? $_GET["q"] : "";
$sql = "SELECT coupon.*, coupon_type.amount AS coupon_amount,  coupon_type.type AS coupon_type, coupon_target.target AS coupon_target FROM coupon
LEFT JOIN coupon_type ON coupon.type_id = coupon_type.id
LEFT JOIN coupon_target ON coupon.coupon_target_id = coupon_target.id
-- WHERE :q IS NULL OR coupon.name LIKE :q
";
// $stmt = $host_db->prepare($sql);
// $stmt->execute(['q' => $q ? "%$q%" : null]);
// $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows);

$stmt = $host_db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$host_db = NULL;

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

    <?php include("../css.php") ?>

</head>

<body>
    <div class="container">
        <!-- 標題 -->
        <div class="text-center py-3">
            <h1>優惠卷清單</h1>
        </div>

        <!-- 使用者總數 收尋 -->
        <div class="py-2 row g-3 align-items-center">
            <div class="col-md-6">
                <div class="gap-2 align-items-center">
                    <!-- <a href="coupons.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left fa-fw"></i></a> -->
                    <div>共<?= $couponCount ?>位使用者</div>
                </div>
            </div>
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="search" class="form-control" name="q" <?php $q = $_GET["q"] ?? ""; ?> value="<?= $q ?>">
                        <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa-fw" type="submit"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 新增使用者 -->
        <div class="py-2 text-end  ">
            <a href="create-coupon.php" class="btn btn-primary">新增優惠卷</a>
        </div>

        <!-- 表格 -->
        <table class="table table-bordered py-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>優惠卷名稱</th>
                    <th>代碼</th>
                    <th>種類</th>
                    <th>折扣數</th>
                    <th>折扣對象</th>
                    <th>開始日期</th>
                    <th>結束日期</th>
                    <th>可領取次數</th>
                    <th>最低消費額</th>
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
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <?php include("../js.php"); ?>
</body>

</html>