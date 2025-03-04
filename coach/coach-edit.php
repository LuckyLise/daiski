<?php
if (isset($_GET["id"])) {
}

$id = $_GET["id"];

require_once("../pdo_connect.php");

$sql = "SELECT coach .*
FROM coach
WHERE coach.id = $id AND valid=1
";

try {
    $stmt = $db_host->prepare($sql);
    $stmt->execute();
} catch (PDOException $e) {
    echo "錯誤訊息！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}
$row = $stmt->fetch();

$sql = "SELECT language.name 
FROM language_coach
JOIN language ON language_coach.language_id = language.id
WHERE language_coach.coach_id = $id
";
try {
    $stmt = $db_host->prepare($sql);
    $stmt->execute();
    $lan = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($lan);
} catch (PDOException $e) {
    echo "錯誤訊息！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

$sql = "SELECT license.name
FROM license_coach
JOIN license ON license_coach.license_id = license.id
WHERE license_coach.coach_id = $id
";

try {
    $stmt = $db_host->prepare($sql);
    $stmt->execute();
    $licenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($licenses);
} catch (PDOException $e) {
    echo "錯誤訊息！<br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

// 取出已選擇的語言，並放入一個陣列中
$selectedLanguages = array_map(function ($lan) {
    return $lan['name'];
}, $lan);
?>
<!doctype html>
<html lang="en">

<head>
    <title>edit</title>
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
    <style>
        body{
            color: white !important;
            th{
                color: white !important;
            }
            td{
                color: white !important;
            }
            .modal-content{
            color: black;
        }
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
    <?php include("./css.php") ?>
</head>

<body>
<div id="loadingOverlay">
    <div class="spinner"></div>
  </div>

    <div class="modal fade" tabindex="-1" id="infoModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">提示訊息</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="message">刪除教練資訊</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                    <a role="button" class="btn btn-danger" href="coachDelete.php?id=<?= $id ?>">確認刪除</a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column" id="mainContent">
        <?php include("./new_head_mod.php") ?>
        <div class="d-flex flex-row w-100 myPage">
            <?php include("./new_side_mod.php") ?>


            <div class="container">
                <div class="py-2">
                    <a href="coaches.php" class="btn btn-primary"><i class="fa-solid fa-tent-arrow-turn-left fa-fw"></i></a>
                </div>
                <div class="row">
                    <div class="col col-md-9">
                        <form action="doUpdateCoach.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <table class="table table-bordered">
                                <tr>
                                    <th>id</th>
                                    <td><?= $row["id"] ?></td>
                                </tr>
                                <tr>
                                    <th>name</th>
                                    <td>
                                        <input type="text" class="form-control" name="name"
                                            value="<?= $row["name"] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>email</th>
                                    <td><input type="email" class="form-control" name="email"
                                            value="<?= $row["email"] ?>">
                                </tr>
                                <tr>
                                    <th>bio</th>
                                    <td><textarea type="text" class="form-control " name="bio"
                                            value=""><?= $row["bio"] ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>experience</th>
                                    <td>
                                        <textarea type="text" class="form-control" name="experience"
                                            value=""><?= $row["experience"] ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>license</th>
                                    <td>
                                        <?php
                                        // 確保 $licenses 至少有 3 個元素
                                        $licenses = array_pad($licenses, 3, ["name" => ""]);
                                        foreach ($licenses as $license): ?>
                                            <input type="text" class="form-control" name="license[]"
                                                value="<?= htmlspecialchars($license["name"]) ?>"><br>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>language</th>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="中文" <?php echo in_array('中文', $selectedLanguages) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                中文
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="英文" <?php echo in_array('英文', $selectedLanguages) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                英文
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="日文" <?php echo in_array('日文', $selectedLanguages) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                日文
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="韓文" <?php echo in_array('韓文', $selectedLanguages) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                韓文
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="粵語" <?php echo in_array('粵語', $selectedLanguages) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                粵語
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="language[]" value="台語" <?php echo in_array('台語', $selectedLanguages) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                台語
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>profile photo</th>
                                    <td>
                                        <div class="row row-cols-lg-4 rol-cols-mb-3 row-cols-sm-2 row-cols-lg-3">
                                            <div class="col">
                                                <div class="ratio ratio-1x1 mb-3">
                                                    <img src="../coach/images/<?= $row["profilephoto"] ?>" alt="<?= $row["name"] ?>" class="object-fit-cover">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <!-- <label for="image" class="form-label">選取檔案</label> -->
                                            <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>created at</th>
                                    <td><?= $row["createdat"] ?></td>
                                </tr>
                            </table>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk fa-fw"></i>儲存</button>
                                <a data-bs-toggle="modal" data-bs-target="#infoModal" class="btn btn-danger">刪除</a>
                            </div>

                        </form>

                    </div>
                </div>
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
    <?php include("./js.php") ?>
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

        });
    </script> 
</body>

</html>