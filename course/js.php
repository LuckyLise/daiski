<!-- Bootstrap JavaScript Libraries -->
<!-- <script
     src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
     integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
     crossorigin="anonymous"></script>

 <script
     src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
     integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
     crossorigin="anonymous"></script>
      -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js?time=<?= time(); ?>" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- 刪除課程用 -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function() {
                let courseId = this.getAttribute("data-course-id");
                if (confirm("確定要刪除這個課程嗎？此操作無法復原！")) {
                    window.location.href = "delete_course.php?id=" + courseId;
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-photo-btn").forEach(function(btn) {
            btn.addEventListener("click", function() {
                var photoId = this.getAttribute("data-photo-id");
                if (confirm("確定要刪除這張照片嗎？")) {
                    fetch("delete_course_image.php?photo_id=" + photoId)
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() === "success") {
                                // 刪除成功，移除這個照片區塊
                                this.parentElement.remove();
                            } else {
                                alert("刪除失敗！");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("刪除失敗！");
                        });
                }
            });
        });
    });
</script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js?time=<?= time() ?>" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js?time=<?= time() ?>" crossorigin="anonymous"></script>
<script src="./js/scripts.js?time=<?= time() ?>"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js?time=<?= time() ?>" crossorigin="anonymous"></script> -->
<!-- <script src="./js/chart-area-demo.js?time=<?= time() ?>"></script> -->
<!-- <script src="./js/chart-bar-demo.js?time=<?= time() ?>"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js?time=<?= time() ?>" crossorigin="anonymous"></script> -->
<!-- <script src="./js/datatables-simple-demo.js?time=<?= time() ?>"></script> -->
<!-- <script src="./js/chart-pie-demo.js"></script> -->
<!-- <script src="./js/datatables-demo.js"></script> -->



<!-- 引入最新版本的 Three.js（Vanta.js 依賴 Three.js） -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<!-- topology trunk要用的p5.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.11.2/p5.min.js" integrity="sha512-1YMgn4j8cIL91s14ByDGmHtBU6+F8bWOMcF47S0cRO3QNm8SKPNexy4s3OCim9fABUtO++nJMtcpWbINWjMSzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- 引入 Vanta.js 中的各種效果 -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.birds.min.js"></script> <!-- BIRDS -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.fog.min.js"></script> <!-- FOG -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.waves.min.js"></script> <!-- WAVES -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.clouds.min.js"></script> <!-- CLOUDS -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.clouds2.min.js"></script> <!-- CLOUDS2 -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.globe.min.js"></script> <!-- GLOBE -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.net.min.js"></script> <!-- NET -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.cells.min.js"></script> <!-- CELLS -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.trunk.min.js"></script> <!-- TRUNK -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.topology.min.js"></script> <!-- TOPOLOGY -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.dots.min.js"></script> <!-- DOTS -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.rings.min.js"></script> <!-- RINGS -->
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.halo.min.js"></script> <!-- HALO -->
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
</script>