<!doctype html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Two-Factor Authentication">
    <meta name="author" content="UPI Gateway">
    <meta name="theme-color" content="#FC5B3F">

    <!-- preload assets -->
    <link rel="preload" href="{{ asset('frontend/fonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/inter-v12-latin-regular.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/inter-v12-latin-500.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/inter-v12-latin-700.woff2') }}" as="font" type="font/woff2" crossorigin>
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
    <title>Two-Factor Authentication - UPI Gateway</title>
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

                    <!-- 2FA verification form -->
                    <div class="uk-width-expand@m uk-flex uk-flex-middle">
                        <div class="uk-grid uk-flex-center">
                            <div class="uk-width-3-5@m">
                                <div class="uk-text-center in-padding-horizontal@s">
                                    <a class="uk-logo" href="{{ url('/') }}">
                                        <img src="{{ asset('frontend/img/in-lazy.gif') }}"
                                            data-src="{{ asset('frontend/img/user/header-logo-6ohuZh.svg') }}"
                                            alt="logo" width="160" height="34" data-uk-img>
                                    </a>
                                    
                                    <div class="uk-margin-medium-top">
                                        <span class="uk-text-primary" data-uk-icon="icon: shield; ratio: 3"></span>
                                    </div>
                                    
                                    <p class="uk-text-lead uk-margin-small-top">
                                        Two-Factor Authentication
                                    </p>
                                    <p class="uk-text-small uk-text-muted uk-margin-remove-top">
                                        Enter the 6-digit code from your authenticator app
                                    </p>

                                    <!-- 2FA code form begin -->
                                    <div id="codeSection">
                                        <form method="POST" action="{{ route('two-factor.verify') }}" class="uk-grid uk-form uk-margin-medium-top">
                                            @csrf
                                            <div class="uk-margin-small uk-width-1-1">
                                                <input class="uk-input uk-border-rounded uk-text-center uk-text-large" 
                                                    id="code" 
                                                    name="code" 
                                                    type="text" 
                                                    placeholder="000000" 
                                                    maxlength="6"
                                                    pattern="[0-9]{6}"
                                                    inputmode="numeric"
                                                    autocomplete="one-time-code"
                                                    required 
                                                    autofocus
                                                    style="letter-spacing: 0.5em; font-weight: 600;">
                                            </div>
                                            <div class="uk-margin-small uk-width-1-1">
                                                <button class="uk-button uk-width-1-1 uk-button-primary uk-border-rounded" type="submit">
                                                    Verify Code
                                                </button>
                                            </div>
                                        </form>

                                        <div class="uk-margin-medium-top">
                                            <a href="#" onclick="showRecoveryForm(); return false;" class="uk-text-small">
                                                Use a recovery code instead
                                            </a>
                                        </div>
                                    </div>
                                    <!-- 2FA code form end -->

                                    <!-- Recovery code form begin (hidden initially) -->
                                    <div id="recoverySection" style="display: none;">
                                        <form method="POST" action="{{ route('two-factor.verify.recovery') }}" class="uk-grid uk-form uk-margin-medium-top">
                                            @csrf
                                            <div class="uk-margin-small uk-width-1-1">
                                                <input class="uk-input uk-border-rounded uk-text-center uk-text-large" 
                                                    id="recovery_code" 
                                                    name="recovery_code" 
                                                    type="text" 
                                                    placeholder="XXXXXXXXXX" 
                                                    maxlength="10"
                                                    style="letter-spacing: 0.3em; font-weight: 600; text-transform: uppercase;">
                                            </div>
                                            <div class="uk-margin-small uk-width-1-1">
                                                <button class="uk-button uk-width-1-1 uk-button-primary uk-border-rounded" type="submit">
                                                    Verify Recovery Code
                                                </button>
                                            </div>
                                        </form>

                                        <div class="uk-margin-medium-top">
                                            <a href="#" onclick="showCodeForm(); return false;" class="uk-text-small">
                                                Use authenticator code instead
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Recovery code form end -->

                                    <hr class="uk-margin-medium-top">
                                    
                                    <div class="uk-margin-medium-top">
                                        <a href="{{ route('logout') }}" class="uk-text-small uk-text-muted">
                                            <i class="fas fa-arrow-left uk-margin-small-right"></i>Cancel and logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 2FA verification form end -->
                </div>
            </div>
        </div>
        <!-- section content end -->
    </main>

    <!-- javascript -->
    <script src="{{ asset('frontend/js/utilities.min.js') }}"></script>
    <script src="{{ asset('frontend/js/config-theme.js') }}"></script>
    
    <script>
        function showRecoveryForm() {
            document.getElementById('codeSection').style.display = 'none';
            document.getElementById('recoverySection').style.display = 'block';
            document.getElementById('recovery_code').focus();
        }

        function showCodeForm() {
            document.getElementById('recoverySection').style.display = 'none';
            document.getElementById('codeSection').style.display = 'block';
            document.getElementById('code').focus();
        }

        // Auto-submit when 6 digits are entered
        document.getElementById('code').addEventListener('input', function(e) {
            if (e.target.value.length === 6) {
                // Optional: auto-submit after a brief delay
                // setTimeout(() => e.target.form.submit(), 500);
            }
        });
    </script>

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

    @if (session('error'))
        <script>
            UIkit.notification({
                message: '{{ session('error') }}',
                status: 'danger',
                pos: 'top-right',
                timeout: 5000
            });
        </script>
    @endif
</body>

</html>
