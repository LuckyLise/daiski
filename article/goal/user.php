<?

// 系統注重防呆，要給使用者好的體驗
if (!isset($_GET["id"])) {
    header("location: users.php");
}


// GET是抓網址，需在網址後面加上 "?id=1"
$id = $_GET["id"];


require_once("../db_connect.php");
$sql = "SELECT * FROM users WHERE id = $id AND valid=1";
$result = $conn->query($sql);
// $rows=$result->fetch_all(MYSQLI_ASSOC);

// fetch_assoc() 只查詢單筆資料時使用，可以避免全查詢的資安問題
$row = $result->fetch_assoc();
// var_dump($row);

$userCount = $result->num_rows;

$sqlFavoriteProducts = "SELECT user_like.*, product.name AS product_name 
FROM user_like
JOIN product ON user_like.product_id = product.id
WHERE user_like.user_id=$id
";
$resultFavoriteProducts = $conn->query($sqlFavoriteProducts);
$favoriteProductCount = $resultFavoriteProducts->num_rows;

$products = $resultFavoriteProducts->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <? include("../css.php") ?>
</head>

<body>
    <div class="container">
        <div class="py-2 ">
            <a class="btn btn-primary" href="users.php"><i class="fa-solid fa-list fa-fw"></i>使用者列表</a>
        </div>
        <div class="row g-3">
            <div class="clo-lg-4 col-md-9">
                <? if ($userCount > 0): ?>
                    <table class="table table-bordered">
                        <!-- (tr>th+td)*5 -->
                        <tr>
                            <th>id</th>
                            <td><?= $row["id"] ?></td>
                        </tr>
                        <tr>
                            <th>name</th>
                            <td><?= $row["name"] ?></td>
                        </tr>
                        <tr>
                            <th>phone</th>
                            <td><?= $row["phone"] ?></td>
                        </tr>
                        <tr>
                            <th>email</th>
                            <td><?= $row["email"] ?></td>
                        </tr>
                        <tr>
                            <th>created at</th>
                            <td><?= $row["creat_at"] ?></td>
                        </tr>

                    </table>
                    <div class="">
                        <a class=" btn btn-primary" href="user-edit.php?id=<?= $row["id"] ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                    </div>

            </div>

            <div class="col-lg-8 col-md-12">
                <h2>收藏商品</h2>
                <? if ($favoriteProductCount > 0): ?>
                    <? foreach ($products as $product): ?>
                        <li>
                            <a href="/product/product.php?id=<?= $product["product_id"] ?>">
                                <?= $product["product_name"] ?>
                            </a>
                        </li>
                    <? endforeach; ?>
                <? else: ?>
                    尚未收藏商品
                <? endif; ?>
            </div>
        </div>
    <? else: ?>
        <h2>使用者不存在</h2>
    <? endif; ?>
    </div>

</body>

</html>