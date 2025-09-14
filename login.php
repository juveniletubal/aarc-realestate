<?php
$config = require __DIR__ . "/config/google.php";
$client_id = $config['client_id'];
$redirect_uri = $config['redirect_uri'];
$scope = urlencode("openid email profile");
$response_type = "code";

$url = "https://accounts.google.com/o/oauth2/v2/auth"
    . "?client_id={$client_id}"
    . "&redirect_uri={$redirect_uri}"
    . "&response_type={$response_type}"
    . "&scope={$scope}";
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>AARC - Login</title>

    <link href="assets/img/favicon.webp" rel="icon" />

    <link rel="stylesheet" href="assets/css/fonts.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/core.min.css">
    <link rel="stylesheet" href="assets/css/style.min.css">

</head>

<style>
    body {
        background-color: #F1F6F3;
    }
</style>

<body class="login-page d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-success">Login to AARC</h2>
                    </div>
                    <form>
                        <div class="input-group custom">
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                placeholder="Username" />
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                placeholder="•••••••••" />
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                            </div>
                        </div>
                        <div class="row pb-30">
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <div class="forgot-password">
                                    <a href="forgot-password.html">Forgot Password</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <a
                                        class="btn btn-success btn-lg btn-block"
                                        href="index.html">Sign In</a>
                                </div>
                                <div
                                    class="font-16 weight-600 pt-10 pb-10 text-center"
                                    data-color="#707373">
                                    OR
                                </div>
                                <div class="input-group mb-0">
                                    <a class="btn btn-light btn-lg btn-block border d-flex align-items-center justify-content-center"
                                        href="<?= htmlspecialchars($url) ?>" style="background-color: #fff; border-color: #ddd;">
                                        <img src="https://developers.google.com/identity/images/g-logo.png"
                                            alt="Google" style="width:20px; height:20px; margin-right:10px;">
                                        <span class="text-dark">Sign in with Google</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/script.min.js"></script>
    <script src="assets/js/process.min.js"></script>
    <script src="assets/js/layout-settings.min.js"></script>

    <?php include "config/custom_script/page_load_time.php" ?>

</body>

</html>