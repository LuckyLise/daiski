<?php
require_once("../pdo_connect.php");
$sqlAll = "SELECT * FROM coach";
try {
    $stmt = $db_host->prepare($sqlAll);
    $stmt->execute();
} catch (PDOException $e) {
    echo "" . $e->getMessage();
}
$userCount = $stmt->rowCount();
$sql = "SELECT coach.* 
        FROM coach";
// 搜尋
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $sql = "SELECT * FROM coach WHERE name LIKE '%$q%'";
} else if (isset($_GET["p"]) && isset($_GET["order"])) {
    $p = $_GET["p"];
    $perPage = 5;
    $startItem = ($p - 1) * $perPage;
    $totalPage = ceil($userCount / $perPage);
    $order = $_GET["order"];

    $orderClause = "";
    switch ($order) {
        case 1:
            $orderClause = "ORDER BY id ASC";
            break;
        case 2:
            $orderClause = "ORDER BY id DESC";
            break;
        case 3:
            $orderClause = "ORDER BY name ASC";
            break;
        case 4:
            $orderClause = "ORDER BY name DESC";
            break;
    }
    $sql = "SELECT * FROM coach 
        $orderClause
        LIMIT $startItem, $perPage";
} else {
    header("location: coaches.php?p=1&order=1");
}
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}
// 共幾人
$userCount = $stmt->rowCount();
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute();
    $language = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>coaches</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />


    <?php include("./css.php") ?>
    <style>
        .content {
            /* /* overflow: auto; */
            /* height: 15vh; */
            /* max-width: 20vw; */
            /* display: block;  */
        }
    </style>
</head>

<body>

    <div class="d-flex flex-column">
        <?php include("./new_head_mod.php") ?>
        <div class="d-flex flex-row w-100 ">
            <?php include("./new_side_mod.php") ?>

            <div class="container myPage">
                <div class="py-2">
                    <a href="create-coach.php" class="btn btn-primary"><i class="fa-solid fa-user-plus fa-fw"></i> Add Coach</a>
                </div>
                <div class="py-2 row g-3 align-items-center">
                    <div class="col-md-6">
                        <div class="hstack gap-2 align-items-center">
                            <?php if (isset($_GET["q"])) : ?>
                                <a href="coaches.php" class="btn btn-primary">
                                    <i class="fa-solid fa-arrow-left fa-fw"></i>
                                </a>
                            <?php endif ?>
                        </div>共 <?= $userCount ?> 位使用者
                    </div>
                    <div class="col-md-6">
                        <form action="" method="get">
                            <div class="input-group">
                                <input type="search" class="form-control" name="q" <?php $q = $_GET["q"] ?? "";
                                                                                    ?>
                                    value="<?= $q ?>">

                                <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa-fw" type="submit"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="py-2 text-end">
                    <div class="btn-group">
                        <a href="coaches.php?p=1&order=1" class="btn btn-primary <?php if ($order == 1) echo "active" ?>"><i class="fa-solid fa-arrow-down-1-9 fa-fw"></i></a>
                        <a href="coaches.php?p=1&order=2" class="btn btn-primary <?php if ($order == 2) echo "active" ?>"><i class="fa-solid fa-arrow-down-9-1 fa-fw"></i></a>
                        <a href="coaches.php?p=1&order=3" class="btn btn-primary <?php if ($order == 3) echo "active" ?>"><i class="fa-solid fa-arrow-down-a-z fa-fw"></i></a>
                        <a href="coaches.php?p=1&order=4" class="btn btn-primary <?php if ($order == 4) echo "active" ?>"><i class="fa-solid fa-arrow-down-z-a fa-fw"></i></a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>姓名</td>
                            <td>email</td>
                            <td>profile photo</td>
                            <td>查看/編輯</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><?= $row["name"] ?></td>
                                <td><?= $row["email"] ?></td>
                                <td><?= $row["profilephoto"] ?></td>
                                <td><a href="coach.php?id=<?= $row["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                                    <a href="coach-edit.php?id=<?= $row["id"] ?>" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (isset($_GET["p"])): ?>
                    <div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                                    <?php
                                    $active = ($i == $_GET["p"]) ?
                                        "active" : "";
                                    ?>
                                    <li class="page-item <?= $active ?>"><a class="page-link" href="coaches.php?p=<?= $i ?>& order=<?= $order ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>


    <div>
        <nav>

        </nav>
    </div>

    <?php include("./js.php") ?>
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    </div>

</body>

</html>