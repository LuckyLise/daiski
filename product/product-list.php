<?php
session_start();
require_once("../pdo_connect.php");

try {

    //$productStatus = 0; //初始值為0(未上架) 1是上架 2是下架 3是軟刪除 
    //按上架按紐時 products資料表內的 publishAt需要更新 unpublishAt需要變為NULL
    //按下架按紐時 products資料表內的 publishAt需要變為NULL unpublishAt需要更新

    function getProductStatus($product)
    {
        date_default_timezone_set('Asia/Taipei'); //一定要設定時區 不然會有問題
        $now = new DateTime(); //取得目前時間

        // 若 deleteAt 有值，直接視為下架
        if (!empty($product['deleteAt'])) {
            return 2; //2是下架
        }

        // 若 unpublishAt 有值且時間已到，也視為下架
        if (!empty($product['unpublishAt'])) {
            $unpublishAt = new DateTime($product['unpublishAt']);
            if ($now >= $unpublishAt) {
                return 2; //2是下架
            }
        }

        // 如果 publishAt 為 NULL，或是 publishAt 尚未到（預約上架），則為未上架
        if (empty($product['publishAt'])) {
            return 0; //0是未上架
        } else {
            $publishAt = new DateTime($product['publishAt']);
            if ($now < $publishAt) {
                return 0; //0是未上架
            } else {
                // 上架時間已到且未符合下架條件，則為上架中
                return 1; //1是上架
            }
        }
    }

    function getSubCategoryIds($categoryId, $categories)
    {
        $subCategoryIds = [];
        foreach ($categories as $category) {
            if ($category['parentId'] == $categoryId) {
                $subCategoryIds[] = $category['id'];
            }
        }
        return $subCategoryIds;
    }

    // 1. 撈取所有類別資料
    $sqlCate = "SELECT * FROM categories";
    $stmtCate = $db_host->prepare($sqlCate);
    $stmtCate->execute();
    $rowsCate = $stmtCate->fetchAll(PDO::FETCH_ASSOC);

    // 2. 設定查詢條件與參數
    $whereClause = "";
    $params = [];



    // // 3. 撈取 products 及其對應的 categories 資料
    // $sql = "SELECT products.*, categories.name AS category_name
    //         FROM products 
    //         JOIN categories ON products.category_id = categories.id
    //         $whereClause
    //         ORDER BY products.id ASC";
    // $stmt = $db_host->prepare($sql);
    // $stmt->execute($params);
    // $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $productCount = $stmt->rowCount();

    // //4. 撈取 product_images的url
    // $sqlImage = "SELECT product_id, url FROM product_images WHERE sortOrder = 0 "; //sortOrder=0代表他是主圖
    // $stmtImage = $db_host->prepare($sqlImage);
    // $stmtImage->execute();

    // $imageRows = $stmtImage->fetchAll(PDO::FETCH_ASSOC);

    //不撈到軟刪除狀態的資料
    // 如果 $whereClause 是空的，就給它一個預設的 "WHERE" 條件
    if (empty($whereClause)) {
        $whereClause = "WHERE products.deleteAt IS NULL";
    } else {
        // 若已有條件，則在原有條件後面再加上 AND 條件
        $whereClause .= " AND products.deleteAt IS NULL";
    }

    // 處理價格篩選
    if (isset($_GET["min"]) && isset($_GET["max"]) && $_GET["min"] !== "" && $_GET["max"] !== "") {
        $min = (int)$_GET["min"];
        $max = (int)$_GET["max"];
        // 由於$whereClause目前一定有WHERE，所以直接加上 AND 條件
        $whereClause .= " AND products.price BETWEEN :min AND :max";
        $params[":min"] = $min;
        $params[":max"] = $max;
    }

    // //category 男女款篩選 撈出gender對應資料 這個作法是錯誤的 全部註解起來
    // // 判斷是否有指定 category 篩選
    // if (isset($_GET['category'])) {
    //     $categoryId = intval($_GET['category']);

    //     $maleFilterMapping = [
    //         4  => 3,   // 4 表示滑雪外套男款，對應產品類型 3 (滑雪外套)
    //         7  => 6,   // 7 表示滑雪褲男款，對應產品類型 6 (滑雪褲)
    //         10 => 9,   // 10 表示雪鞋男款，對應產品類型 9 (雪鞋)
    //         15 => 13   // 15 表示單板男款，對應產品類型 13 (單板)
    //     ];

    //     $femaleFilterMapping = [
    //         5  => 3,   // 5 表示滑雪外套女款，對應產品類型 3
    //         8  => 6,   // 9 表示滑雪褲女款，對應產品類型 6
    //         11 => 9,   // 13 表示雪鞋女款，對應產品類型 10
    //         16 => 14   // 16 表示單板女款，對應產品類型 13 (單板)
    //     ];

    //     // 定義需要進行性別篩選的分類 id 陣列
    //     $maleCategories   = [4, 7, 10, 15];   // 分別對應滑雪外套、滑雪褲、雪鞋的男款篩選分類 id
    //     $femaleCategories = [5, 8, 11, 16];   // 分別對應滑雪外套、滑雪褲、雪鞋的女款篩選分類 id

    //     if (in_array($categoryId, $maleCategories)) {
    //         // 當選擇男款篩選時，撈出 gender 為男款 (1) 或 男女通用 (3) 的商品
    //         // 並且限制產品類型為對應的產品類型
    //         $productTypeId = $maleFilterMapping[$categoryId];
    //         $whereClause .= " AND (products.gender = 1 OR products.gender = 3) AND products.category_id = " . $productTypeId;
    //     } elseif (in_array($categoryId, $femaleCategories)) {
    //         // 當選擇女款篩選時，撈出 gender 為女款 (2) 或 男女通用 (3) 的商品
    //         // 並且限制產品類型為對應的產品類型
    //         $productTypeId = $femaleFilterMapping[$categoryId];
    //         $whereClause .= " AND (products.gender = 2 OR products.gender = 3) AND products.category_id = " . $productTypeId;
    //     } else {
    //         // 如果傳入的 category 不屬於需要性別篩選的分類，
    //         // 假設該 category 為產品類型分類，則直接依據產品的 category_id 來篩選
    //         $whereClause .= " AND products.category_id = " . $categoryId;
    //     }
    // }

    /**
     * 取得指定父類別下符合性別條件的細分類ID
     *
     * @param int   $parentId       父類別ID（代表產品線）
     * @param array $categories     所有分類陣列
     * @param int   $targetGender   目標性別（1 表示男款，2 表示女款），如果目標是男款則也包含 3 (男女通用)
     * @return array 篩選後的分類ID陣列
     */
    // 根據 parentId 和目標性別，回傳符合條件的子分類 ID
    // 例如：
    // - 選擇「男款」，則包含「男款 (1) + 男女通用 (3)」
    // - 選擇「女款」，則包含「女款 (2) + 男女通用 (3)」
    // 取得符合性別條件的分類 ID（僅限直接子分類）
    function getFilteredCategoryIds($parentId, $categories, $targetGender)
    {
        $result = [];
        foreach ($categories as $cat) {
            if ($cat['parentId'] == $parentId) { // 只篩選「直接子分類」
                // 若目標性別為男款（1），則接受「男款（1）+ 男女通用（3）」
                if ($targetGender == 1 && in_array($cat['gender'], [1, 3])) {
                    $result[] = $cat['id'];
                }
                // 若目標性別為女款（2），則接受「女款（2）+ 男女通用（3）」
                elseif ($targetGender == 2 && in_array($cat['gender'], [2, 3])) {
                    $result[] = $cat['id'];
                }
            }
        }
        return $result; // 回傳符合條件的分類 ID 陣列
    }

    // 取得所有子分類 ID（遞迴處理所有層級）
    function getAllSubCategoryIds($parentId, $categories)
    {
        $result = [];
        foreach ($categories as $cat) {
            if ($cat['parentId'] == $parentId) {
                $result[] = $cat['id']; // 加入該分類 ID
                // 遞迴取得子分類的子分類
                $result = array_merge($result, getAllSubCategoryIds($cat['id'], $categories));
            }
        }
        return $result; // 回傳該分類下所有層級的子分類 ID
    }

    // 取得 URL 參數中的 `category` 值，轉成整數
    $selectedCategoryId = isset($_GET['category']) ? intval($_GET['category']) : null;

    if ($selectedCategoryId === null) {
        $whereClause .= ""; // 若未選擇分類，顯示所有商品
    } else {
        $selectedCategory = null;
        foreach ($rowsCate as $cat) {
            if ($cat['id'] == $selectedCategoryId) {
                $selectedCategory = $cat; // 找到對應的分類資料
                break;
            }
        }

        $filterCategoryIds = []; // 存放要篩選的分類 ID

        if ($selectedCategory) {
            $parentId = $selectedCategory['parentId']; // 取得該分類的父分類 ID

            if ($selectedCategory['gender'] == 0) {
                // **情況 1：若該分類無性別區分，取得「所有子分類」（多層級）**
                $filterCategoryIds = getAllSubCategoryIds($selectedCategory['id'], $rowsCate);

                // **包含自身分類，以確保該分類內的商品也被篩選出來**
                $filterCategoryIds[] = $selectedCategory['id'];
            } elseif (in_array($selectedCategory['gender'], [1, 2])) {
                // **情況 2：該分類為男款（1）或女款（2），則取得符合性別條件的分類**
                $targetGender = $selectedCategory['gender'];
                $filterCategoryIds = getFilteredCategoryIds($parentId, $rowsCate, $targetGender);
            } else {
                // **情況 3：其他分類，僅篩選該分類本身**
                $filterCategoryIds[] = $selectedCategory['id'];
            }
        }

        if (!empty($filterCategoryIds)) {
            $ids = implode(',', $filterCategoryIds); // 將分類 ID 陣列轉為 SQL 查詢字串
            $whereClause .= " AND products.category_id IN ($ids)";
        } else {
            $whereClause .= " AND products.category_id IN (0)"; // 確保 SQL 不會出錯
        }
    }


    // 檢查是否有搜尋關鍵字
    if (isset($_GET["search"]) && trim($_GET["search"]) !== "") {
        $keyword = trim($_GET["search"]);
        // 判斷 $whereClause 是否已經有 "WHERE"
        if (strpos($whereClause, "WHERE") === false) {
            $whereClause = "WHERE products.name LIKE :search";
        } else {
            $whereClause .= " AND products.name LIKE :search";
        }
        $params[":search"] = "%" . $keyword . "%";
    }



    function getDescendantCategories($db, $parentId)
    {
        $stmt = $db->prepare("SELECT id FROM categories WHERE parentId = ?");
        $stmt->execute([$parentId]);
        $children = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $all = [];
        foreach ($children as $child) {
            $all[] = $child;
            $descendants = getDescendantCategories($db, $child);
            $all = array_merge($all, $descendants);
        }
        return $all;
    }


    // 預設：撈取所有商品的尺寸
    $sqlSizes = "SELECT DISTINCT specValue FROM product_specs WHERE specName = '尺寸' ORDER BY specValue ASC";
    $paramsSizes = [];

    if (!empty($_GET['category'])) { // 如果有分類篩選
        $categoryId = (int)$_GET['category'];

        // 取得該分類及其子分類的所有 ID
        $allCategories = [$categoryId]; // 包含自身分類
        $descendants = getDescendantCategories($db_host, $categoryId);
        $allCategories = array_merge($allCategories, $descendants);

        // 建立 IN 條件
        $placeholders = [];
        $paramsSizes = [];

        foreach ($allCategories as $i => $catId) {
            $placeholder = ":category" . $i;
            $placeholders[] = $placeholder;
            $paramsSizes[$placeholder] = $catId;
        }

        $sqlSizes = "SELECT DISTINCT ps.specValue 
                 FROM product_specs ps
                 JOIN products p ON ps.product_id = p.id
                 WHERE ps.specName = '尺寸'
                   AND p.category_id IN (" . implode(',', $placeholders) . ")
                   AND p.deleteAt IS NULL
                 ORDER BY ps.specValue ASC";
    }

    // 執行查詢
    $stmtSizes = $db_host->prepare($sqlSizes);
    $stmtSizes->execute($paramsSizes);
    $sizes = $stmtSizes->fetchAll(PDO::FETCH_COLUMN);



    //實際商品尺寸篩選部分
    // **尺寸篩選（如果有）**
    if (!empty($_GET['size']) && is_array($_GET['size'])) {
        $sizePlaceholders = [];
        foreach ($_GET['size'] as $index => $size) {
            $placeholder = ":size" . $index;
            $sizePlaceholders[] = $placeholder;
            $params[$placeholder] = $size;
        }

        // 透過 JOIN product_specs 來篩選尺寸
        $whereClause .= " AND products.id IN (
        SELECT DISTINCT product_id FROM product_specs 
        WHERE specName = '尺寸' 
        AND specValue IN (" . implode(',', $sizePlaceholders) . ")
    )";
    }




    //先查商品總數
    $countSql = "SELECT COUNT(*) AS total FROM products $whereClause";
    $countStmt = $db_host->prepare($countSql);
    $countStmt->execute($params);
    $productCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total']; //獲得未經篩選過的商品總數

    //商品分頁
    $perPage = 8;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $perPage;
    $totalPages = ceil($productCount / $perPage);


    //排序處理
    // 取得 GET 參數，並設定允許的值
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $order = isset($_GET['order']) ? $_GET['order'] : 'asc';

    $allowedSort = ['price', 'time', 'status'];
    $allowedOrder = ['asc', 'desc'];

    if (!in_array($sort, $allowedSort)) {
        $sort = '';
    }
    if (!in_array($order, $allowedOrder)) {
        $order = 'asc';
    }

    // 依據排序參數來決定 ORDER BY 子句
    if ($sort === 'price') {
        // 假設 products.price 存放價格
        $orderByClause = "ORDER BY products.price $order, products.id ASC";
    } elseif ($sort === 'time') {
        // 假設 products.createdAt 存放上架時間/新增時間
        $orderByClause = "ORDER BY products.publishAt $order, products.id ASC";
    } elseif ($sort === 'status') {
        if ($sort === 'status') {
            // 用 CASE 計算商品狀態
            // 0 = 未上架, 1 = 上架中, 2 = 下架
            $statusCase = "CASE 
                WHEN products.deleteAt IS NOT NULL THEN 2 
                WHEN products.unpublishAt IS NOT NULL AND NOW() >= products.unpublishAt THEN 2 
                WHEN products.publishAt IS NULL OR NOW() < products.publishAt THEN 0 
                ELSE 1 
            END";

            // 接下來，我們根據排序方向，設定一個排序鍵：
            // 若 order = asc，則將上架中的商品（狀態 1）排在前面。
            // 我們可以用 CASE WHEN ($statusCase) = 1 THEN 0 ELSE 1 END，
            // 這樣上架中的商品得到 0，其他商品得到 1。
            // 若 order = desc，則反之。
            if ($order === 'asc') {
                $orderByClause = "ORDER BY (CASE WHEN ($statusCase) = 1 THEN 0 ELSE 1 END) ASC, products.id ASC";
            } else {
                $orderByClause = "ORDER BY (CASE WHEN ($statusCase) = 1 THEN 0 ELSE 1 END) DESC, products.id ASC";
            }
        }
    } else {
        $orderByClause = "ORDER BY products.id ASC";
    }


    //3+4合併
    $sql = "SELECT 
            products.*, 
            categories.name AS category_name, 
            product_images.url AS image_url
        FROM products
        JOIN categories ON products.category_id = categories.id
        LEFT JOIN product_images 
            ON product_images.product_id = products.id 
            AND product_images.sortOrder = 0
            AND product_images.valid = 1
        $whereClause
        $orderByClause
        LIMIT " . (int)$perPage . " OFFSET " . (int)$offset;
    //product_images用LEFT JOIN是為了讓商品完全沒有圖時 他不會整個card都不顯示(商品的其他資訊都不抓) 而是card有顯示但圖沒抓到是死圖


    $stmt = $db_host->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //$productCount = $stmt->rowCount();


    //  echo "<pre>";
    //  print_r($rows);
    //  echo "</pre>";




} catch (PDOException $e) {
    echo "錯誤：" . $e->getMessage();
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>後台商品管理</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>
    <style>
        .subCategory_a {
            font-size: 0.625rem;
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

        <div class="d-flex flex-row w-100 ">
            <?php include("./new_side_mod.php"); ?>

            <div class="container-fluid d-flex flex-column p-5 myPage">


                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success fade show d-flex justify-content-center" id="success-message" role="alert">
                        <?= htmlspecialchars($_SESSION['message']); ?> <span class="d-inline-block ms-3" id="countdown">5秒後訊息自動關閉</span>
                    </div>
                <?php unset($_SESSION['message']);
                endif; ?>
                <div class="py-2 d-flex">

                    <ul class="nav nav-underline">
                        <li class="nav-item">
                            <a class="nav-link <?php if (!isset($_GET["category"])) echo "active"; ?>" aria-current="page" href="product-list.php">全部</a>
                        </li>

                        <?php
                        // 定義一個遞迴函數來處理子分類
                        function renderCategory($parentId, $rowsCate)
                        {
                            foreach ($rowsCate as $category) {
                                if ($category["parentId"] == $parentId) {
                                    // 判斷該分類是否被選中
                                    $isActive = (isset($_GET["category"]) && $_GET["category"] == $category["id"]) ? "active" : "";

                                    // 判斷是否選中該分類或其子分類
                                    $isExpanded = isset($_GET["category"]) && (isCategoryOrDescendantSelected($category["id"], $_GET["category"], $rowsCate)) ? 'block' : 'none';
                        ?>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex justify-content-center <?= $isActive ?>" href="product-list.php?category=<?= $category["id"] ?>">
                                            <?= $category["name"] ?>
                                        </a>

                                        <?php
                                        // 當前分類是否被選中或其子分類被選中，若是則顯示它的子分類
                                        if ($isExpanded === 'block') {
                                        ?>
                                            <ul class="list-unstyled" style="display: <?= $isExpanded ?>;">
                                                <?php renderCategory($category["id"], $rowsCate); ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                        <?php
                                }
                            }
                        }

                        // 檢查是否選中某個分類或其子分類
                        function isCategoryOrDescendantSelected($parentId, $selectedCategoryId, $rowsCate)
                        {
                            if ($parentId == $selectedCategoryId) {
                                return true;  // 如果是選中的分類，直接返回 true
                            }

                            // 如果不是選中的分類，檢查是否有子分類被選中
                            foreach ($rowsCate as $category) {
                                if ($category["parentId"] == $parentId) {
                                    if (isCategoryOrDescendantSelected($category["id"], $selectedCategoryId, $rowsCate)) {
                                        return true;  // 如果有某個子分類被選中，則返回 true
                                    }
                                }
                            }

                            return false;
                        }

                        // 呼叫函數，從根分類開始渲染
                        renderCategory(1, $rowsCate);
                        ?>
                    </ul>







                </div>
                <div class="py-2 d-flex justify-content-between">
                    <form action="product-list.php" method="GET">
                        <!-- 當有其他篩選條件時，保留它們 -->
                        <?php if (isset($_GET["category"])): ?>
                            <input type="hidden" name="category" value="<?= htmlspecialchars($_GET["category"]) ?>">
                        <?php endif; ?>

                        <div class="row g-3 align-items-center">
                            <?php if (isset($_GET["min"])): ?>
                                <div class="col-auto">
                                    <a class="btn btn-primary" href="product-list.php">
                                        <i class="fa-solid fa-arrow-left fa-fw"></i>取消所有篩選
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="col-auto">
                                <?php $min = $_GET["min"] ?? 0; ?>
                                <input type="number" class="form-control text-end" name="min"
                                    value="<?= htmlspecialchars($min) ?>" min="0">
                            </div>

                            <div class="col-auto">~</div>

                            <div class="col-auto">
                                <?php $max = $_GET["max"] ?? 0; ?>
                                <input type="number" class="form-control text-end" name="max"
                                    value="<?= htmlspecialchars($max) ?>" min="0">
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa-solid fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- 商品搜尋功能 -->
                    <form action="product-list.php" method="GET">
                        <!-- 保留其他篩選參數 -->
                        <?php if (isset($_GET["category"])): ?>
                            <input type="hidden" name="category" value="<?= htmlspecialchars($_GET["category"]) ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET["min"])): ?>
                            <input type="hidden" name="min" value="<?= htmlspecialchars($_GET["min"]) ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET["max"])): ?>
                            <input type="hidden" name="max" value="<?= htmlspecialchars($_GET["max"]) ?>">
                        <?php endif; ?>

                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <input type="text" class="form-control" name="search"
                                    placeholder="搜尋商品名稱"
                                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-search"></i> 搜尋</button>
                            </div>
                        </div>
                    </form>






                </div>
                <div class="py-2 d-flex justify-content-between">
                    <span style="color:white;">共 <?= $productCount ?> 項商品</span>


                    <?php
                    // 複製現有的 GET 參數
                    $queryParams = $_GET;

                    // 定義一個輔助函式來生成連結
                    function sortLink($field, $currentSort, $currentOrder, $queryParams)
                    {
                        // 如果目前的排序欄位就是 $field，則切換 order
                        if ($currentSort === $field) {
                            $newOrder = ($currentOrder === 'asc') ? 'desc' : 'asc';
                        } else {
                            // 如果切換到另一個排序欄位，預設使用 asc
                            $newOrder = 'asc';
                        }
                        $queryParams['sort'] = $field;
                        $queryParams['order'] = $newOrder;
                        return 'product-list.php?' . http_build_query($queryParams);
                    }

                    // 取消排序用
                    function cancelSortLink($queryParams)
                    {
                        // 從現有參數中移除排序相關的鍵值
                        unset($queryParams['sort'], $queryParams['order']);
                        return 'product-list.php?' . http_build_query($queryParams);
                    }
                    ?>
                    <div class="btn-group" role="group">
                        <!-- 價格排序按鈕 -->
                        <a href="<?= sortLink('price', $sort, $order, $queryParams) ?>" class="btn btn-outline-primary <?= ($sort === 'price') ? 'active' : '' ?>">價格排序
                            <?php if ($sort === 'price'): ?>
                                <?= ($order === 'asc')
                                    ? "<i class='fa-solid fa-arrow-up fa-fw'></i>"
                                    : "<i class='fa-solid fa-arrow-down fa-fw'></i>" ?>
                            <?php endif; ?>
                        </a>
                        <!-- 時間排序按鈕 -->
                        <a href="<?= sortLink('time', $sort, $order, $queryParams) ?>" class="btn btn-outline-primary <?= ($sort === 'time') ? 'active' : '' ?>">上架時間排序
                            <?php if ($sort === 'time'): ?>
                                <?= ($order === 'asc')
                                    ? "<i class='fa-solid fa-arrow-up fa-fw'></i>"
                                    : "<i class='fa-solid fa-arrow-down fa-fw'></i>" ?>
                            <?php endif; ?>
                        </a>
                        <!-- 上架狀態排序按鈕 -->
                        <a href="<?= sortLink('status', $sort, $order, $queryParams) ?>" class="btn btn-outline-primary <?= ($sort === 'status') ? 'active' : '' ?>">上架狀態排序
                            <?php if ($sort === 'status'): ?>
                                <?= ($order === 'asc')
                                    ? "<i class='fa-solid fa-arrow-up fa-fw'></i>"
                                    : "<i class='fa-solid fa-arrow-down fa-fw'></i>" ?>
                            <?php endif; ?>
                        </a>
                        <!-- 取消排序按鈕(回到預設排序) -->
                        <a href="<?= cancelSortLink($queryParams) ?>" class="btn btn-outline-secondary">取消排序</a>
                    </div>
                </div>
                <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3 product-list">
                    <?php foreach ($rows as $product): ?>

                        <?php
                        // echo "<pre>";
                        // print_r($product);
                        // echo "</pre>";
                        $productStatus = getProductStatus($product); //取得商品的未上架0 上架1 下架2 軟刪除3 狀態
                        $now = new DateTime(); //取得目前時間


                        $productStatusString = ""; //商品的"未上架" "上架中" "下架中" 字串型態
                        $statusBG = ""; //放在顯示上下架狀態UI的class內 不同的狀態下 背景顏色不一樣 bootstrap 5

                        switch ($productStatus) { //3軟刪除的時候網頁本來就不會顯示這筆資料
                            case 0:
                                $productStatusString = "未上架";
                                $statusBG = "text-bg-secondary";
                                break;
                            case 1:
                                $productStatusString = "上架中";
                                $statusBG = "text-bg-success";
                                break;
                            case 2:
                                $productStatusString = "下架中";
                                $statusBG = "text-bg-danger";
                                break;
                            default:
                                # code...
                                break;
                        }

                        ?>

                        <div class="col">
                            <div class="card h-100 overflow-hidden" style="opacity:0.9;">
                                <!-- card設定 h-100就能讓卡片都跟col一樣高 不會因為特定商品名稱比較長所以比較高 這是把其他文字不長所以不高的也強制拉到跟大家一樣高-->

                                <span class="mb-3 badge rounded-pill <?= $statusBG; ?>"><?= $productStatusString ?></span>

                                <!-- 原本是a連結 連到該商品的前台商品頁面 但我沒有做前台 所以暫時讓他連到編輯頁面 -->
                                <a class="text-decoration-none link-dark d-block" href="edit-product.php?id=<?= $product['id']; ?>">
                                    <div class="ratio ratio-4x3 overflow-hidden">
                                        <img class="object-fit-contain" src="<?= $product["image_url"]; ?>" alt="">

                                    </div>
                                </a>

                                <div class="card-body">
                                    <div><a class="text-decoration-none" href="product-list.php?category=<?= $product["category_id"] ?>"><?= $product["category_name"] ?></a></div>

                                    <h3 class="h4"><a class="text-decoration-none link-dark" href="edit-product.php?id=<?= $product['id']; ?>?>"><?= $product["name"] ?></a></h3>
                                    <div class="text-danger text-end fs-5 fw-bold">$<?php echo number_format($product["price"]) //加千分位 
                                                                                    ?>
                                    </div>


                                    <div class="d-flex justify-content-center py-2">
                                        <form method="POST" action="update_product.php">
                                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                            <input type="hidden" name="action" value="publish">
                                            <?php if ($productStatus != 1): ?>
                                                <button type="submit" class="btn btn-primary mx-2">
                                                    <i class="fa-solid fa-arrow-up-from-bracket"></i> 上架
                                                </button>
                                            <?php endif; ?>
                                        </form>

                                        <?php if ($productStatus != 1): ?>
                                            <a href="edit-product.php?id=<?= $product['id']; ?>" class="btn btn-secondary mx-2">
                                                <i class="fa-solid fa-pen-to-square"></i> 編輯
                                            </a>
                                        <?php endif; ?>

                                        <form method="POST" action="update_product.php">
                                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                            <input type="hidden" name="action" value="unpublish">
                                            <?php if ($productStatus == 1): ?>
                                                <button type="submit" class="btn btn-warning mx-2">
                                                    <i class="fa-solid fa-arrow-down"></i> 下架
                                                </button>
                                            <?php endif; ?>
                                        </form>

                                        <form method="POST" action="update_product.php">
                                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <?php if ($productStatus != 1): ?>
                                                <button type="submit" class="btn btn-danger mx-2 <?php if ($productStatus == 1) {
                                                                                                        echo "disabled";
                                                                                                    } ?>">
                                                    <i class="fa-solid fa-xmark"></i> 刪除
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>


                <nav>
                    <ul class="pagination py-3">
                        <?php
                        // 保留 category 參數
                        $queryString = http_build_query(array_merge($_GET, ["page" => $page - 1]));
                        ?>
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="product-list.php?<?= $queryString ?>">上一頁</a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php
                            $queryString = http_build_query(array_merge($_GET, ["page" => $i]));
                            ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="product-list.php?<?= $queryString ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php
                        $queryString = http_build_query(array_merge($_GET, ["page" => $page + 1]));
                        ?>
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="product-list.php?<?= $queryString ?>">下一頁</a>
                        </li>
                    </ul>
                </nav>

                <div class="py-3">
                    <!-- 尺寸篩選區 -->
                    <form action="product-list.php" method="GET">
                        <!-- 保留其他篩選條件 -->
                        <?php foreach ($_GET as $key => $value) {
                            if ($key !== 'size') {
                                if (is_array($value)) {
                                    foreach ($value as $v) {
                                        echo '<input type="hidden" name="' . htmlspecialchars($key) . '[]" value="' . htmlspecialchars($v) . '">';
                                    }
                                } else {
                                    echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                                }
                            }
                        } ?>

                        <!-- 因為篩選條件不小心保留到page了 會導致篩選完後不會回到第一頁 這邊先強制設定 page 為 1 -->
                    <input type="hidden" name="page" value="1">

                        <div class="btn-group d-flex flex-wrap" role="group">
                            <?php foreach ($sizes as $size): ?>
                                <?php $isChecked = isset($_GET['size']) && in_array($size, (array)$_GET['size']); ?>
                                <input type="checkbox" class="btn-check" id="size-<?= $size ?>" name="size[]" value="<?= htmlspecialchars($size) ?>" <?= $isChecked ? 'checked' : '' ?>>
                                <label class="btn btn-outline-primary m-2" for="size-<?= $size ?>"><?= htmlspecialchars($size) ?></label>
                            <?php endforeach; ?>
                        </div>

                        <button class="btn btn-primary" type="submit">篩選</button>
                    </form>
                </div>

            </div>

            <?php //include("./footer_mod.php")
            ?>
        </div>


    </div>


    <?php include("./js.php") ?>
    <script>
        //商品上下架成功訊息 倒數完自動消失
        let countdown = 5;
        let countdownElement = document.getElementById("countdown");
        let messageElement = document.getElementById("success-message");

        let timer = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown + "秒後訊息自動關閉";

            if (countdown <= 0) {
                clearInterval(timer);
                bootstrap.Alert.getOrCreateInstance(messageElement).close(); // Bootstrap 內建方法關閉訊息
            }
        }, 1000);
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