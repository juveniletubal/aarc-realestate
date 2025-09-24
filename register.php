<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<title>AARC - Register</title>

	<link href="assets/img/favicon.webp" rel="icon" />

	<link rel="stylesheet" href="assets/css/app.min.css">
	<link rel="stylesheet" href="assets/css/jquery.steps.css">

</head>

<style>
	/* body {
		background-color: #F1F6F3;
	} */

	.register-page-wrap {
		min-height: 100vh;
	}
</style>

<body class="login-page">
	<div
		class="register-page-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="assets/images/register-page-img.png" alt="" />
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="register-box bg-white box-shadow border-radius-10">
						<div class="wizard-content">
							<form class="tab-wizard2 wizard-circle wizard">
								<h5>Basic Account Credentials</h5>
								<section>
									<div class="form-wrap max-width-600 mx-auto">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Email Address<span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<input type="email" class="form-control" />
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Username<span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<input type="text" class="form-control" />
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Password<span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<input type="password" class="form-control" />
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Confirm Password<span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<input type="password" class="form-control" />
											</div>
										</div>
									</div>
								</section>
								<!-- Step 2 -->
								<h5>Personal Information</h5>
								<section>
									<div class="form-wrap max-width-600 mx-auto">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Full Name<span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<input type="text" class="form-control" />
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label class="col-sm-4 col-form-label">Gender<span class="text-danger">*</span></label>
											<div class="col-sm-8">
												<div
													class="custom-control custom-radio custom-control-inline pb-0">
													<input
														type="radio"
														id="male"
														name="gender"
														class="custom-control-input" />
													<label class="custom-control-label" for="male">Male</label>
												</div>
												<div
													class="custom-control custom-radio custom-control-inline pb-0">
													<input
														type="radio"
														id="female"
														name="gender"
														class="custom-control-input" />
													<label class="custom-control-label" for="female">Female</label>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Address<span class="text-danger">*</span></label>
											<div class="col-sm-12">
												<input type="text" class="form-control" />
											</div>
										</div>
									</div>
								</section>
								<!-- Step 4 -->
								<h5>Overview Information</h5>
								<section>
									<div class="form-wrap max-width-600 mx-auto">
										<ul class="register-info">
											<li>
												<div class="row">
													<div class="col-sm-4 weight-600">Email Address</div>
													<div class="col-sm-8">example@abc.com</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-sm-4 weight-600">Username</div>
													<div class="col-sm-8">Example</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-sm-4 weight-600">Password</div>
													<div class="col-sm-8">.....000</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-sm-4 weight-600">Full Name</div>
													<div class="col-sm-8">john smith</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-sm-4 weight-600">Location</div>
													<div class="col-sm-8">123 Example</div>
												</div>
											</li>
										</ul>
										<div class="custom-control custom-checkbox mt-4">
											<input
												type="checkbox"
												class="custom-control-input"
												id="customCheck1" />
											<label class="custom-control-label" for="customCheck1">I have read and agreed to the terms of services and
												privacy policy</label>
										</div>



									</div>
								</section>

								<div class="text-center mt-4">
									<a href="login">← Back to Login</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="assets/js/app.min.js"></script>
	<script src="assets/js/jquery.steps.js"></script>
	<script src="assets/js/steps-setting.js"></script>

	<?php include "config/custom_script/page_load_time.php" ?>
</body>

</html>