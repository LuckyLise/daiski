<?php
session_start();
require_once("../pdo_connect.php");

// 處理表單提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // 取得基本欄位值
  $name = trim($_POST['name'] ?? '');
  $price = trim($_POST['price'] ?? '');
  $category_id = trim($_POST['category_id'] ?? '');
  $introduction = trim($_POST['introduction'] ?? '');
  $specIntroduction = trim($_POST['specIntroduction'] ?? '');

  // 檢查必填欄位是否有值
  if ($name === '' || $price === '' || $category_id === '' || $introduction === '' || $specIntroduction === '') {
    $error = "請填寫所有必填欄位。";
  } else {
    // 檢查規格欄位：如果有規格輸入，逐筆檢查
    $specNames = isset($_POST['specName']) ? $_POST['specName'] : array();
    $specValues = isset($_POST['specValue']) ? $_POST['specValue'] : array();
    $specError = false;
    for ($i = 0; $i < count($specNames); $i++) {
      $sn = trim($specNames[$i]);
      $sv = trim($specValues[$i]);
      // 如果一筆規格資料只有一個有值（不完整），則視為錯誤
      if (($sn === '' && $sv !== '') || ($sn !== '' && $sv === '')) {
        $specError = true;
        break;
      }
    }
    if ($specError) {
      $error = "規格資料不完整，請填寫完整或保持空白。";
    }
  }

  // 新增圖片上傳驗證：必須至少有一張有效圖片
  if (!isset($error)) {
    $hasValidImage = false;
    if (isset($_FILES['product_images']) && is_array($_FILES['product_images']['tmp_name'])) {
      foreach ($_FILES['product_images']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['product_images']['error'][$key] === UPLOAD_ERR_OK && is_uploaded_file($tmpName)) {
          $hasValidImage = true;
          break;
        }
      }
    }
    if (!$hasValidImage) {
      $error = "請至少上傳一張商品圖片。";
    }
  }

  // 若沒有錯誤，則進行資料寫入
  if (!isset($error)) {
    try {
      // 為避免部分新增成功造成資料不一致，可考慮使用交易處理 (Transaction)
      $db_host->beginTransaction();

      // 1. 新增商品基本資料 (products)
      $stmt = $db_host->prepare("INSERT INTO products (name, price, category_id, introduction, specIntroduction) VALUES (?, ?, ?, ?, ?)");
      $stmt->execute([$name, $price, $category_id, $introduction, $specIntroduction]);
      $new_product_id = $db_host->lastInsertId();

      // 2. 處理上傳的圖片 (product_images)
      // 如果有上傳圖片 (注意：若未選擇檔案，error code 為 UPLOAD_ERR_NO_FILE)
      if (isset($_FILES['product_images']) && $_FILES['product_images']['error'][0] != UPLOAD_ERR_NO_FILE) {
        // 建立商品目錄 (若不存在則建立)
        $uploadDir = "./productImages/" . $new_product_id . "/";
        if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        }
        $sortOrder = 0; // 第一張預設排序為 0
        foreach ($_FILES['product_images']['tmp_name'] as $key => $tmpName) {
          if ($_FILES['product_images']['error'][$key] === UPLOAD_ERR_OK) {
            $originalName = $_FILES['product_images']['name'][$key];
            $fileExt = pathinfo($originalName, PATHINFO_EXTENSION);
            $newFileName = uniqid() . "." . $fileExt;
            $destination = $uploadDir . $newFileName;
            if (move_uploaded_file($tmpName, $destination)) {
              $stmt = $db_host->prepare("INSERT INTO product_images (product_id, url, sortOrder, valid) VALUES (?, ?, ?, 1)");
              $stmt->execute([$new_product_id, $destination, $sortOrder]);
              $sortOrder++;
            }
          }
        }
      }

      // 3. 處理商品規格 (product_specs)
      // 只處理「完整」的規格資料，即 specName 與 specValue 皆不為空者
      if (isset($specNames) && isset($specValues)) {
        $specSortOrder = 0;
        for ($i = 0; $i < count($specNames); $i++) {
          $sn = trim($specNames[$i]);
          $sv = trim($specValues[$i]);
          // 如果兩者都為空，表示該筆規格不需要存入資料庫
          if ($sn === '' && $sv === '') {
            continue;
          }
          // 若不為空則（前面已驗證過，不會出現只有一個有值的狀況）
          $stmt = $db_host->prepare("INSERT INTO product_specs (product_id, specName, specValue, sortOrder, createdAt, valid) VALUES (?, ?, ?, ?, NOW(), 1)");
          $stmt->execute([$new_product_id, $sn, $sv, $specSortOrder]);
          $specSortOrder++;
        }
      }

      $db_host->commit();
      // 成功後轉向到商品列表頁面
      header("Location: product-list.php");
      exit();
    } catch (PDOException $e) {
      $db_host->rollBack();
      $error = "新增商品失敗: " . $e->getMessage();
    }
  }
}

