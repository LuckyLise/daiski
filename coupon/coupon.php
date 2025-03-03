<?php
if (!isset($_GET["id"])) {
    header("location: coupons.php");
}

$id = $_GET["id"];


require_once("../pdo_connect.php");


$sql = "SELECT coupon.*, coupon_type.amount AS coupon_amount,  coupon_type.type AS coupon_type, coupon_target.target AS coupon_target FROM coupon
JOIN coupon_type ON coupon.type_id = coupon_type.id
JOIN coupon_target ON coupon.coupon_target_id = coupon_target.id
WHERE coupon.id = $id 
";
$stmt = $db_host->prepare($sql);
$stmt->execute();
$coupon = $stmt->fetch(PDO::FETCH_ASSOC);

$db_host = NULL;

?>

<!doctype html>
<html lang="en">

<head>
    <title>coupon</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>
</head>

<body>
    <div class="d-flex flex-column">
        <?php include("./new_head_mod.php") ?>
        <div class="d-flex flex-row w-100 ">
            <?php include("./new_side_mod.php") ?>

            <div class="container myPage">
                <div class="py-2">
                    <a href="coupons.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
                </div>
                <div class="row g-3">
                    <div class="col-lg-4 col-md-9">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td><?= $coupon["id"] ?></td>
                            </tr>
                            <tr>
                                <th>優惠卷名稱</th>
                                <td><?= $coupon["name"] ?></td>
                            </tr>
                            <tr>
                                <th>代碼</th>
                                <td><?= $coupon["code"] ?></td>
                            </tr>
                            <tr>
                                <th>種類</th>
                                <td><?= $coupon["coupon_type"] ?></td>
                            </tr>
                            <tr>
                                <th>折扣數</th>
                                <td><?= $coupon["coupon_amount"] ?></td>
                            </tr>
                            <tr>
                                <th>折扣對象</th>
                                <td><?= $coupon["coupon_target"] ?></td>
                            </tr>
                            <tr>
                                <th>開始日期</th>
                                <td><?= $coupon["startAt"] ?></td>
                            </tr>
                            <tr>
                                <th>結束日期</th>
                                <td><?= $coupon["endAt"] ?></td>
                            </tr>
                            <tr>
                                <th>可領取次數</th>
                                <td><?= $coupon["usageLimit"] ?></td>
                            </tr>
                            <tr>
                                <th>最低消費額</th>
                                <td><?= $coupon["minPurchase"] ?></td>
                            </tr>
                            <tr>
                                <th>新增時間</th>
                                <td><?= $coupon["createdAt"] ?></td>
                            </tr>
                            <!-- <tr>
                            <th>優惠卷狀態</th>
                            <td></td>
                        </tr> -->
                        </table>
                        <a href="coupon-edit.php?id=<?= $coupon["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("./js.php"); ?>
</body>

</html>