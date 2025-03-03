<!doctype html>
<html lang="en">

<head>
    <title>Create coach</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <?php include("./css.php") ?>
    <style>
        body{
            color: white !important;
            th{
                color: white !important;
            }
            td{
                color: white !important;
            }
        }
    </style>
</head>

<body>

    <div class="d-flex flex-column">
        <?php include("./new_head_mod.php") ?>
        <div class="d-flex flex-row w-100 myPage">
            <?php include("./new_side_mod.php") ?>

            <div class="container">
                <div class="py-2">
                    <a href="coaches.php" class="btn btn-primary"><i class="fa-solid fa-tent-arrow-turn-left"> 教練列表</i>
                    </a>
                </div>
                <form action="doCreate.php" class="" method="post" enctype="multipart/form-data" id="myForm">
                    <div class="mb-2">
                        <label for="name" class="form-label">
                            姓名
                        </label><input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">
                            email
                        </label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-2">
                        <label for="bio" class="form-label">
                            自我介紹
                        </label>
                        <textarea type="text" class="form-control" id="bio" name="bio" required></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="experience" class="form-label">
                            經歷
                        </label>
                        <textarea type="text" class="form-control" id="experience" name="experience" required></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="language" class="form-label">
                            教學語言
                        </label>
                        <div id="languageError" style="color: gray; display: block;">
                            *請至少選擇一種語言
                        </div>
                        <div class="form-check">
                            <input class="form-check-input mustcheck" type="checkbox" id="flexCheckChecked" name="language[]" value="中文">
                            <label class="form-check-label" for="flexCheckChecked">
                                中文
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input mustcheck" type="checkbox" id="flexCheckChecked" name="language[]" value="英文">
                            <label class="form-check-label" for="flexCheckChecked">
                                英文
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="日文">
                            <label class="form-check-label" for="flexCheckChecked">
                                日文
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="韓文">
                            <label class="form-check-label" for="flexCheckChecked">
                                韓文
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="粵語">
                            <label class="form-check-label" for="flexCheckChecked">
                                粵語
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="台語">
                            <label class="form-check-label" for="flexCheckChecked">
                                台語
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">證照</label>
                        <div class="row g-3">
                            <div class="col-4">
                                <input type="" class="form-control" name="license[]" required>
                            </div>
                            <div class="col-4">
                                <input type="" class="form-control" name="license[]">
                            </div>
                            <div class="col-4">
                                <input type="" class="form-control" name="license[]">
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="image" class="form-label">選取檔案</label>
                        <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png" required>
                    </div>
                    <button class="btn btn-primary" type="submit">送出</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script>
        const mustcheck = document.querySelectorAll(".mustcheck");
        for (let i = 0; i < mustcheck.length; i++)
            mustcheck[i].addEventListener("click", function() {
                console.log(mustcheck[i].checked);
            })
    </script>
    <script>
        document.getElementById("myForm").addEventListener("submit", function(event) {
            let checkboxes = document.querySelectorAll('input[name="language[]"]:checked');
            if (checkboxes.length === 0) {
                alert("請至少選擇一個");
                event.preventDefault(); // 阻止表單提交
            }
        });
    </script>
    <?php include("./js.php") ?>
</body>

</html>