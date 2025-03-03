<?php
require_once('../daiski/pdo_connect.php');
session_start();
session_destroy();

if(isset($_SESSION["user"])){
    header("location: dashboard.php");
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Sign in</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <style>
        body {
            background: url("./sign-in.jpg") center center / cover;
        }

        .logo {
            height: 48px;
        }

        .login-panel {
            width: 280px;
        }

        .input-area {
            .form-floating {

                /* .form-floating:first-child */
                &:first-child {
                    .form-control {
                        position: relative;
                        border-end-start-radius: 0;
                        border-end-end-radius: 0;
                    }
                }

                &:last-child {
                    .form-control {
                        position: relative;
                        top: -1px;
                        border-top-left-radius: 0;
                        border-top-right-radius: 0;
                    }
                }

                .form-control:focus {
                    z-index: 1;
                }
            }
        }
    </style>
</head>

<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="login-panel">
            <img class="logo mb-2" src="" alt="">
            <h1><i class="fa-regular fa-snowflake fa-fw"></i>Daiski<i class="fa-regular fa-snowflake fa-fw"></i><i class="fa-solid fa-person-snowboarding"></i></h1>
            <h1 class="text-light">Please sign in</h1>
            <?php if(isset($_SESSION["error"]["times"]) && $_SESSION["error"]["times"]>5): ?>
                <div
                    class="alert alert-danger"
                    role="alert"
                >
                    錯誤次數太多, 請稍後再嘗試
                </div>
            <?php else: ?>
            <form action="doLogin.php" method="post">
                <div class="input-area">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingInput" placeholder=""
                            name="account">
                        <label for="floatingInput">Account</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                            name="password">
                        <label for="floatingPassword">Password</label>
                    </div>
                </div>
                <?php if(isset($_SESSION["error"]["message"])): ?>
                <div
                    class="alert alert-danger"
                    role="alert"
                ><?=$_SESSION["error"]["message"]?>
                </div>
                <?php
                unset($_SESSION["error"]["message"]);
                endif; ?>
                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" value="" id="remember">
                    <label class="form-check-label text-light" for="remember">
                        Remember Me
                    </label>
                </div>
                
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Sign in</button>
                </div>
            </form>
            <?php endif; ?>
            <div class="mt-4 text-light">
                © 2017–2024
            </div>

        </div>
    </div>

    <?php include("../js.php") ?>
</body>

</html>