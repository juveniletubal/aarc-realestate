<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - YPMS</title>

    <link rel="stylesheet" href="assets/css/fonts.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/core.min.css">
    <link rel="stylesheet" href="assets/css/style.min.css">
</head>

<style>
    body.login-page {
        background: url('assets/img/bg.webp') no-repeat center center fixed;
        background-size: cover;
    }

    body.login-page::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.1);
        z-index: -1;
    }

    .login-header {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(2px);
    }

    .login-menu ul li a {
        color: white;
        text-decoration: none;
        font-size: clamp(14px, 2vw, 18px);
    }

    .login-menu ul li a:hover {
        color: #17a2b8;
    }

    .login-menu ul li a.active {
        color: #17a2b8;
    }

    .brand-title {
        font-size: clamp(18px, 2vw, 22px);
    }

    .outlined-text {
        -webkit-text-stroke: 0.5px #fff;
        font-weight: 900;
    }

    .login-wrap img {
        width: clamp(180px, 30vw, 330px);
        filter: drop-shadow(8px 8px 3px rgba(0, 0, 0, 0.6));
    }

    @media (max-width: 768px) {
        .login-wrap img {
            display: none;
        }
    }

    .login-footer {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(2px);
        padding: 10px 0;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .login-footer #datetime {
        font-size: clamp(12px, 2vw, 16px);
    }


    /* Make the browser scrollbar thinner */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #585858ff;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #17a2b8;
        border-radius: 10px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #0f7585ff;
    }
</style>

<body class="login-page">
    <div class="login-header">
        <div
            class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a>
                    <h3 class="text-white brand-title">
                        <span class="d-inline d-md-none">
                            <b class="text-info outlined-text">YPMS</b>
                        </span>

                        <span class="d-none d-md-inline">
                            <b class="text-info outlined-text">Y</b>outh
                            <b class="text-info outlined-text">P</b>rofiling
                            <b class="text-info outlined-text">M</b>anagement
                            <b class="text-info outlined-text">S</b>ystem
                        </span>
                    </h3>
                </a>
            </div>
            <div class="login-menu">
                <ul class="d-flex list-unstyled">
                    <li class="mx-3"><a href="" class="active">Home</a></li>
                    <li class="mx-3"><a href="about">About Us</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center gap-4">
                <div class="col-md-6 col-lg-7 logo-container">
                    <img src="assets/img/logo.webp" loading="lazy" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-info">WELCOME!</h2>
                        </div>
                        <form>
                            <div class="input-group custom">
                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    placeholder="Username" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="fa fa-user-o"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input
                                    type="password"
                                    class="form-control form-control-lg"
                                    placeholder="•••••••••••" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <a class="btn btn-info btn-lg btn-block"
                                            href="index.html">Sign In</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer class="login-footer mt-auto">
        <div class="container-fluid text-center text-white">
            <span id="datetime"></span>
        </div>
    </footer>



    <script src="assets/js/core.min.js"></script>

    <script>
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('datetime').textContent =
                now.toLocaleDateString('en-US', options);
        }
        setInterval(updateDateTime, 1000);
        updateDateTime(); // initial call
    </script>

    <?php include 'config/custom_script/page_load_time.php'; ?>
</body>

</html>