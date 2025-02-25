<?php
require_once('../daiski/pdo_connect.php');

$sql = "SELECT * FROM users WHERE valid=1";
$stmtALL=$db_host->prepare($sql);
$stmtALL->execute();
$userCount = $stmtALL->rowCount();


if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $sql = "SELECT * FROM users WHERE name LIKE'%$q%'";
} else if (isset($_GET["p"])) {
    $p = $_GET["p"];
    $perPage = 25;
    $startItem = ($p - 1) * $perPage;
    $totalPage=ceil($userCount/$perPage);
    $sql = "SELECT * FROM users WHERE valid=1 LIMIT $startItem,$perPage";
} else {
    header("location:pdo-users.php?p=1");
    // $sql = "SELECT * FROM users WHERE valid=1";
}




$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    // while ($row = $stmt->fetch()) {
    // 	echo "接收到的資料：<pre>";
    // 	print_r($row);
    // 	echo "</pre>";
    // }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $userCount = $stmt->rowCount();

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
<html lang="en">

<head>
    <title>pdo-users</title>
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
            <a class="btn btn-primary" href="create-user.php"><i class="fa-solid fa-user-plus fa-fw"></i> Add User</a>
        </div>
        <div class="py-2">
            共 <?= $userCount ?> 位使用者
        </div>
        <?php if ($userCount > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>account</th>
                        <th>phone</th>
                        <th>birthday</th>
                        <th>email</th>
                        <th>createdtime</th>
                        <th>isCoach</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $row["name"] ?></td>
                            <td><?= $row["account"] ?></td>
                            <td><?= $row["phone"] ?></td>
                            <td><?= $row["birthday"] ?></td>
                            <td><?= $row["email"] ?></td>
                            <td><?= $row["createdtime"] ?></td>
                            <td><?= $row["isCoach"] ?></td>
                            <td>
                                <a class="btn btn-primary" href="user.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-eye fa-fw"></i></a>
                                <a class="btn btn-primary" href="user-edit.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if(isset($_GET["p"])): ?>
            <div>
                <nav aria-label="">
                    <ul class="pagination">
                        <?php for($i=1;$i<=$totalPage;$i++):?>
                        <li class="page-item"><a class="page-link" href="pdo-users.php?p=<?=$i?>"><?=$i?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
            <?php endif;?>
        <?php endif; ?>
    </div>
    <?php include("../daiski/js.php") ?>

    <script>
        let users = <?= json_encode($rows) ?>;
        console.log(users);
    </script>
</body>

</html>