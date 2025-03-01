<!doctype html>
<html lang="en">

<head>
    <title>DAISKI</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>
<style>
    .homePage{
        color: #fff;
    }
</style>

</head>

<body>
   
    <div class="d-flex flex-column myPage">
        <?php include("./new_head_mod.php"); ?>

        <div class="d-flex flex-row w-100 ">
            <?php include("./new_side_mod.php"); ?>
            <div class="container-fluid d-flex flex-column p-5 homePage">

                <h1>Welcome to Daiski</h1>
                
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
            // backgroundColor:0x4e73df
            color1: 0xffffff,
            birdSize: 0.10,
            quantity: 5.00,
        });
    </script>




</body>

</html>