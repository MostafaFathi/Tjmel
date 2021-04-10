<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{asset('portal/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/global_assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{asset('portal/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/custom.css?v=1')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('css/rating.min.css?ver=20191030')}}">

    <style>
        @font-face {
            font-family: 'Droid Arabic Kufi';
            src: url({{ asset('portal/assets/font/rb_bold.ttf') }}), url({{ asset('portal/assets/font/rb_regular.ttf') }});
        }
    </style>
    <script src="{{asset('portal/global_assets/js/main/jquery.min.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->

    <style>
        .amber-text {
            color: orange;
        }

        .fas {
            font-size: 1.1rem !important;
        }
    </style>
    <!-- Theme JS files -->
    <script src="{{asset('portal/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
</head>

<style type="text/css">
    html, body {
        width: 100%;
        height: 100%;
    }

    body {
        font-family: 'Droid Arabic Kufi', serif !important;
        background: #ffffff url('{{asset('portal/assets/images/background.jpg')}}') no-repeat;
        background-size: cover;
        background-position: center;
        text-align: center;
        margin: 0;
    }

    .login {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }

    .login .brand {
        margin-bottom: 30px;
    }

    .login .brand img {
        width: 150px;
    }

    .login .links .btn-login {
        color: #ae4d73;
        font-size: 25px;
        font-weight: 400;
        display: table;
        margin: 0 auto 15px auto;
        text-decoration: none;
        padding: 0 15px;
    }

    .login .links .btn-login:hover {
        color: #593b6b;
    }

    .login .links .btn-continue {
        color: white;
        font-size: 18px;
        font-weight: 500;
        display: table;
        margin: auto;
        text-decoration: none;
        background: #593b6b;
        border: 1px solid #593b6b;
        border-radius: 25px;
        padding: 10px 10px;
        width: 400px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .login .links .btn-continue:hover {
        background: white;
        color: #593b6b;
        border: 1px solid #593b6b;
    }
</style>

<body>

<section class="login">

    <div class="brand">

        <img src="{{asset('portal/assets/images/logo.svg')}}">

    </div>

    <div class="links" style="font-size: 26px;">

            شكرا لتقييم العيادة

    </div>

</section>

<script src="{{asset('js/rating.min.js')}}"></script>

<script>
    var $stars;

    var myDefaultWhiteList = $.fn.tooltip.Constructor.Default.whiteList
    myDefaultWhiteList.textarea = [];
    myDefaultWhiteList.button = [];

    $stars = $('.rate-popover');

    $stars.on('click', function () {
        var index = $(this).attr('data-index');
        var rate = Number(index) + 1;

        $('.rate-company-value').val(rate);
        markStarsAsActive(index);
    });

    function markStarsAsActive(index) {
        unmarkActive();
        for (var i = 0; i <= index; i++) {
            $($stars.get(i)).addClass('amber-text');
        }
    }

    function unmarkActive() {
        $stars.removeClass('amber-text');
    }

    $(function () {

        $('.rate-popover').tooltip();
    });

</script>
</body>
</html>
