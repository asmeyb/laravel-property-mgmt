<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Login Page </title>

    <meta name="title" Content="RealVest - Home">
    <meta name="description"
        content="Introducing RealVest - Real Estate Investment System, the cutting-edge solution for navigating the complexities of real estate investment with unparalleled ease and efficiency. RealVest offers a robust platform developed on advanced technology, designed to meet the needs of both novice investors and seasoned professionals in the real estate industry.">

    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">

    <!-- Icon Libraries via CDN -->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="apple-touch-icon" href="{{ asset('frontend/assets/images/logo.png') }}">

    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1180">
    <meta property="og:image:height" content="600">
    <meta name="twitter:card" content="summary_large_image">

    <link href="{{ asset('frontend/assets/css/bootstrap.min.css?get=5') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/main.css?get=5') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/custom.css?get=5') }}" rel="stylesheet">



</head>

<body>
    <div class="preloader">
        <div class="loader-p"></div>
    </div>

    <div class="body-overlay"></div>

    <div class="sidebar-overlay"></div>


    <section class="account">
        <div class="account-inner py-60 bg-pattern3">
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-6 col-xxl-5">


                        <form method="POST" action="{{ route('login') }}" class="account-form verify-gcaptcha">
                            @csrf


                            <div class="account-form__header text-center">
                                <a class="mb-5" href=" "> <img src="{{ asset('frontend/assets/images/logo.png') }}"></a>
                                <h5 class="account-form__title mb-3">Account Login</h5>

                            </div>
                            <div class="account-form__body">
                                <div class="form-group">
                                    <label for="usernameOrEmail" class="form--label required">Email</label>
                                    <input class="form--control" type="email" name="email" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="your-password" class="form--label required">Password</label>
                                    <div class="position-relative">
                                        <input class="form--control" type="password" name="password" id="password">
                                    </div>
                                </div>

                                <div class="flex-between">

                                    <a href="{{ route('password.request') }}" class="account-form__forgot-pass">Forgot
                                        Password?</a>
                                </div>
                            </div>
                            <div class="account-form__footer">
                                <button type="submit" id="recaptcha" class="w-100 btn btn--base">Login</button>
                                <p class="account-form__subtitle mt-3">
                                    Don't have an account?
                                    <a href="{{ route('register') }}">Register</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>


    <script src="{{ asset('frontend/assets/js/main.js?get=5') }}"></script>

    <link href="{{ asset('frontend/assets/js/iziToast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/js/iziToast_custom.css') }}" rel="stylesheet">
    <script src="{{ asset('frontend/assets/js/iziToast.min.js') }}"></script>




</body>

</html>