<?php
require_once("../pdo_connect.php");
$sqlAll = "SELECT * FROM coach WHERE valid=1";
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
    $sql = "SELECT * FROM coach WHERE valid=1
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
        body{
            color: white !important;
            th{
                color: white !important;
            }
            td{
                color: white !important;
            }
        }
        /* 預設隱藏主要內容，僅顯示 loading 區塊 */
        #mainContent {
            display: none;
        }

        /* Loading 畫面 */
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #07192F;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }

        /* 轉圈動畫 */
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
        
    </style>
</head>

<body>
<!-- Loading 畫面 -->
<div id="loadingOverlay">
    <div class="spinner"></div>
  </div>
    <div class="d-flex flex-column" id="mainContent" >
        <?php include("./new_head_mod.php") ?>
        <div class="d-flex flex-row w-100 myPage">
            <?php include("./new_side_mod.php") ?>

            <div class="container ">
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
                                <td><div class="row row-cols-lg-4 rol-cols-mb-3 row-cols-sm-2 row-cols-lg-3">
                                        <div class="col">
                                            <div class="ratio ratio-1x1">
                                                <img src="../coach/images/<?= $row["profilephoto"] ?>" alt="<?= $row["name"] ?>" class="object-fit-cover">
                                            </div>
                                        </div>
                                    </div></td>
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
    <script>
        window.addEventListener('load', function() {
            // 出場動畫：loading 畫面淡出
            gsap.to("#loadingOverlay", {
                opacity: 0,
                duration: 0.5,
                onComplete: function() {
                    document.getElementById("loadingOverlay").style.display = "none";
                }
            });

            //以下是自己網頁的入場動畫

            //       gsap.fromTo("#mainContent", 
            //   { rotation: -10, opacity: 0 }, 
            //   { rotation: 0, opacity: 1, duration: 0.8, ease: "back.out(1.5)" }
            // );
            //還不錯

            // gsap.fromTo("#mainContent", 
            //   { scale: 0.8, opacity: 0 }, 
            //   { scale: 1, opacity: 1, duration: 0.8, ease: "power2.out" }
            // );
            //普通

            // gsap.fromTo("#mainContent", 
            //   { filter: "blur(5px)", opacity: 0 }, 
            //   { filter: "blur(0px)", opacity: 1, duration: 0.8, ease: "power2.out" }
            // );


            // gsap.from("#mainContent", {
            //   y: 100,
            //   duration: 0.8,
            //   ease: "elastic.out(1, 0.5)"
            // });

            // let elements = document.querySelectorAll("#mainContent div");
            // elements.forEach(el => {
            //     gsap.from(el, {
            //         x: gsap.utils.random(-50, 50),
            //         y: gsap.utils.random(-50, 50),
            //         duration: 1,
            //         ease: "back.out(1.5)"
            //     });
            // });
            //不怎麼好看但很炫

            gsap.from("#mainContent", {
                rotateY: -90,
                duration: 1,
                ease: "back.out(1.7)"
            });
            //還不錯

        });
    </script>
</body>
</html>