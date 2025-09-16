<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="Smarthr - Bootstrap Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
	<meta name="author" content="Dreams technologies - Bootstrap Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<title>Smarthr Admin Template</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon.png') }}">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/assets/img/apple-touch-icon.png') }}">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/icons/feather/feather.css') }}">

	<!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/tabler-icons/tabler-icons.min.css') }}">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">

</head>

<body class="bg-white">

	<div id="global-loader" style="display: none;">
		<div class="page-loader"></div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<div class="container-fuild">
			<div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
				<div class="row">
					<div class="col-lg-5">
						<div class="login-background position-relative d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100">
							<div class="bg-overlay-img">
								<img src="{{ asset('admin/assets/img/bg/bg-01.png') }}" class="bg-1" alt="Img">
								<img src="{{ asset('admin/assets/img/bg/bg-02.png') }}" class="bg-2" alt="Img">
								<img src="{{ asset('admin/assets/img/bg/bg-03.png') }}" class="bg-3" alt="Img">
							</div>
							<div class="authentication-card w-100">
								<div class="authen-overlay-item border w-100">
									<h1 class="text-white display-1">Empowering people <br> through seamless HR <br> management.</h1>
									<div class="my-4 mx-auto authen-overlay-img">
										<img src="{{ asset('admin/assets/img/bg/authentication-bg-01.png') }}" alt="Img">
									</div>
									<div>
										<p class="text-white fs-20 fw-semibold text-center">Efficiently manage your workforce, streamline <br> operations effortlessly.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-7 col-md-12 col-sm-12">
						<div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
							<div class="col-md-7 mx-auto vh-100">
								<form action="{{ route('register.submit') }}" method="POST" class="vh-100" id="registerForm" novalidate>
									@csrf
									<div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">
										<div class=" mx-auto mb-5 text-center">
											<img src="{{ asset('admin/assets/img/logo.svg') }}"
												class="img-fluid" alt="Logo">
										</div>
										<div class="">
											<div class="text-center mb-3">
												<h2 class="mb-2">Create Account</h2>
												<p class="mb-0">Please enter your details to create account</p>
											</div>
											<div class="mb-3">
												<label class="form-label">Name</label>
												<div class="input-group">
													<input type="text" name="name" value="{{ old('name') }}" class="form-control border-end-0" required>
													<span class="input-group-text border-start-0">
														<i class="ti ti-user"></i>
													</span>
												</div>
												@error('name')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<div class="mb-3">
												<label class="form-label">Email Address</label>
												<div class="input-group">
													<input type="email" name="email" value="{{ old('email') }}" class="form-control border-end-0" required>
													<span class="input-group-text border-start-0">
														<i class="ti ti-mail"></i>
													</span>
												</div>
												@error('email')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<div class="mb-3">
												<label class="form-label">Phone</label>
												<div class="input-group">
													<input type="text" name="phone" value="{{ old('phone') }}" class="form-control border-end-0" required>
													<span class="input-group-text border-start-0">
														<i class="ti ti-phone"></i>
													</span>
												</div>
												@error('phone')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<div class="mb-3">
												<label class="form-label">Aadhaar</label>
												<div class="input-group">
													<input type="text" name="aadhaar" value="{{ old('aadhaar') }}" class="form-control border-end-0" required>
													<span class="input-group-text border-start-0">
														<i class="ti ti-id"></i>
													</span>
												</div>
												@error('aadhaar')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<div class="mb-3">
												<label class="form-label">PAN Card</label>
												<div class="input-group">
													<input type="text" name="pancard" value="{{ old('pancard') }}" class="form-control border-end-0" required>
													<span class="input-group-text border-start-0">
														<i class="ti ti-credit-card"></i>
													</span>
												</div>
												@error('pancard')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<div class="mb-3">
												<label class="form-label">Password</label>
												<div class="pass-group">
													<input type="password" name="password" class="pass-input form-control" required>
													<span class="ti toggle-password ti-eye-off"></span>
												</div>
											</div>
											<div class="mb-3">
												<label class="form-label">Confirm Password</label>
												<div class="pass-group">
													<input type="password" name="password_confirmation" class="pass-input form-control" required>
													<span class="ti toggle-password ti-eye-off"></span>
												</div>
											</div>
											<div class="mb-3">
												<button type="submit" class="btn btn-primary w-100">Create Account</button>
											</div>
											<div class="text-center">
												<h6 class="fw-normal text-dark mb-0">Already have an account?
													<a href="{{ route('login') }}" class="hover-a"> Sign In</a>
												</h6>
											</div>
											<div class="login-or">
												<span class="span-or">Or</span>
											</div>
											<div class="mt-2">
												<div class="d-flex align-items-center justify-content-center flex-wrap">
													<div class="text-center me-2 flex-fill">
														<a href="javascript:void(0);"
															class="br-10 p-2 btn btn-info d-flex align-items-center justify-content-center">
															<img class="img-fluid m-1" src="{{ asset('admin/assets/img/icons/facebook-logo.svg') }}" alt="Facebook">
														</a>
													</div>
													<div class="text-center me-2 flex-fill">
														<a href="javascript:void(0);"
															class="br-10 p-2 btn btn-outline-light border d-flex align-items-center justify-content-center">
															<img class="img-fluid m-1" src="{{ asset('admin/assets/img/icons/google-logo.svg') }}" alt="Facebook">
														</a>
													</div>
													<div class="text-center flex-fill">
														<a href="javascript:void(0);"
															class="bg-dark br-10 p-2 btn btn-dark d-flex align-items-center justify-content-center">
															<img class="img-fluid m-1" src="{{ asset('admin/assets/img/icons/apple-logo.svg') }}" alt="Apple">
														</a>
													</div>
												</div>
											</div>
										</div>
                                        <div class="mt-5 pb-4 text-center">
											<p class="mb-0 text-gray-9">Copyright &copy; 2024 - Smarthr</p>
										</div>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="{{ asset('admin/assets/js/jquery-3.7.1.min.js') }}"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

	<!-- Feather Icon JS -->
	<script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>

	<!-- Custom JS -->
	<script src="{{ asset('admin/assets/js/script.js') }}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
	$(function () {
		// Aadhaar rule
		$.validator.addMethod("aadhaarValid", function (value) {
			return /^[0-9]{12}$/.test(value);
		}, "Enter a valid 12-digit Aadhaar number.");

		// PAN rule
		$.validator.addMethod("panValid", function (value) {
			return /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(value);
		}, "Enter a valid PAN (ABCDE1234F).");

		// Indian phone
		$.validator.addMethod("phoneIN", function (value) {
			return /^[6-9]\d{9}$/.test(value);
		}, "Enter a valid 10-digit mobile number.");

		$("#registerForm").validate({
			rules: {
				name: { required: true, maxlength: 255 },
				email: { required: true, email: true },
				phone: { required: true, phoneIN: true },
				aadhaar: { required: true, aadhaarValid: true },
				pancard: { required: true, panValid: true },
				password: { required: true, minlength: 8 },
				password_confirmation: { required: true, equalTo: "input[name='password']" }
			},
			messages: {
				password_confirmation: { equalTo: "Passwords do not match." }
			},
			errorElement: 'div',
			errorClass: 'text-danger',
			errorPlacement: function (error, element) {
				if (element.hasClass('pass-input')) {
					error.insertAfter(element.closest('.pass-group'));
				} else {
					error.insertAfter(element.closest('.input-group'));
				}
			},
			highlight: function (element) {
				$(element).addClass('is-invalid');
			},
			unhighlight: function (element) {
				$(element).removeClass('is-invalid');
			},
			onkeyup: function (element) {
				$(element).valid();
			},
			onfocusout: function (element) {
				$(element).valid();
			}
		});
	});
	</script>

</body>

</html>
