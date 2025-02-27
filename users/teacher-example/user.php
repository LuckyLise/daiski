<?php
if (!isset($_GET["id"])) {
    header("location: user.php");
}


$id = $_GET["id"];

require_once("./db_connect.php");
$sql = "SELECT * FROM users WHERE id=$id AND valid=1";
$result = $conn->query($sql);
// $rows=$result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows[0]);
$row = $result->fetch_assoc();
$userCount = $result->num_rows;

// $sq1FavoriteProducts = "SELECT user_like.*, product.name AS product_name FROM user_like
// JOIN product ON user_like.product_id = product.id
// WHERE user_like.user_id = $id ";

// $resultFavoriteProducts = $conn->query($sqlFavoriteProducts);
// $favoriteProductCount = $resultFavoriteProducts->num_rows;
// $products = $resultFavoriteProducts->fetch_all(MYSQLI_ASSOC);

// var_dump($row);
?>
<!doctype html>
<html lang="zh-TW">

<head>
    <title>Users</title>
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
            <a class="btn btn-primary" href="users.php"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
        </div>
        <?php if ($userCount > 0): ?>
            <div class="row">
                <div class="col-lg-4 col-md-9">
                    <table class="table table-bordered">
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
                            <th>birthday</th>
                            <td><?= $row["birthday"] ?></td>
                        </tr>
                        <tr>
                            <th>email</th>
                            <td><?= $row["email"] ?></td>
                        </tr>
                    </table>
                    <div class="">
                        <a class="btn btn-primary" href="user-edit.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
                    </div>
                </div>
                <!-- <div class="col-lg-8 col-md-12 g-3">
                    <h2>收藏商品</h2>
                    <?php if ($favoriteProductCount > 0): ?>
                        <ul>
                            <?php foreach ($products as $product): ?>
                            <li>
                            <a href="product.php?id=<?=$product["product_id"]?>"><?= $product["product_name"] ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        尚未收藏商品
                    <?php endif; ?>
                </div> -->
            </div>
        <?php else: ?>
            <h2>使用者不存在</h2>
        <?php endif; ?>
    </div>
</body>

</html>