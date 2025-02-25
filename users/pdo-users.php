<?php
require_once('../daiski/pdo_connect.php');

$sqlALL = "SELECT * FROM users WHERE valid=1";
$stmtALL = $db_host->prepare($sqlALL);
$stmtALL->execute();
$userCount = $stmtALL->rowCount();


if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $sql = "SELECT * FROM users WHERE name LIKE '%$q%'";
} else if (isset($_GET["p"])) {
    $p = $_GET["p"];
    $perPage = 25;
    $startItem = ($p - 1) * $perPage;
    $totalPage = ceil($userCount / $perPage);
    $sql = "SELECT * FROM users WHERE valid=1 LIMIT $startItem,$perPage";
} else {
    header("location:pdo-users.php?p=1");
    // $sql = "SELECT * FROM users WHERE valid=1";
}



$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_GET["q"])) {
        $userCount = $stmt->rowCount();
    }
    // echo "<pre>"; 會將結果展開，自動換行
    // print_r($rows);會將結果用陣列的方式顯現出來
    // echo "</pre>";
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
        <div class="py-2 row g-3 align-items-center">
            <div class="col-md-6">
                <div class="hstack gap-2 align-items-center">
                <?php if(isset($_GET["q"])):?>    
                <a href="pdo-users.php" class="btn btn-primary"><i class="fa-solid fa-left-long fa-fw"></i></a>
                <?php endif;?>
                    <div>共 <?= $userCount ?> 位使用者
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <form action="" method="get">
                    <div class="input-group">
                        <input type="search" class="form-control" name="q"
                            <?php
                            // $q=""; if (isset($_GET["q"])) {
                            // $q = $_GET["q"];
                            // }
                            // $q=(isset($_GET["q"]))?
                            // $_GET["q"] : "";
                            $q = $_GET["q"] ?? "";
                            ?>
                            value="<?= $q ?>">
                        <button class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass fa-fw" type="submit"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php if ($userCount > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
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
                            <td><?= $row["id"] ?></td>
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
            <?php if (isset($_GET["p"])): ?>
                <div>
                    <nav aria-label="">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                                <?php 
                                    $active=($i==$_GET["p"])?
                                    "active":"";
                                    ?>
                                <li class="page-item <?=$active?>"><a class="page-link" href="pdo-users.php?p=<?= $i ?>"><?= $i ?></a></li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php include("../daiski/js.php") ?>

    <script>
        let users = <?= json_encode($rows) ?>;
        console.log(users);
    </script>
</body>

</html>