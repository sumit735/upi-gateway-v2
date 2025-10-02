<!doctype html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Premium HTML5 Template by Indonez">
    <meta name="keywords" content="blockit, uikit3, indonez, handlebars, scss, javascript">
    <meta name="author" content="Indonez">
    <meta name="theme-color" content="#FC5B3F">

    <!-- preload assets -->
    <link rel="preload" href="{{ asset('frontend/fonts/fa-brands-400.woff2') }}" as="font" type="font/woff2"
        crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/inter-v12-latin-regular.woff2') }}" as="font" type="font/woff2"
        crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/inter-v12-latin-500.woff2') }}" as="font" type="font/woff2"
        crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/inter-v12-latin-700.woff2') }}" as="font" type="font/woff2"
        crossorigin>
    <link rel="preload" href="{{ asset('frontend/css/style.css') }}" as="style">
    <link rel="preload" href="{{ asset('frontend/js/vendors/uikit.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('frontend/js/utilities.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('frontend/js/config-theme.js') }}" as="script">

    <!-- stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <!-- uikit -->
    <script src="{{ asset('frontend/js/vendors/uikit.min.js') }}"></script>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend/img/favicon.ico') }}" type="image/x-icon">
    <!-- touch icon -->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('frontend/img/apple-touch-icon.png') }}">
    <title>Validate OTP - Liquid HTML5 Template</title>
</head>

<body>
    <!-- page loader begin -->
    <div class="page-loader">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <!-- page loader end -->

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
        <!-- section content begin -->
        <div class="uk-section uk-section-secondary uk-light uk-padding-remove-vertical">
            <div class="uk-container uk-container-expand">
                <div class="uk-grid" data-uk-height-viewport="expand: true">
                    <!-- left image -->
                    <div class="uk-width-3-5@m uk-background-cover uk-background-center-right uk-visible@m uk-box-shadow-xlarge"
                        style="background-image: url({{ asset('frontend/img/signin.jpg') }});">
                    </div>

                    <!-- forgot password form -->
                    <div class="uk-width-expand@m uk-flex uk-flex-middle">
                        <div class="uk-grid uk-flex-center">
                            <div class="uk-width-3-5@m">
                                <div class="uk-text-center in-padding-horizontal@s">
                                    <a class="uk-logo" href="{{ url('/') }}">
                                        <img src="{{ asset('frontend/img/in-lazy.gif') }}"
                                            data-src="{{ asset('frontend/img/user/header-logo-6ohuZh.svg') }}"
                                            alt="logo" width="160" height="34" data-uk-img>
                                    </a>
                                    <p class="uk-text-lead uk-margin-small-top uk-margin-medium-bottom">
                                        Forgot your password?
                                    </p>
                                    <p class="uk-text-small uk-margin-remove-top uk-margin-medium-bottom">
                                        Enter your details for reset password.
                                    </p>

                                    <!-- forgot password form begin -->
                                    <form method="POST" action="{{ route('admin.userdetails.validate') }}"
                                        id="registerForm" class="uk-grid uk-form">
                                        @csrf

                                        <div class="uk-margin-small uk-width-1-1 uk-inline">
                                            <span class="uk-form-icon uk-form-icon-flip fas fa-key fa-sm"></span>
                                            <input class="uk-input uk-border-rounded" type="text" name="phone"
                                                value="{{ old('phone') }}" placeholder="Phone" required>
                                        </div>

                                        <div class="uk-margin-small uk-width-1-1 uk-inline">
                                            <input class="uk-input uk-border-rounded" type="text" name="pancard"
                                                value="{{ old('pancard') }}" placeholder="PAN Card" required>
                                        </div>

                                        <div class="uk-margin-small uk-width-1-1 uk-inline">
                                            <input class="uk-input uk-border-rounded" type="text" name="aadhaar"
                                                value="{{ old('aadhaar') }}" placeholder="Aadhaar" required>
                                        </div>

                                        <div class="uk-margin-small uk-width-1-1">
                                            <button
                                                class="uk-button uk-width-1-1 uk-button-primary uk-border-rounded uk-float-left"
                                                type="submit">Submit</button>
                                        </div>
                                    </form>
                                    <!-- forgot password form end -->

                                    <p class="uk-margin-top uk-text-small">
                                        <a href="{{ route('login') }}">Back to Login</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- forgot password form end -->
                </div>
            </div>
        </div>
        <!-- section content end -->
    </main>

    <!-- javascript -->
    <script src="{{ asset('frontend/js/utilities.min.js') }}"></script>
    <script src="{{ asset('frontend/js/config-theme.js') }}"></script>

    <!-- jQuery + jQuery Validate -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

    <script>
        $(function () {
            // Aadhaar rule
            $.validator.addMethod("aadhaarValid", v => /^[0-9]{12}$/.test(v), "Enter valid 12-digit Aadhaar.");
            // PAN rule
            $.validator.addMethod("panValid", v => /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(v),
                "Enter valid PAN (ABCDE1234F).");
            // Phone rule
            $.validator.addMethod("phoneIN", v => /^[6-9]\d{9}$/.test(v), "Enter valid 10-digit mobile number.");

            $("#registerForm").validate({
                rules: {
                    phone: {
                        required: true,
                        phoneIN: true
                    },
                    aadhaar: {
                        required: true,
                        aadhaarValid: true
                    },
                    pancard: {
                        required: true,
                        panValid: true
                    }
                },
                errorElement: 'div',
                errorClass: 'text-danger',
                highlight: e => $(e).addClass('is-invalid'),
                unhighlight: e => $(e).removeClass('is-invalid')
            });
        });
    </script>
</body>

</html>