<?php
session_start();

?>
<!doctype html>
<html lang="en">

<head>
    <title>Create User</title>
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
                <?php
                if (isset($_SESSION["error"])) {
                    // 顯示錯誤訊息，並以紅色字體標示
                    echo "<p style='color: red;'>" . $_SESSION["error"] . "</p>";
                    // 顯示後清除錯誤訊息，避免重複出現
                    unset($_SESSION["error"]);
                } ?>

                <div class="py-2">
                    <a class="btn btn-primary" href="pdo-users.php"><i class="fa-solid fa-arrow-left fa-fw"></i>使用者列表</a>
                </div>
                <form action="pdo-insert-user.php" method="post">
                    <div class="mb-2">
                        <label for="name" class="form-label">姓名</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="mb-2">
                        <label for="account" class="form-label">帳號</label>
                        <input type="account" class="form-control" name="account" id="account">
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">密碼</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-2">
                        <label for="repassword" class="form-label">重複密碼</label>
                        <input type="password" class="form-control" name="repassword" id="repassword">
                    </div>
                    <div class="mb-2">
                        <div class="mb-2">
                            <label for="phone" class="form-label">電話</label>
                            <input type="tel" class="form-control" name="phone" id="phone">
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label">Coach</label>
                            <br>
                            <input type="radio" name="isCoach" id="" value="1">是
                            <input type="radio" name="isCoach" id="" value="0">否
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary"
                                type="submit">送出</button>
                        </div>
                </form>
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
                separation: 500.00, // 調整鳥群之間的間隔，數值越大，距離越大
                color1: 0xffffff,
                birdSize: 0.50,
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
                separation: 500.00, // 調整鳥群之間的間隔，數值越大，距離越大
                color1: 0xffffff,
                birdSize: 0.50,
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
                separation: 500.00, // 調整鳥群之間的間隔，數值越大，距離越大
                color1: 0xffffff,
                birdSize: 0.50,
                // backgroundColor:0x4e73df
            });
        </script>
    </div>

</body>

</html>