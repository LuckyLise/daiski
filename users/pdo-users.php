<?php
require_once('../pdo_connect.php');

$sqlALL = "SELECT * FROM users WHERE valid=1";
$stmtALL = $db_host->prepare($sqlALL);
$stmtALL->execute();
$userCount = $stmtALL->rowCount();
$orderClause = "ORDER BY id ASC";
$sqlSelect = "";

$order = $_GET["order"];
if ($order % 2 == 1) {
    $select = "fa-chevron-up";
} else {
    $select = "fa-chevron-down";
}


if (isset($_GET["p"]) && isset($_GET["order"])) {
    if (isset($_GET["q"])) {
        $q = $_GET["q"];
        $order = $_GET["order"];
        $sqlSelect = "AND name LIKE '%$q%'";

        $sqlALL = "SELECT * FROM users WHERE valid=1 $sqlSelect";
        $stmtALL = $db_host->prepare($sqlALL);
        $stmtALL->execute();
        $userCount = $stmtALL->rowCount();
    }
    if (isset($_GET["ident"])) {
        $ident = $_GET["ident"];
        $order = $_GET["order"];
        $sqlSelect = "AND isCoach ='$ident'";

        $sqlALL = "SELECT * FROM users WHERE valid=1 $sqlSelect";
        $stmtALL = $db_host->prepare($sqlALL);
        $stmtALL->execute();
        $userCount = $stmtALL->rowCount();
    }
    switch ($order) {
        case 1;
            $orderClause = "ORDER BY id ASC";
            break;
        case 2;
            $orderClause = "ORDER BY id DESC";

            break;
        case 3;
            $orderClause = "ORDER BY name ASC";
            break;
        case 4;
            $orderClause = "ORDER BY name DESC";
            // $select="down";
            break;
        case 5;
            $orderClause = "ORDER BY birthday ASC";
            break;
        case 6;
            $orderClause = "ORDER BY birthday DESC";
            break;
        case 7;
            $orderClause = "ORDER BY createdtime ASC";
            break;
        case 8;
            $orderClause = "ORDER BY createdtime DESC";
            break;
        case 9;
            $orderClause = "ORDER BY isCoach ASC";
            break;
        case 10;
            $orderClause = "ORDER BY isCoach DESC";
            break;
    }
} else {
    header("location:pdo-users.php?p=1&order=1");
}

$p = $_GET["p"];
$perPage = 25;
$startItem = ($p - 1) * $perPage;
$totalPage = ceil($userCount / $perPage);
$sql = "SELECT * FROM users WHERE valid=1  $sqlSelect
$orderClause
LIMIT $startItem,$perPage";