// 撈取所有分類，用於下拉選單
try {
  // 撈出所有分類（包含 id, name, parentId）
  $categories_stmt = $db_host->query("SELECT * FROM categories");
  $categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);

  // 建立 parentId 清單
  $parentIds = [];
  foreach ($categories as $cat) {
    if ($cat['parentId'] !== null) {
      $parentIds[$cat['parentId']] = true; // 記錄該分類是某個分類的父分類
    }
  }

  // 篩選出最細分類（即不在 parentId 清單中的分類）
  $leafCategories = [];
  foreach ($categories as $cat) {
    if (!isset($parentIds[$cat['id']])) {
      $leafCategories[] = $cat; // 這個分類沒有子分類，因此是最細分類
    }
  }
} catch (PDOException $e) {
  $error = "取得分類失敗: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新增商品</title>
  <?php include("./css.php"); ?>
  <style>
    body {
      height: 100vh;

      color: white;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .spec-row {
      margin-bottom: 10px;
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
  <div class="d-flex flex-column" id="mainContent">
    <?php include("./new_head_mod.php"); ?>
  
  <div class="d-flex flex-row w-100">
    <?php include("./new_side_mod.php"); ?>

    <div class="container myPage">
      <h2>新增商品</h2>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <form action="create-product.php" method="POST" enctype="multipart/form-data">
        <!-- 商品基本資料 -->
        <div class="form-group">
          <label for="name">商品名稱</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="price">價格</label>
          <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
          <label for="category_id">分類</label>
          <select name="category_id" id="category_id" class="form-control" required>
            <option value="">請選擇分類</option>
            <?php foreach ($leafCategories as $cat): ?>
              <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="introduction">商品介紹</label>
          <textarea class="form-control" id="introduction" name="introduction" rows="4" required></textarea>
        </div>
        <div class="form-group">
          <label for="specIntroduction">規格介紹</label>
          <textarea class="form-control" id="specIntroduction" name="specIntroduction" rows="3" required></textarea>
        </div>

        <!-- 商品圖片 -->
        <div class="form-group">
          <label for="product_images">上傳商品圖片 (可一次選擇多張)</label>
          <input type="file" class="form-control" id="product_images" name="product_images[]" multiple>
        </div>

        <!-- 商品規格 -->
        <div class="form-group">
          <label>商品規格</label>
          <div id="specContainer">
            <!-- 初始兩組規格輸入欄位 -->
            <div class="spec-row">
              <input type="text" class="form-control d-inline-block" style="width: 200px;" name="specName[]" placeholder="規格名稱">
              <input type="text" class="form-control d-inline-block" style="width: 200px;" name="specValue[]" placeholder="規格內容">
            </div>
            <div class="spec-row">
              <input type="text" class="form-control d-inline-block" style="width: 200px;" name="specName[]" placeholder="規格名稱">
              <input type="text" class="form-control d-inline-block" style="width: 200px;" name="specValue[]" placeholder="規格內容">
            </div>
          </div>
          <button type="button" id="addSpecRowBtn" class="btn btn-secondary btn-sm">新增更多規格</button>
        </div>

        <button type="submit" class="btn btn-primary">提交新增</button>
      </form>
    </div>
  </div>
  </div>


  <?php include("./js.php"); ?>
  <script>
    // 當按下 "新增更多規格" 按鈕時，增加一組規格輸入欄位
    document.getElementById("addSpecRowBtn").addEventListener("click", function() {
      const specContainer = document.getElementById("specContainer");
      const div = document.createElement("div");
      div.className = "spec-row";
      div.innerHTML = `
        <input type="text" class="form-control d-inline-block" style="width: 200px;" name="specName[]" placeholder="規格名稱">
        <input type="text" class="form-control d-inline-block" style="width: 200px;" name="specValue[]" placeholder="規格內容">
      `;
      specContainer.appendChild(div);
    });
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
            // 傷害眼睛

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

            // gsap.from("#mainContent", {
            //     y: -100,
            //     opacity: 0,
            //     duration: 1,
            //     ease: "bounce.out"
            // });


        });
    </script>
</body>

</html>