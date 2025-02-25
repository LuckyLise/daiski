<!doctype html>
<html lang="en">
    <head>
        <title>Create User</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <?php include("../daiski/css.php") ?>
    </head>

    <body>
        <div class="container">
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
                type="submit"
                >送出</button>
                </div>
            </form>
        </div>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