$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo "<pre>"; 會將結果展開，自動換行
    // print_r($rows);會將結果用陣列的方式顯現出來
    // echo "</pre>";
} catch (PDOException $e) {
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

//1.php尾端再計算userCount`,可顯示正確頁數
//2.底下頁數的按鈕超連結 要增加q的欄位

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
    <?php include("./css.php") ?>
    <style>
        body {
            color: white !important;
            background-color: #07192F;

            table {
                color: white !important;
            }
        }
    </style>
</head>

<body>
    <!-- Loading 畫面 -->
    <div id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    <div class="d-flex flex-column ">
        <?php include("./new_head_mod.php"); ?>
        <div class="d-flex flex-row w-100 myPage">
            <?php include("./new_side_mod.php"); ?>
            <div class="container ">
                <div class="py-2">
                    <a class="btn btn-info" href="create-user.php"><i class="fa-solid fa-user-plus fa-fw"></i> Add User</a>
                </div>
                <div class="py-2 row g-3 align-items-center">
                    <div class="col-md-6">
                        <div class="hstack gap-2 align-items-center">
                            <?php if (isset($_GET["q"])): ?>
                                <a href="pdo-users.php" class="btn btn-info"><i class="fa-solid fa-left-long fa-fw"></i></a>
                            <?php endif; ?>
                            <div>共 <?= $userCount ?> 位使用者
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="" method="get">
                            <input type="hidden" name="p" value="1">
                            <input type="hidden" name="order" value="1">
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
                                    value="<?= $q ?>" placeholder="搜尋名稱">
                                <button class="btn btn-info">
                                    <i class="fa-solid fa-magnifying-glass fa-fw" type="submit"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="py-2 text-end">
                    <div class="btn-group">
                        <a class="btn btn-info <?php if ($order == 1) echo "active" ?>" href="pdo-users.php?p=<?= $p ?>&order=1"><i class="fa-solid fa-arrow-down-1-9 fa-fw"></i></a>
                        <a class="btn btn-info <?php if ($order == 2) echo "active" ?>" href="pdo-users.php?p=<?= $p ?>&order=2"><i class="fa-solid fa-arrow-down-9-1 fa-fw"></i></a>
                        <a class="btn btn-info <?php if ($order == 3) echo "active" ?>" href="pdo-users.php?p=<?= $p ?>&order=3"><i class="fa-solid fa-arrow-down-a-z fa-fw"></i></a>
                        <a class="btn btn-info <?php if ($order == 4) echo "active" ?>" href="pdo-users.php?p=<?= $p ?>&order=4"><i class="fa-solid fa-arrow-down-a-z fa-fw"></i></a>
                    </div>
                </div> -->
                <?php if ($userCount > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>id
                                    <a class=" <?= ($order == 1) ? "active" : "" ?>" href="pdo-users.php?p=<?= $p ?>&order=<?= ($order == 1) ? 2 : 1 ?>"><i class="fa-solid <?= ($order == 1 || $order == 2) ? $select : "fa-arrows-up-down" ?>  "></i></a>
                                </th>
                                <th>姓名
                                    <a class=" <?= ($order == 3) ? "active" : "" ?>" href="pdo-users.php?p=<?= $p ?>&order=<?= ($order == 3) ? 4 : 3 ?>"><i class="fa-solid <?= ($order == 3 || $order == 4) ? $select : "fa-arrows-up-down" ?> "></i></a>

                                </th>
                                <th>帳號</th>
                                <th>電話</th>
                                <th>生日
                                    <a class=" <?= ($order == 5) ? "active" : "" ?>" href="pdo-users.php?p=<?= $p ?>&order=<?= ($order == 5) ? 6 : 5 ?>"><i class="fa-solid <?= ($order == 5 || $order == 6) ? $select : "fa-arrows-up-down" ?> "></i></a>
                                </th>
                                <th>email</th>
                                <th>創建時間
                                    <a class=" <?= ($order == 7) ? "active" : "" ?>" href="pdo-users.php?p=<?= $p ?>&order=<?= ($order == 7) ? 8 : 7 ?>"><i class="fa-solid <?= ($order == 7 || $order == 8) ? $select : "fa-arrows-up-down" ?>"></i></a>
                                </th>
                                <th>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            身分別
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="pdo-users.php?&order=1&p=1">全部</a></li>
                                            <li><a class="dropdown-item" href="pdo-users.php?ident=0&order=1&p=1">會員</a></li>
                                            <li><a class="dropdown-item" href="pdo-users.php?ident=1&order=1&p=1">教練</a></li>
                                        </ul>
                                    </div>

                                    <!-- <a class=" <?= ($order == 9) ? "active" : "" ?>" href="pdo-users.php?p=<?= $p ?>&order=<?= ($order == 9) ? 10 : 9 ?>"><i class="fa-solid <?= ($order == 9 || $order == 10) ? $select : "fa-arrows-up-down" ?>"></i></a> -->
                                </th>
                                <th></th>
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
                                    <td>
                                        <?= ($row["isCoach"] == 1) ?  "教練" : "會員" ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-info" href="pdo-user.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-eye fa-fw"></i></a>
                                        <a class="btn btn-info" href="user-edit.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
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
                                        $active = ($i == $_GET["p"]) ?
                                            "active" : "";
                                        ?>
                                        <?php $search = (isset($_GET['q'])) ? "&q=$q" : "" ;
                                         $filter = (isset($_GET['ident'])) ? "&ident=$ident" : "" ;?>
                                        <li class="page-item <?= $active ?>">
                                            <a class="page-link" href="pdo-users.php?p=<?= $i ?>&order=<?= $order ?><?= $search ?><?=$filter?>"> <?= $i ?> </a>
                                        </li>
                                        <?php   ?>
                                        
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php include("./js.php") ?>

        <script>
            let users = <?= json_encode($rows) ?>;
            console.log(users);
        </script>
        <script>
            VANTA.BIRDS({
                el: ".sidebar", // 指定作用的 HTML 元素 ID
                mouseControls: true, // 啟用滑鼠控制，使動畫會跟隨滑鼠移動
                touchControls: true, // 啟用觸控控制，使動畫可以隨觸控移動
                gyroControls: false, // 禁用陀螺儀控制（手機旋轉時不影響動畫）
                minHeight: 50.00, // 設定最小高度，確保畫面不會小於 200px
                minWidth: 50.00, // 設定最小寬度，確保畫面不會小於 200px
                scale: 1.00, // 設定一般裝置上的縮放比例
                scaleMobile: 2.0, // 在手機上放大 2 倍，以提升可視度
                separation: 50.00, // 調整鳥群之間的間隔，數值越大，距離越大
                color1: 0xffffff,
                birdSize: 0.1,
                // backgroundColor:0x4e73df
            });
            VANTA.BIRDS({
                el: ".myPage", // 指定作用的 HTML 元素 ID
                mouseControls: true, // 啟用滑鼠控制，使動畫會跟隨滑鼠移動
                touchControls: true, // 啟用觸控控制，使動畫可以隨觸控移動
                gyroControls: false, // 禁用陀螺儀控制（手機旋轉時不影響動畫）
                minHeight: 50.00, // 設定最小高度，確保畫面不會小於 200px
                minWidth: 50.00, // 設定最小寬度，確保畫面不會小於 200px
                scale: 1.00, // 設定一般裝置上的縮放比例
                scaleMobile: 2.0, // 在手機上放大 2 倍，以提升可視度
                separation: 50.00, // 調整鳥群之間的間隔，數值越大，距離越大
                color1: 0xffffff,
                birdSize: 0.10,
                // backgroundColor:0x4e73df
            });
            VANTA.BIRDS({
                el: ".head", // 指定作用的 HTML 元素 ID
                mouseControls: true, // 啟用滑鼠控制，使動畫會跟隨滑鼠移動
                touchControls: true, // 啟用觸控控制，使動畫可以隨觸控移動
                gyroControls: false, // 禁用陀螺儀控制（手機旋轉時不影響動畫）
                minHeight: 50.00, // 設定最小高度，確保畫面不會小於 200px
                minWidth: 50.00, // 設定最小寬度，確保畫面不會小於 200px
                scale: 1.00, // 設定一般裝置上的縮放比例
                scaleMobile: 2.0, // 在手機上放大 2 倍，以提升可視度
                separation: 50.00, // 調整鳥群之間的間隔，數值越大，距離越大
                color1: 0xffffff,
                birdSize: 0.10,
                // backgroundColor:0x4e73df
            });

            //VANTA.WAVES({ //目前註解掉
            //  el: "body", //綁在body上會使該網頁的modal跳出來時有問題 最好綁在你需要的class上
            //  mouseControls: true,
            //  touchControls: true,
            //  gyroControls: false,
            //  minHeight: 200.00,
            //  minWidth: 200.00,
            //  scale: 1.00,
            //  scaleMobile: 1.00,
            //  color:0xb2e2ff
            // })
        </script>
    </div>
</body>

</html>