<?php
require_once("../db_connect.php");

$sqlAll = "SELECT * FROM users WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$userCount = $resultAll->num_rows;

if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $sql = "SELECT * FROM users WHERE name LIKE '%$q%'";
} else if (isset($_GET["p"])) {
    $p = $_GET["p"];
    $perPage = 4;
    $startItem = ($p - 1) * $perPage;
    $totalPage = ceil($userCount / $perPage);
    // echo "total page: $totalPage";
    $sql = "SELECT * FROM users WHERE valid=1
    LIMIT $startItem, $perPage";
} else {
    header("location: users.php?p=1");
    // $sql = "SELECT * FROM users WHERE
    // valid=1";
}
$result= $conn->query($sqlAll);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$userCount = $result->num_rows;

// var_dump($rows);
?>
<!doctype html>
<html lang="en">

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
                        <th>phone</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $row["name"] ?></td>
                            <td><?= $row["phone"] ?></td>
                            <td><?= $row["email"] ?></td>
                            <td>
                                <a class="btn btn-primary" href="user.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-eye fa-fw"></i></a>
                                <a class="btn btn-primary" href="user-edit.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php include("../js.php") ?>

    <script>
        let users = <?= json_encode($rows) ?>;
        console.log(users);
    </script>
</body>

</html>