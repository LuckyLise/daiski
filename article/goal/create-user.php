<!doctype html>
<!-- 建立表單，按下"送出"按鈕後，將表單資料以"post"形式送給doCreate.php -->
 
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <? include("../css.php")?>
    </head>

    <body>
        <div class="container">
            <div class="py-2">
                <a class="btn btn-primary" href="users2.php"><i class="fa-solid fa-list fa-fw"></i>使用者列表</a>
            </div>
            <form action="doCreate.php" method="post">
                <div class="mb-2">
                    <label for="name" class="form-label">姓名</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="mb-2">
                    <label for="phone" class="form-label">電話</label>
                    <input type="tel" class="form-control" name="phone" id="phone">
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label">email</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <button class="btn btn-primary" type="submit">送出</button>
            </form>
        </div>





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
