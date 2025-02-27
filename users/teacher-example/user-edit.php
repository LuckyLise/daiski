<?php

if (!isset($_GET["id"])) {
    header("location: users.php");
}

$id = $_GET["id"];

require_once('../daiski/pdo_connect.php');

$sql = "SELECT * FROM users WHERE id = $id AND valid=1";
$stmt=$db_host->prepare($sql);

try {
	$stmt->execute();
	// while ($row = $stmt->fetch()) {
    // 	echo "接收到的資料：<pre>";
    // 	print_r($row);
    // 	echo "</pre>";
	// }

    $userCount = $stmt->rowCount();
    echo "<pre>";
    // print_r($rows);
    echo "</pre>";

} catch (PDOException $e) {
	echo "預處理陳述式執行失敗！ <br/>";
	echo "Error: " . $e->getMessage() . "<br/>";
	$db_host = NULL;
	exit;
}

$db_host = NULL;

?>
<!doctype html>
<html lang="zh-TW">

<head>
    <title>User-edit</title>
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
            <a class="btn btn-primary" href="user.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-9">
                <?php if ($userCount > 0): ?>
                    <form action="doUpdateUser.php" method="post">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <table class="table table-bordered">
                            <tr>
                                <th>id</th>
                                <td>
                                    <?= $row["id"] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>name</th>
                                <td>
                                    <input type="text" class="form-control" name="name"
                                        value="<?= $row["name"] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>phone</th>
                                <td>
                                    <input type="tel" class="form-control" name="phone"
                                        value="<?= $row["phone"] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>email</th>
                                <td>
                                    <input type="email" class="form-control" name="email"
                                        value="<?= $row["email"] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>createdtime</th>
                                <td><?= $row["createdtime"] ?></td>
                            </tr>
                        </table>
                        <button class="btn btn-primary" type="submit">儲存</button>
                        <a class="btn btn-danger" href="user-delete.php?id=<?=$row["id"]?>">刪除</a>
                    </form>
                <?php else: ?>
                    <h2>使用者不存在</h2>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <?php include("../js.php")?>
    <script>

    </script>
</body>

</html>