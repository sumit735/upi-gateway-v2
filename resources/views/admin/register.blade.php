<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Register - Liquid Template with Backend">
	<meta name="keywords" content="register, laravel, uikit, bootstrap, validation">
	<meta name="author" content="Custom">
	<meta name="theme-color" content="#FC5B3F">

	<!-- preload + styles -->
	<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
	<script src="{{ asset('frontend/js/vendors/uikit.min.js') }}"></script>
	<title>Register</title>
</head>

<body>
	<!-- Laravel validation errors (toast style) -->
	@if ($errors->any())
		<div class="position-fixed top-0 end-0 p-3" style="z-index:1055;">
			<div class="toast align-items-center text-bg-danger border-0 fade show mb-4" role="alert">
				<div class="d-flex">
					<div class="toast-body">
						@foreach ($errors->all() as $error)
							{{ $error }}<br>
						@endforeach
					</div>
					<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
				</div>
			</div>
		</div>
	@endif

	<main>
		<div class="uk-section uk-section-secondary uk-light uk-padding-remove-vertical">
			<div class="uk-container uk-container-expand">
				<div class="uk-grid" data-uk-height-viewport="expand: true">
					<div class="uk-width-3-5@m uk-background-cover uk-background-center-right uk-visible@m uk-box-shadow-xlarge" style="background-image: url({{ asset('frontend/img/signin.jpg') }});"></div>
					
					<div class="uk-width-expand@m uk-flex uk-flex-middle">
						<div class="uk-grid uk-flex-center">
							<div class="uk-width-3-5@m">
								<div class="uk-text-center in-padding-horizontal@s">
									<a class="uk-logo" href="{{ url('/') }}">
										<img src="{{ asset('frontend/img/user/header-logo-6ohuZh.svg') }}" alt="logo" width="160">
									</a>
									<p class="uk-text-lead uk-margin-small-top">Create your account</p>

									<!-- Register form -->
									<form id="registerForm" method="POST" action="{{ route('register.submit') }}" class="uk-grid uk-form">
										@csrf

										<!-- Step Indicators -->
										<div class="mb-3 d-flex justify-content-between">
											<span id="step1Indicator" class="fw-bold text-primary">Step 1: Personal Info</span>
											<span id="step2Indicator" class="fw-bold text-muted">Step 2: Account Details</span>
										</div>

										<!-- Step 1 -->
										<div id="step1">
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required>
											</div>
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone" required>
											</div>
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
											</div>
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="text" name="pancard" value="{{ old('pancard') }}" placeholder="PAN Card" required>
											</div>
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="text" name="aadhaar" value="{{ old('aadhaar') }}" placeholder="Aadhaar" required>
											</div>
											
											<div class="uk-margin-small uk-width-1-1">
												<button type="button" id="continueBtn" class="uk-button uk-button-primary uk-border-rounded uk-width-1-1">Continue</button>
											</div>
										</div>

										<!-- Step 2 -->
										<div id="step2" class="d-none">
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name" required>
											</div>
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="text" name="district" value="{{ old('district') }}" placeholder="District" required>
											</div>
											<div class="uk-margin-small uk-width-1-1">
												<select name="state" class="uk-input uk-border-rounded" required>
													<option value="">-- Select State --</option>
													<option value="Odisha" {{ old('state')=='Odisha' ? 'selected':'' }}>Odisha</option>
													<option value="West Bengal" {{ old('state')=='West Bengal' ? 'selected':'' }}>West Bengal</option>
													<option value="Delhi" {{ old('state')=='Delhi' ? 'selected':'' }}>Delhi</option>
													<!-- Add all states as in your Smarthr code -->
												</select>
											</div>
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="text" name="pincode" value="{{ old('pincode') }}" placeholder="Pincode" required>
											</div>
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="password" name="password" placeholder="Password" required>
											</div>
											<div class="uk-margin-small uk-width-1-1 uk-inline">
												<input class="uk-input uk-border-rounded" type="password" name="password_confirmation" placeholder="Confirm Password" required>
											</div>
											<div class="d-flex justify-content-between">
												<button type="button" id="backBtn" class="uk-button uk-button-secondary uk-border-rounded">Back</button>
												<button type="submit" class="uk-button uk-button-primary uk-border-rounded">Create Account</button>
											</div>
										</div>
									</form>

									<p class="uk-margin-top uk-text-small">Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- scripts -->
	<script src="{{ asset('admin/assets/js/jquery-3.7.1.min.js') }}"></script>
	<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

	<script>
		$(function () {
			// Aadhaar rule
			$.validator.addMethod("aadhaarValid", v => /^[0-9]{12}$/.test(v), "Enter valid 12-digit Aadhaar.");
			// PAN rule
			$.validator.addMethod("panValid", v => /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(v), "Enter valid PAN (ABCDE1234F).");
			// Phone rule
			$.validator.addMethod("phoneIN", v => /^[6-9]\d{9}$/.test(v), "Enter valid 10-digit mobile number.");

			$("#registerForm").validate({
				rules: {
					name: { required: true, maxlength: 255 },
					email: { required: true, email: true },
					phone: { required: true, phoneIN: true },
					aadhaar: { required: true, aadhaarValid: true },
					pancard: { required: true, panValid: true },
					company_name: { required: true },
					district: { required: true },
					state: { required: true },
					pincode: { required: true, digits: true, minlength: 6, maxlength: 6 },
					password: { required: true, minlength: 8 },
					password_confirmation: { required: true, equalTo: "input[name='password']" }
				},
				messages: {
					password_confirmation: { equalTo: "Passwords do not match." }
				},
				errorElement: 'div',
				errorClass: 'text-danger',
				highlight: e => $(e).addClass('is-invalid'),
				unhighlight: e => $(e).removeClass('is-invalid')
			});

			// Step nav
			$("#continueBtn").click(() => {
				if ($("#registerForm").valid()) {
					$("#step1").addClass("d-none");
					$("#step2").removeClass("d-none");
					$("#step1Indicator").removeClass("text-primary").addClass("text-muted");
					$("#step2Indicator").removeClass("text-muted").addClass("text-primary");
				}
			});
			$("#backBtn").click(() => {
				$("#step2").addClass("d-none");
				$("#step1").removeClass("d-none");
				$("#step2Indicator").removeClass("text-primary").addClass("text-muted");
				$("#step1Indicator").removeClass("text-muted").addClass("text-primary");
			});
		});
	</script>
</body>

</html>
