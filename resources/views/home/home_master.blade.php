<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Easy Vest - Home</title>

    <meta name="title" Content="RealVest - Home">
    <meta name="description"
        content="Introducing RealVest - Real Estate Investment System, the cutting-edge solution for navigating the complexities of real estate investment with unparalleled ease and efficiency. RealVest offers a robust platform developed on advanced technology, designed to meet the needs of both novice investors and seasoned professionals in the real estate industry.">

    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/favicon.png') }}" type="image/x-icon">

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

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>

<body>
    <div class="preloader">
        <div class="loader-p"></div>
    </div>

    @include('home.body.header')

    @yield('home')

    @include('home.body.footer')


    <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>


    <script src="{{ asset('frontend/assets/js/main.js?get=5') }}"></script>

    <link href="{{ asset('frontend/assets/js/iziToast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/js/iziToast_custom.css') }}" rel="stylesheet">
    <script src="{{ asset('frontend/assets/js/iziToast.min.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif 
    </script>


    <script src="{{ asset('frontend/assets/global/js/firebase/firebase-8.3.2.js') }}"></script>


    <script>
        (function ($) {
            "use strict";
            // Featured Property Cards Slider Js Start
            $('.featured-property').each(function (index, element) {
                $(element).find('.featured-property__cards').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    speed: 2000,
                    dots: false,
                    arrows: true,
                    appendArrows: $(element).find('.featured-property__arrows'),
                    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
                    responsive: [{
                        breakpoint: 991 + 1,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 600 + 1,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 424 + 1,
                        settings: {
                            slidesToShow: 1,
                            dots: true,
                            arrows: false
                        }
                    }
                    ]
                });
                // Remove slick dots numbers
                var textNodes = $(element).find('.slick-dots > li button').contents().filter(function () {
                    return this.nodeType === Node.TEXT_NODE;
                })
                textNodes.remove();
            });
            // Featured Property Cards Slider Js End
        })(jQuery);
    </script>
    <script>
        (function ($) {
            "use strict";

            // Testimonial Cards Slider Js start
            $('.testimonial').each(function (index, element) {
                $(element).find('.testimonial__cards').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    speed: 1500,
                    arrows: false,
                    dots: true,
                    appendDots: $(element).find('.testimonial__dots'),
                    responsive: [{
                        breakpoint: 767 + 1,
                        settings: {
                            appendDots: $(element).find('.testimonial__cards'),
                        }
                    },]
                });
                $(element).find('.testimonial__brands').slick({
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 1000,
                    pauseOnHover: true,
                    speed: 2000,
                    dots: false,
                    arrows: false,
                    responsive: [{
                        breakpoint: 1199 + 1,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 576 + 1,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 424 + 1,
                        settings: {
                            slidesToShow: 2,
                        }
                    }
                    ]
                });
                // Remove slick dots numbers
                var textNodes = $(element).find('.slick-dots > li button').contents().filter(function () {
                    return this.nodeType === Node.TEXT_NODE;
                });

                textNodes.remove();
            });
            // Testimonial Cards Slider Js End
        })(jQuery);
    </script>




</body>

</html>