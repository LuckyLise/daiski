<?php
session_start();
require_once("../pdo_connect.php");

// 檢查是否有商品 ID，並從 GET 參數中獲取商品 ID
if (!isset($_GET['id'])) {
    die("缺少商品 ID");
}

$product_id = $_GET['id'];  // 使用 GET 來獲取商品 ID

try {
    // 查詢商品資料
    $stmt = $db_host->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    // 查詢所有分類
    $categories_stmt = $db_host->query("SELECT * FROM categories");
    $categories = $categories_stmt->fetchAll();

    // 查詢該商品的所有圖片，依 sortOrder 排序且 valid = 1
    $images_stmt = $db_host->prepare("SELECT * FROM product_images WHERE product_id = ? AND valid = 1 ORDER BY sortOrder ASC");
    $images_stmt->execute([$product_id]);
    $images = $images_stmt->fetchAll();

    // 分離出主圖（sortOrder = 0）和其他小圖
    $main_image = null;
    $small_images = [];
    foreach ($images as $img) {
        if ($img['sortOrder'] == 0) {
            $main_image = $img;
        } else {
            $small_images[] = $img;
        }
    }

    // 撈取該商品的規格資料，依 sortOrder 排序
    $specs_stmt = $db_host->prepare("SELECT * FROM product_specs WHERE product_id = ? AND valid = 1 ORDER BY sortOrder ASC");
    $specs_stmt->execute([$product_id]);
    $product_specs = $specs_stmt->fetchAll();

    // 若表單被提交（更新商品資料與圖片設定）
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
        // 更新商品資料
        $name             = $_POST['name'];
        $price            = $_POST['price'];
        $category_id      = $_POST['category_id'];
        $introduction     = $_POST['introduction'];
        $specIntroduction = $_POST['specIntroduction'];

        $update_stmt = $db_host->prepare("
            UPDATE products 
            SET name = ?, price = ?, category_id = ?, introduction = ?, specIntroduction = ?
            WHERE id = ?
        ");
        $update_stmt->execute([$name, $price, $category_id, $introduction, $specIntroduction, $product_id]);

        // 更新圖片設定：依使用者指定的排序值更新每張圖片
        $sort_orders = $_POST['sort_order'] ?? [];
        foreach ($images as $img) {
            $img_id = $img['id'];
            $order_value = isset($sort_orders[$img_id]) ? (int)$sort_orders[$img_id] : $img['sortOrder'];
            $update_img_stmt = $db_host->prepare("UPDATE product_images SET sortOrder = ? WHERE id = ?");
            $update_img_stmt->execute([$order_value, $img_id]);
        }

        // 更新完成後重定向
        header("Location: product-list.php");
        exit();
    }
} catch (PDOException $e) {
    die("操作失敗: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品編輯頁面</title>
    <?php include("./css.php"); ?>
    <style>
        body{
            color: white;
        }
        .small-img {
            max-width: 60px;
            aspect-ratio: 3/4;
            cursor: pointer;
        }

        .main-preview {
            max-width: 300px;
            aspect-ratio: 3/4;
            border: 1px solid #ccc;
        }

        input[name="main_image_id"] {
            display: none;
        }
    </style>
</head>

<body>
    <div class="d-flex flex-column">
        <?php include("./new_head_mod.php"); ?>
    </div>
    <div class="d-flex flex-row w-100 myPage">
        <?php include("./new_side_mod.php"); ?>
        <div class="container ">
            <div class="row">
                <!-- 單一大表單 (更新商品資料與圖片設定) -->
                <form class="col-12 row" method="POST" action="edit-product.php?id=<?= $product_id ?>">
                    <input type="hidden" name="action" value="edit">
                    <!-- 左半邊：商品資料與新增圖片上傳區 -->
                    <div class="col-md-6">
                        <h4>商品資料</h4>
                        <div class="form-group">
                            <label for="name">商品名稱</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="price">價格</label>
                            <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">分類</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= ($product['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="introduction">商品介紹</label>
                            <textarea class="form-control" id="introduction" name="introduction" required rows="3"><?= htmlspecialchars($product['introduction']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="specIntroduction">規格介紹</label>
                            <textarea class="form-control" id="specIntroduction" name="specIntroduction" required rows="3"><?= htmlspecialchars($product['specIntroduction']) ?></textarea>
                        </div>
                        <!-- 新增圖片上傳區：選取圖片 + 確定新增 -->
                        <div class="form-group">
                            <label for="product_images">新增圖片</label>
                            <input type="file" class="form-control" id="product_images" name="product_images[]" multiple>
                            <button type="button" id="confirmUploadBtn" class="btn btn-success mt-2">確定新增圖片</button>
                        </div>
                    </div>
                    <!-- 右半邊：圖片管理區 -->
                    <div class="col-md-6">
                        <h4>圖片管理</h4>
                        <!-- 主圖預覽 -->
                        <div class="mb-3">
                            <?php
                            $default_main_url = "";
                            foreach ($images as $img) {
                                if ($img['sortOrder'] == 0) {
                                    $default_main_url = $img['url'];
                                    break;
                                }
                            }
                            ?>
                            <img id="mainPreview" class="main-preview" src="<?= htmlspecialchars($default_main_url) ?>" alt="主圖預覽">
                        </div>
                        <h4>排序順序，數值越小越優先，0為主圖片，點選小圖可更改主圖片</h4>
                        <!-- 小圖列表，並加入 id="imageList" 以便新增圖片時動態追加 -->
                        <div id="imageList" class="image-list row row-cols-sm-2 row-cols-1">
                            <?php
                            // 目前總數
                            $total = count($images);
                            ?>
                            <?php foreach ($images as $img): ?>
                                <?php $is_main = ($img['sortOrder'] == 0); ?>
                                <div class="image-item">
                                    <div class="d-flex align-items-center gap-2">
                                        <img class="small-img " src="<?= htmlspecialchars($img['url']) ?>" alt="小圖" data-img-id="<?= $img['id'] ?>">
                                        <div>
                                            <input type="radio" name="main_image_id" value="<?= $img['id'] ?>" <?= $is_main ? 'checked' : '' ?>>
                                        </div>
                                        <!-- 這裡下拉選單以 $total 為選項數，但後續會由 JS 更新 -->
                                        <select name="sort_order[<?= $img['id'] ?>]" class="form-control sort-select" style="width:80px;" data-current="<?= ($is_main ? 0 : (int)$img['sortOrder']) ?>">
                                            <?php for ($i = 0; $i < $total; $i++): ?>
                                                <option value="<?= $i ?>" <?= ((int)$img['sortOrder'] === $i ? 'selected' : '') ?>><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <button type="button" class="btn btn-danger delete-image-btn" data-img-id="<?= $img['id'] ?>">刪除</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- 表單送出：更新商品 -->
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary">更新商品資料並回到列表</button>
                    </div>
                </form>
            </div>

            <!-- 規格管理區，放在表單之外，以 AJAX 處理新增與刪除 -->
            <div class="specContainer mt-4">
                <h4>商品規格</h4>
                <div id="specList" class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
                    <?php foreach ($product_specs as $spec): ?>
                        <div class="spec-item" data-spec-id="<?= $spec['id'] ?>">
                            <span class="spec-name"><?= htmlspecialchars($spec['specName']) ?></span>
                            :
                            <span class="spec-value"><?= htmlspecialchars($spec['specValue']) ?></span>
                            (排序: <?= $spec['sortOrder'] ?>)
                            <button type="button" class="btn btn-danger btn-sm delete-spec-btn" data-spec-id="<?= $spec['id'] ?>">刪除</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="addSpecSection" class="d-flex flex-row gap-3 mt-3">
                    <input type="text" id="newSpecName" placeholder="規格名稱" value="尺寸">
                    <input type="text" id="newSpecValue" placeholder="規格內容">
                    <button type="button" id="addSpecBtn" class="btn btn-success btn-sm">新增規格</button>
                </div>
            </div>
        </div>
    </div>


    <?php include("./js.php"); ?>

    <script>
        // 自動撐高 textarea
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("textarea").forEach(textarea => {
                textarea.style.height = textarea.scrollHeight + "px";
                textarea.addEventListener("input", function() {
                    this.style.height = "auto";
                    this.style.height = this.scrollHeight + "px";
                });
            });
        });

        // 主圖與排序功能 (原有邏輯維持不變)
        document.addEventListener("DOMContentLoaded", function() {
            const mainPreview = document.getElementById("mainPreview");
            const sortSelects = document.querySelectorAll(".sort-select");
            const smallImages = document.querySelectorAll(".small-img");

            function isSortOrderValid() {
                // 每次呼叫時都重新查詢目前的排序下拉選單
                const currentSelects = document.querySelectorAll(".sort-select");
                const values = new Set();
                for (let select of currentSelects) {
                    if (values.has(select.value)) {
                        return false;
                    }
                    values.add(select.value);
                }
                return true;
            }

            function swapSortOrder(id1, id2) {
                const s1 = document.querySelector(`select[name="sort_order[${id1}]"]`);
                const s2 = document.querySelector(`select[name="sort_order[${id2}]"]`);
                if (s1 && s2) {
                    let temp = s1.value;
                    s1.value = s2.value;
                    s2.value = temp;
                }
            }

            function updateMainImage(selectedId) {
                const selectedImg = document.querySelector(`.small-img[data-img-id="${selectedId}"]`);
                const currentMainRadio = document.querySelector('input[name="main_image_id"]:checked');
                const currentMainId = currentMainRadio ? currentMainRadio.value : null;
                if (!selectedImg || !currentMainId || selectedId === currentMainId) return;
                swapSortOrder(selectedId, currentMainId);
                mainPreview.src = selectedImg.src;
                if (currentMainRadio) currentMainRadio.checked = false;
                const selectedRadio = document.querySelector(`input[name="main_image_id"][value="${selectedId}"]`);
                if (selectedRadio) selectedRadio.checked = true;
            }

            smallImages.forEach(img => {
                img.addEventListener("click", function() {
                    updateMainImage(this.dataset.imgId);
                });
            });

            sortSelects.forEach(select => {
                select.addEventListener("change", function() {
                    if (!isSortOrderValid()) {
                        alert("排序值重複，請重新選擇！");
                        return;
                    }
                    const selectedId = this.name.match(/\d+/)[0];
                    if (this.value === "0") {
                        updateMainImage(selectedId);
                    }
                });
            });

            document.querySelector("form").addEventListener("submit", function(event) {
                if (!isSortOrderValid()) {
                    alert("排序值重複，請修正後再提交！");
                    event.preventDefault();
                }
            });
        });

        // 刪除圖片功能 (AJAX 刪除並移除元素)
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-image-btn").forEach(button => {
                button.addEventListener("click", function() {
                    const imgId = this.getAttribute("data-img-id");
                    fetch("delete_image.php", {
                            method: "POST",
                            body: new URLSearchParams({
                                id: imgId
                            }),
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const imageItem = button.closest(".image-item");
                                if (imageItem) {
                                    imageItem.remove();
                                }
                                alert(data.message);
                                // 如有刪除，更新所有排序下拉選單 (此處可根據需求再做調整)
                                updateAllSortSelects();
                            } else {
                                alert("刪除失敗: " + data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("刪除過程中發生錯誤！");
                        });
                });
            });
        });

        // 用來更新所有排序下拉選單的選項，使其範圍統一
        function updateAllSortSelects() {
            // 取得目前所有 .sort-select 下拉選單的容器，並計算新的選項數目
            // 假設新的選項數目為目前所有圖片數 (更新後的 imageList 子元素數)
            const imageList = document.getElementById("imageList");
            const total = imageList.querySelectorAll(".image-item").length;
            document.querySelectorAll(".sort-select").forEach(select => {
                const currentValue = select.value;
                let options = "";
                for (let i = 0; i < total; i++) {
                    options += `<option value="${i}" ${i == currentValue ? "selected" : ""}>${i}</option>`;
                }
                select.innerHTML = options;
            });
        }

        // 新增圖片上傳功能
        document.addEventListener("DOMContentLoaded", function() {
            const confirmBtn = document.getElementById("confirmUploadBtn");
            confirmBtn.addEventListener("click", function() {
                const fileInput = document.getElementById("product_images");
                const files = fileInput.files;
                if (files.length === 0) {
                    alert("請選擇圖片！");
                    return;
                }
                let formData = new FormData();
                // 將檔案加入 formData
                for (let i = 0; i < files.length; i++) {
                    formData.append("product_images[]", files[i]);
                }
                // 呼叫上傳處理檔 upload_image.php，傳入商品 id
                fetch("upload_image.php?id=<?= $product_id ?>", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // 清空檔案輸入
                            fileInput.value = "";
                            const imageList = document.getElementById("imageList");
                            // 新的總選項數目為 (max_sort_order + 1)
                            const newTotal = data.max_sort_order + 1;
                            // 處理每張新上傳的圖片
                            data.new_images.forEach(image => {
                                const imageItem = document.createElement("div");
                                imageItem.className = "image-item";
                                // 建立下拉選單選項字串，總數為 newTotal
                                let selectOptions = "";
                                for (let i = 0; i < newTotal; i++) {
                                    // 若該圖片的 sortOrder 等於 i 則選取該選項
                                    selectOptions += `<option value="${i}" ${i == image.sortOrder ? "selected" : ""}>${i}</option>`;
                                }
                                imageItem.innerHTML = `
                <div class="d-flex align-items-center mb-2">
                  <img class="small-img mr-2" src="${image.url}" alt="小圖" data-img-id="${image.id}">
                  <div class="mx-2">
                    <input type="radio" name="main_image_id" value="${image.id}">
                  </div>
                  <select name="sort_order[${image.id}]" class="form-control sort-select" style="width:80px;">
                    ${selectOptions}
                  </select>
                  <button type="button" class="btn btn-danger delete-image-btn" data-img-id="${image.id}">刪除</button>
                </div>
              `;
                                imageList.appendChild(imageItem);
                            });
                            // 更新所有排序下拉選單，使原有圖片也顯示新範圍
                            updateAllSortSelects();
                        } else {
                            alert("上傳失敗: " + (data.message || "未知錯誤"));
                        }
                    })
                    .catch(error => {
                        console.error("上傳錯誤:", error);
                        alert("上傳發生錯誤，請稍後再試！");
                    });
            });
        });




        // --- 規格管理功能 ---
        document.addEventListener("DOMContentLoaded", function() {
            // 新增規格
            document.getElementById("addSpecBtn").addEventListener("click", function() {
                const specName = document.getElementById("newSpecName").value.trim();
                const specValue = document.getElementById("newSpecValue").value.trim();
                if (!specName || !specValue) {
                    alert("請輸入規格名稱與內容");
                    return;
                }
                const formData = new FormData();
                formData.append("specName", specName);
                formData.append("specValue", specValue);
                formData.append("product_id", "<?= $product_id ?>");

                fetch("upload_spec.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const specList = document.getElementById("specList");
                            const specDiv = document.createElement("div");
                            specDiv.className = "spec-item";
                            specDiv.setAttribute("data-spec-id", data.new_spec.id);
                            specDiv.innerHTML = `<span class="spec-name">${data.new_spec.specName}</span> : 
               <span class="spec-value">${data.new_spec.specValue}</span> (排序: ${data.new_spec.sortOrder}) 
               <button type="button" class="btn btn-danger btn-sm delete-spec-btn" data-spec-id="${data.new_spec.id}">刪除</button>`;
                            specList.appendChild(specDiv);
                            document.getElementById("newSpecValue").value = "";
                        } else {
                            alert("新增規格失敗: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("新增規格時發生錯誤");
                    });
            });

            // 刪除規格 (事件代理)
            document.getElementById("specList").addEventListener("click", function(e) {
                if (e.target && e.target.matches(".delete-spec-btn")) {
                    const specId = e.target.getAttribute("data-spec-id");
                    if (!confirm("確定要刪除此規格嗎?")) return;
                    fetch("delete_spec.php", {
                            method: "POST",
                            body: new URLSearchParams({
                                id: specId
                            }),
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const specItem = e.target.closest(".spec-item");
                                if (specItem) specItem.remove();
                            } else {
                                alert("刪除規格失敗: " + data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("刪除規格時發生錯誤");
                        });
                }
            });
        });
    </script>






    <!-- 引入最新版本的 Three.js（Vanta.js 依賴 Three.js） -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>

    <!-- 引入 Vanta.js 中的 BIRDS 效果（鳥群動畫） -->
    <script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.birds.min.js"></script>

    <!-- 引入 Vanta.js 中的 WAVES 效果（波浪動畫） -->
    <script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.waves.min.js"></script>

    <!-- net -->
    <script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.net.min.js"></script>

    <!--rings-->
    <script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.rings.min.js"></script>

    <!-- topology要用的 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.11.2/p5.min.js" integrity="sha512-1YMgn4j8cIL91s14ByDGmHtBU6+F8bWOMcF47S0cRO3QNm8SKPNexy4s3OCim9fABUtO++nJMtcpWbINWjMSzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--  topology-->
    <script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.topology.min.js"></script>

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

        // VANTA.WAVES({
        //     el: ".myPage",
        //     mouseControls: true,
        //     touchControls: true,
        //     gyroControls: false,
        //     minHeight: 200.00,
        //     minWidth: 200.00,
        //     scale: 1.00,
        //     scaleMobile: 1.00,
        //     color: 0xb2e2ff
        // })

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
    </script>
</body>

</html>