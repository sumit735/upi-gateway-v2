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
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Liquid HTML5 Template</title>
</head>

<body>
    <!-- page loader begin -->
    <div class="page-loader">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <!-- page loader end -->

    <main>
        <!-- section content begin -->
        <div class="uk-section uk-section-secondary uk-light uk-padding-remove-vertical">
            <div class="uk-container uk-container-expand">
                <div class="uk-grid" data-uk-height-viewport="expand: true">
                    <!-- left image -->
                    <div class="uk-width-3-5@m uk-background-cover uk-background-center-right uk-visible@m uk-box-shadow-xlarge"
                        style="background-image: url({{ asset('frontend/img/signin.jpg') }});">
                    </div>

                    <!-- login form -->
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
                                        Log into your account
                                    </p>

                                    <!-- Discoverable Passkey Login (No Email Required) -->
                                    <div class="uk-margin-medium-bottom" id="discoverablePasskeySection">
                                        <button type="button"
                                            id="passkeyButton"
                                            class="uk-button uk-width-1-1 uk-button-primary uk-border-rounded"
                                            onclick="loginWithDiscoverablePasskey()"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; min-height: 48px; font-size: 13px;">
                                            <i class="fas fa-fingerprint uk-margin-small-right"></i>Sign in with Passkey
                                        </button>
                                        <p class="uk-text-small uk-text-muted uk-margin-small-top uk-text-center" style="margin-top: 8px;">
                                            Use Face ID, Touch ID, or your device's security key
                                        </p>
                                    </div>

                                    <p class="uk-heading-line"><span>Or use password</span></p>

                                    <!-- login form begin -->
                                    <form method="POST" action="{{ route('login') }}" class="uk-grid uk-form">
                                        @csrf
                                        <div class="uk-margin-small uk-width-1-1 uk-inline">
                                            <span class="uk-form-icon uk-form-icon-flip fas fa-user fa-sm"></span>
                                            <input class="uk-input uk-border-rounded" id="email" name="email"
                                                value="{{ old('email') }}" type="email" placeholder="Email" required
                                                autofocus>
                                        </div>
                                        <div class="uk-margin-small uk-width-1-1 uk-inline">
                                            <span class="uk-form-icon uk-form-icon-flip fas fa-lock fa-sm"></span>
                                            <input class="uk-input uk-border-rounded" id="password" name="password"
                                                type="password" placeholder="Password" required>
                                        </div>
                                        <div class="uk-margin-small uk-width-auto uk-text-small">
                                            <label>
                                                <input class="uk-checkbox" type="checkbox" name="remember"> Remember me
                                            </label>
                                        </div>
                                        <div class="uk-margin-small uk-width-expand uk-text-small">
                                            <label class="uk-align-right">
                                                <a class="uk-link-reset"
                                                    href="{{ route('admin.forgot.password.form') }}">
                                                    Forgot password?
                                                </a>
                                            </label>
                                        </div>
                                        <div class="uk-margin-small uk-width-1-1">
                                            <button
                                                class="uk-button uk-width-1-1 uk-button-primary uk-border-rounded uk-float-left"
                                                type="submit">Sign in</button>
                                        </div>
                                    </form>
                                    <!-- login form end -->

                                    <p class="uk-heading-line uk-margin-medium-top"><span>Or sign in with</span></p>
                                    <div class="uk-margin-medium-bottom">
                                        <a class="uk-button uk-button-small uk-border-rounded color-google" href="#">
                                            <i class="fab fa-google uk-margin-small-right"></i>Google
                                        </a>
                                        <a class="uk-button uk-button-small uk-border-rounded uk-margin-small-left color-facebook"
                                            href="#">
                                            <i class="fab fa-facebook-f uk-margin-small-right"></i>Facebook
                                        </a>
                                    </div>
                                    <span class="uk-text-small">
                                        Don't have an account? <a href="{{ route('register') }}">Register here</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- login form end -->
                </div>
            </div>
        </div>
        <!-- section content end -->
    </main>

    <!-- javascript -->
    <script src="{{ asset('frontend/js/utilities.min.js') }}"></script>
    <script src="{{ asset('frontend/js/config-theme.js') }}"></script>
    <script src="{{ asset('admin/assets/js/passkey-auth.js') }}"></script>
    @if ($errors->any())
        <script>
            UIkit.notification({
                message: '@foreach ($errors->all() as $error){{ $error }}<br>@endforeach',
                status: 'danger',
                pos: 'top-right',
                timeout: 5000
            });
        </script>
    @endif
</body>

</html>