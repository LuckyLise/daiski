<?
// 將資料庫的資料顯示於HTML的table
// 將fetch_assoc()的方法改為fetch_all(MYSQLI_ASSOC)

require_once("../db_connect.php");

$sqlAll = "SELECT * FROM users WHERE valid=1";
$resultAll = $conn->query($sqlAll);
// 預設為所有筆數，若有q再改變
$userCount = $resultAll->num_rows;




// q搜尋、p頁數
$order = 1;
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $sql = "SELECT *FROM users WHERE name LIKE '%$q%'";
} else if (isset($_GET["p"]) && isset($_GET["order"])) {
    $order = $_GET["order"];

    // 每頁顯示數量
    $p = $_GET["p"];

    $perPage = 4;
    $startItem = ($p - 1) * $perPage;
    $totalPage = ceil($userCount / $perPage);

    switch ($order) {
        case 1:
            $orderBytext = "id";
            $ordertext = "ASC";
            break;
        case 2:
            $orderBytext = "id";
            $ordertext = "DESC";
            break;
        case 3:
            $orderBytext = "account";
            $ordertext = "ASC";
            break;
        case 4:
            $orderBytext = "account";
            $ordertext = "DESC";
            break;
    }

    $sql = "SELECT * FROM users WHERE valid=1 ORDER BY $orderBytext $ordertext LIMIT $startItem,$perPage";


    // echo "total page:".$totalPage;

} else {
    header("location:users.php?p=1&order=1");
    // $sql = "SELECT * FROM users WHERE valid=1";
}

$result = $conn->query($sql);
// 預設是索引式陣列 MYSQLI_NUM
$rows = $result->fetch_all(MYSQLI_ASSOC);


// 預設為所有筆數，若有q再改變
if (isset($_GET["q"])) {
    $userCount = $result->num_rows;
}

// var_dump($rows);

// var_dump($rows[0]["name"]);

// if ($result->num_rows > 0) 
// {
//     // 先判斷是否有資料，若有則while迴圈打印全部資料，若無則else
//     // output data of each row
//     //fetch_assoc() 將讀出的資料Key值設定為該欄位的欄位名稱。
//     while($row = $result->fetch_assoc()) {
//         echo " 姓名: " . $row["name"]. ", 電話: " . 
//        $row["phone"]. ", email: ".$row["email"]."<br>";
//         }
//         } else {
//         echo "0 results";

//         }
$conn->close();
?>


<!doctype html>
<html lang="en">

<head>
    <title>users</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <? include("../css.php") ?>

</head>

<body>
    <div class="container">
        <div class="py-2">
            <!-- fa-fw 固定icon寬度 -->
            <a class="btn btn-primary" href="create-user.php"><i class="fa-solid fa-user-plus fa-fw"></i>Add User</a>
        </div>

        <div class="py-2 row g-3 align-items-center">

            <div class="col-md-6">
                <div class="hstack gap-2 align-items-center">
                    <? if (isset($_GET["q"])): ?>
                        <a class="btn btn-primary" href="users.php"><i class="fa-solid fa-arrow-left fa-fw"></i>Go Back</a>

                    <? endif; ?>
                    <div> 共 <?= $userCount ?> 位使用者</div>
                </div>

            </div>
            <div class="col-md-6">
                <form action="" method="get">
                    <!-- php可以寫在div內 -->
                    <div class="input-group">
                        <!-- value 按下按鈕後欄位要顯示什麼，name代表網址後面加上q=表單內容 -->
                        <input type="search" class="form-control" name="q"
                            <?
                            // 能不寫else就不寫else

                            // 方法1
                            // $q = "";
                            // if (isset($_GET["q"])) {
                            //     $q = $_GET["q"];

                            // 方法2
                            // $q = (isset($_GET["q"])) ? $_GET["q"] : "";

                            // 方法3
                            $q = $_GET["q"] ?? "";

                            ?>

                            value="<?= $q ?>">

                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa-fw"></i>搜尋</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="py-2 text-end">
            <div class="btn-group">
                <!-- 根據網址的order排序決定給哪個按鈕"active" -->
                <a class="btn btn-primary <? if ($order == 1) echo "active" ?>" href="users.php?p=<?= $p ?>&order=1"><i class="fa-solid fa-arrow-down-1-9 fa-fw"></i></a>
                <a class="btn btn-primary <? if ($order == 2) echo "active" ?>" href="users.php?p=<?= $p ?>&order=2"><i class="fa-solid fa-arrow-down-9-1" fa-fw></i></a>
                <a class="btn btn-primary <? if ($order == 3) echo "active" ?>" href="users.php?p=<?= $p ?>&order=3"><i class="fa-solid fa-arrow-down-a-z" fa-fw></i></a>
                <a class="btn btn-primary <? if ($order == 4) echo "active" ?>" href="users.php?p=<?= $p ?>&order=4"><i class="fa-solid fa-arrow-down-z-a" fa-fw></i></a>
            </div>
        </div>

        <? if ($userCount > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>account</th>
                        <th>name</th>
                        <th>phone</th>
                        <th>email</th>
                    </tr>
                </thead>

                <tbody>
                    <? foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $row["id"]; ?></td>
                            <td><?= $row["account"]; ?></td>
                            <td><?= $row["name"]; ?></td>
                            <td><?= $row["phone"]; ?></td>
                            <td><?= $row["email"]; ?></td>
                            <td>
                                <a class="btn btn-primary" href="user.php?id=<?= $row['id']; ?>"><i class="fa-regular fa-eye fa-fw"></i></a>

                                <a class=" btn btn-primary" href="user-edit.php?id=<?= $row["id"] ?>"><i class="fa-regular fa-pen-to-square fa-fw"></i></a>

                            </td>
                        </tr>
                    <? endforeach; ?>
                </tbody>
            </table>
            <? if (isset($_GET["p"])): ?>
                <!-- bs套件 pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <!--  加上active讓當前分頁有顏色 -->
                        <? for ($i = 1; $i <= $totalPage; $i++): ?>

                            <? $active = ($i == $_GET["p"]) ? "active" : ""; ?>

                            <li class="page-item <?= $active ?>"><a class="page-link" href="users.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                        <? endfor; ?>


                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>




                    </ul>
                </nav>
            <? endif; ?>
        <? endif; ?>
    </div>


    <? include("../js.php") ?>
    </script>
</body>

</html>