<?

// 系統注重防呆，要給使用者好的體驗
if (!isset($_GET["id"])) {
    header("location: users.php");
}


// GET是抓網址，需在網址後面加上 "?id=1"
$id = $_GET["id"];


require_once("../db_connect.php");
$sql = "SELECT * FROM users WHERE id = $id AND valid=1";
$result = $conn->query($sql);
// $rows=$result->fetch_all(MYSQLI_ASSOC);

// fetch_assoc() 只查詢單筆資料時使用，可以避免全查詢的資安問題
$row = $result->fetch_assoc();
// var_dump($row);

$userCount = $result->num_rows;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <? include("../css.php") ?>
</head>

<body>
    <!-- modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">系統資訊</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    確認要讓這個人消失?
                </div>
                <div class="modal-footer">
                    <a href="userDelete.php?id=<?=$row["id"] ?>" role="button" class="btn btn-primary">立刻消失</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">再留他一下</button>
                </div>
            </div>
        </div>
    </div>




    <div class="container">
        <div class="py-2">
            <a class="btn btn-primary" href="user.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-list fa-fw"></i>上一步</a>
        </div>
        <div class="row">
            <div class="clo-lg-4 col-md-9">
                <? if ($userCount > 0): ?>
                    <form action="doUpdateUser.php" method="post">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <table class="table table-bordered">
                            <!-- (tr>th+td)*5 -->
                            <tr>
                                <th>id</th>
                                <td><?= $row["id"] ?></td>
                            </tr>
                            
                            <tr>
                                
                                <th>account</th>
                                <td><?= $row["account"] ?></td>
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
                                <th>created at</th>
                                <td><?= $row["creat_at"] ?></td>
                            </tr>
                        </table>

                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk fa-fw"></i>儲存</button>

                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="fa-solid fa-trash fa-fw"></i>刪除</a>
                        </div>
                    </form>

                <? else: ?>
                    <h2>使用者不存在</h2>
                <? endif; ?>
            </div>
        </div>
        <? include("../js.php") ?>
    </div>

</body>

</html>