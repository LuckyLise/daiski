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
$stmt = $host_db->prepare($sql);
$stmt->execute();
$coupon = $stmt->fetch(PDO::FETCH_ASSOC);

$host_db = NULL;

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

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <div class="py-2">
            <a href="coupons.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
        </div>
        <div class="row g-3">
            <div class="col-lg-4 col-md-9">
                <form action="doUpdataCoupon.php" method="POST">
                    <input type="hidden" name="id" value="<?= $coupon["id"] ?>">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td><?= $coupon["id"] ?></td>
                        </tr>
                        <tr>
                            <th>優惠卷名稱</th>
                            <td>
                                <input type="text" class="form-control" name="name" value="<?= $coupon["name"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>代碼</th>
                            <td>
                                <?= $coupon["code"] ?>
                            </td>
                        </tr>
                        <tr>
                            <th>種類</th>
                            <td>
                                <select class="form-select" id="coupon_type" name="coupon_type">
                                    <option value="現金" <?php if ($coupon["coupon_type"] == "現金") echo "selected"; ?>>現金折扣</option>
                                    <option value="百分比折扣" <?php if ($coupon["coupon_type"] == "百分比折扣") echo "selected"; ?>>百分比折扣</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>折扣數</th>
                            <td>
                                <input type="text" class="form-control" name="coupon_amount" id="coupon_amount" value="<?= $coupon["coupon_amount"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>折扣對象</th>
                            <td>
                                <select class="form-select" id="coupon_target" name="coupon_target">
                                    <option value="課程" <?php if ($coupon["coupon_target"] == "課程") echo "selected"; ?>>課程</option>
                                    <option value="商品" <?php if ($coupon["coupon_target"] == "商品") echo "selected"; ?>>商品</option>
                                    <option value="全站" <?php if ($coupon["coupon_target"] == "全站") echo "selected"; ?>>全站</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>開始日期</th>
                            <td>
                                <input type="text" class="form-control" name="startAt" value="<?= $coupon["startAt"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>結束日期</th>
                            <td>
                                <input type="text" class="form-control" name="endAt" value="<?= $coupon["endAt"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>可領取次數</th>
                            <td>
                                <input type="text" class="form-control" name="usageLimit" value="<?= $coupon["usageLimit"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>最低消費額</th>
                            <td>
                                <input type="text" class="form-control" name="minPurchase" value="<?= $coupon["minPurchase"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>新增時間</th>
                            <td>
                                <?= $coupon["createdAt"] ?>
                            </td>
                        </tr>
                        <!-- <tr>
                            <th>優惠卷狀態</th>
                            <td></td>
                        </tr> -->
                    </table>
                    <button class="btn btn-primary" type="submit">送出</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("../js.php"); ?>
</body>

</html>