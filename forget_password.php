<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<title>AARC - Forget Password</title>

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

<body>
	<div
		class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<img src="assets/images/forgot-password.png" alt="" />
				</div>
				<div class="col-md-6">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-success">Forgot Password</h2>
						</div>
						<h6 class="mb-20">
							Enter your email address to reset your password
						</h6>
						<form>
							<div class="input-group custom">
								<input
									type="text"
									class="form-control form-control-lg"
									placeholder="Email" />
							</div>
							<div class="row align-items-center">
								<div class="col-5">
									<div class="input-group mb-0">
										<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
										-->
										<a
											class="btn btn-success btn-lg btn-block"
											href="#">Submit</a>
									</div>
								</div>
								<div class="col-2">
									<div
										class="font-16 weight-600 text-center"
										data-color="#707373">
										OR
									</div>
								</div>
								<div class="col-5">
									<div class="input-group mb-0">
										<a
											class="btn btn-outline-success btn-lg btn-block"
											href="login">Login</a>
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

</body>

</html>