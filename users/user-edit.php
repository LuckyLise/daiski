<?php
if (!isset($_GET["id"])) {
    header("location: users.php");
}

$id = $_GET["id"];

require_once('../pdo_connect.php');

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
    <div class="d-flex flex-column" id="mainContent">
        <?php include("./new_head_mod.php"); ?>
        <div class="d-flex flex-row w-100 myPage">
            <?php include("./new_side_mod.php"); ?>
            <div class="container">
                <div class="py-2">
                    <a class="btn btn-info" href="pdo-user.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
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
                                        <th>姓名</th>
                                        <td>
                                            <input type="text" class="form-control" name="name"
                                                value="<?= $row["name"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>帳號</th>
                                        <td>
                                            <?= $row["account"] ?>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>密碼</th>
                                        <td>
                                            <input type="password" class="form-control" name="password"
                                                value="<?= $row["password"] ?>" maxlength="10" minlength="4" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>電話</th>
                                        <td>
                                            <input type="tel" class="form-control" name="phone"
                                                value="<?= $row["phone"] ?>" maxlength="10" minlength="6">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>生日</th>
                                        <td>
                                            <input type="date" class="form-control" name="birthday" max=<?=date("Y-m-d")?>
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
                                        <th>創建時間</th>
                                        <td><?= $row["createdtime"] ?></td>
                                    </tr>
                                    <tr>
                                        <th>具有教練身份</th>
                                        <td>
                                            <?php if ($row["isCoach"] == 0): ?>
                                                <input type="radio" name="isCoach" id="" value="1">是
                                                <input type="radio" name="isCoach" id="" value="0" checked>否
                                            <?php else : ?>
                                                <input type="radio" name="isCoach" id="" value="1" checked>是
                                                <input type="radio" name="isCoach" id="" value="0">否
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-info" type="submit"><i class="fa-solid fa-floppy-disk">儲存</i></button>
                                    <a class="btn btn-danger" href="userDelete.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-trash-can">刪除</i></a>
                                </div>
                            </form>
                        <?php else: ?>
                            <h2>使用者不存在</h2>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
        <?php include("./js.php") ?>
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
			birdSize: 0.10,
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

        </script>
        
    </div>
</body>

</html>