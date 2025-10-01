<?php
require_once "auth/session.php";

// If session exists (user already logged in), redirect
if (isset($_SESSION['user_id'])) {
	switch ($_SESSION['role']) {
		case 'admin':
			header("Location: admin/");
			break;
		case 'agent':
			header("Location: agent/");
			break;
		default:
			header("Location: client/");
			break;
	}
	exit;
}
?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<title>AARC - Login</title>

	<link href="assets/img/favicon.webp" rel="icon" />

	<link rel="stylesheet" href="assets/css/app.min.css">

</head>

<style>
	body {
		background-color: #E4EBEC;
	}

	.login-wrap {
		min-height: 100vh;
	}
</style>

<body class="login-page">

	<div
		class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="assets/images/login-page-img.png" alt="" />
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title text-center">
							<h4 class="text-success">Ammazeng Angels</h4>
							<p class="text-muted" style="font-size: 17px;">Realty Corporation</p>
						</div>
						<form method="POST" action="auth/login.php">
							<div class="input-group custom">
								<input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required />
							</div>
							<div class="input-group custom">
								<input type="password" name="password" class="form-control form-control-lg" placeholder="•••••••••" required />
							</div>
							<div class="row pb-30">
								<div class="col-6">
								</div>
								<div class="col-6">
									<div class="forgot-password">
										<a href="forget_password">Forgot Password</a>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<button type="submit" class="btn btn-success btn-lg btn-block">Sign In</button>
									</div>
									<div
										class="font-14 weight-600 pt-10 pb-10 text-center"
										data-color="#707373">

									</div>
									<div class="d-flex justify-content-center mb-0">
										<a href="index" class="text-success">Back to Home</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="assets/js/app.min.js"></script>

	<?php include "config/custom_script/page_load_time.php" ?>

	<?php if (isset($_SESSION['error'])): ?>
		<script>
			toastr.options = {
				closeButton: true,
				progressBar: true,
				positionClass: "toast-bottom-right",
				timeOut: "3000"
			};

			toastr.error("<?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>", "Error");
		</script>
	<?php unset($_SESSION['error']);
	endif; ?>

</body>

</html>