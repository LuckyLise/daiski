<!doctype html>
<html lang="en">

<head>
    <title>Create Coupon</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>

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

            <div class="container myPage">
                <div class="py-2">
                    <a href="coupons.php" class="btn btn-primary">優惠卷清單</a>
                </div>
                <form action="doCreate.php" method="post">
                    <div class="mb-2">
                        <label for="name" class="form-lable">優惠卷名稱</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-2">
                        <label for="code" class="form-lable">代碼</label>
                        <input type="text" class="form-control" name="code" id="code" readonly required>
                        <button id="uuidCode" class="btn btn-primary" type="button">自動生成代碼</button>
                    </div>
                    <div class="mb-2">
                        <label for="coupon_type" class="form-lable">種類</label>
                        <select class="form-select" id="coupon_type" name="coupon_type" required>
                            <option value="現金">現金折扣</option>
                            <option value="百分比折扣">百分比折扣</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="coupon_amount" class="form-lable">折扣數</label>
                        <input type="text" class="form-control" name="coupon_amount" id="coupon_amount" required>
                    </div>
                    <div class="mb-2">
                        <label for="coupon_target" class="form-lable">折扣對象</label>
                        <select class="form-select" id="coupon_target" name="coupon_target" required>
                            <option value="課程">課程</option>
                            <option value="商品">商品</option>
                            <option value="全站">全站</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="startAt" class="form-lable">開始日期</label>
                        <input type="date" class="form-control" name="startAt" id="startAt" required>
                    </div>
                    <div class="mb-2">
                        <label for="endAt" class="form-lable">結束日期</label>
                        <input type="date" class="form-control" name="endAt" id="endAt" required>
                    </div>
                    <div class="mb-2">
                        <label for="usageLimit" class="form-lable">可領取次數</label>
                        <input type="text" class="form-control" name="usageLimit" id="usageLimit" required>
                    </div>
                    <div class="mb-2">
                        <label for="minPurchase" class="form-lable">最低消費額</label>
                        <input type="text" class="form-control" name="minPurchase" id="minPurchase" required>
                    </div>
                    <button class="btn btn-primary" type="submit" id="submit">送出</button>

                </form>
            </div>
        </div>
    </div>

    <?php include("./js.php"); ?>
    <script>
        const uuidCode = document.querySelector("#uuidCode")
        const code = document.querySelector("#code")

        $("#uuidCode").click(function() {
            $.ajax({
                url: "uuid-test.php",
                type: "GET",
                success: function(respones) {
                    // $("#code").readonly = true;
                    $("#code").val(respones);
                },
                error: function() {
                    alert("發生錯誤");
                }
            });
        });

        // $("#submit").click(function(){
        //     $("#code").disabled = true;
        // });
    </script>
</body>

</html>