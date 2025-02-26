<?php
if (!isset($_GET["id"])) {
    header("location: users.php");
}

$id = $_GET["id"];

require_once('../daiski/pdo_connect.php');

$sql = "SELECT * FROM users WHERE id = $id";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $row = $stmt->fetch();
    // echo "<pre>";
    // print_r($row);
    // echo "</pre>";

} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}
?>
<!doctype html>
<html lang="zh-TW">

<head>
    <title>User</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../daiski/css.php") ?>
</head>

<body>
    <div class="container">
        <div class="py-2">
            <a class="btn btn-primary" href="pdo-user.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-9">
                <?php if (isset($_GET["id"])): ?>
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
                                <th>account</th>
                                <td>
                                    <input type="account" class="form-control" name="account"
                                        value="<?= $row["account"] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>password</th>
                                <td>
                                    <input type="password" class="form-control" name="password"
                                        value="<?= $row["password"] ?>">
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
                                <th>birthday</th>
                                <td>
                                    <input type="datetime" class="form-control" name="birthday"
                                        value="<?= $row["birthday"] ?>">
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
                            <tr>
                                <th>isCoach</th>
                                <td>
                                    <?php if ($row["isCoach"] == 0): ?>
                                        <input type="radio" name="isCoach" id="" value="1">是
                                        <input type="radio" name="isCoach" id="" value="0" checked>否
                                    <?php else: ?>
                                        <input type="radio" name="isCoach" id="" value="1" checked>是
                                        <input type="radio" name="isCoach" id="" value="0">否
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk">儲存</i></button>
                            <a class="btn btn-danger" href="userDelete.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-trash-can">刪除</i></a>
                        </div>
                    </form>
                <?php else: ?>
                    <h2>使用者不存在</h2>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <?php include("../js.php") ?>
    <script>

    </script>
</body>

</html>