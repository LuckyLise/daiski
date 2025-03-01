<!doctype html>
<html lang="en">

<head>
    <title>Sign Up</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="mt-3">
                    <form action="doSignUp.php" method="post">
                        <div class="mb-2">
                            <label for="" class="form-label">帳號</label>
                            <input type="text" class="form-control" name="account"
                            required
                            minlength="4" maxlength="20"
                            >
                            <div class="form-text">請輸入4~20字元的帳號</div>
                        </div>
                        <div class="mb-2">
                            <label for="" class="form-label">密碼</label>
                            <input type="password" class="form-control" name="password" required
                            minlength="4" maxlength="20"
                            >
                            <div class="form-text">請輸入4~20字元的密碼</div>
                        </div>
                        <div class="mb-2">
                            <label for="" class="form-label">確認密碼</label>
                            <input type="password" class="form-control" name="repassword" required
                            minlength="4" maxlength="20"
                            >
                        </div>
                        <button class="btn btn-primary" type="submit">送出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>