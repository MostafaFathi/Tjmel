<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://goSellJSLib.b-cdn.net/v1.6.0/css/gosell.css" rel="stylesheet" />
    <link href="{{asset('portal/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/custom.css')}}" rel="stylesheet" type="text/css">

    <style>
        @font-face {
            font-family: 'Droid Arabic Kufi';
            src: url({{ asset('portal/assets/font/DroidKufi-Regular.woff2') }}),url({{ asset('portal/assets/font/DroidKufi-Bold.woff2') }});
        }
    </style>
</head>

<style type="text/css">
    html,body{
        width: 100%;
        height: 100%;
    }
    body{
        font-family: 'Droid Arabic Kufi', serif !important;
        background: #CFDE40 url('{{asset('portal/assets/images/background.jpg')}}') no-repeat;
        background-size: cover;
        background-position: center;
        text-align: center;
        margin: 0;
    }
    .login{
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }
    .login .brand{
        margin-bottom: 30px;
    }
    .login .brand img{
        width: 150px;
    }
    .login .links .btn-login{
        color: #ae4d73;
        font-size: 25px;
        font-weight: 400;
        display: table;
        margin: 0 auto 15px auto;
        text-decoration: none;
        padding: 0 15px;
    }
    .login .links .btn-login:hover{
        color: #593b6b;
    }
    .login .links .btn-continue{
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
    .login .links .btn-continue:hover{
        background: white;
        color: #593b6b;
        border: 1px solid #593b6b;
    }
</style>

<body>


<div class="content">
    <div class="row text-center">
        <h1 style="    text-align: center;width: 100%;color: #00cc00;font-weight: bold;position: fixed;top: 50%;">
            تمت عملية الدفع بنجاح
        </h1>
    </div>
</div>

</body>
</html>
