<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://goSellJSLib.b-cdn.net/v1.6.0/css/gosell.css" rel="stylesheet" />

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
        background: #ffffff url('{{asset('portal/assets/images/background.jpg')}}') no-repeat;
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


<div id="root"></div>
{{--<button id="openLightBox" onclick="">open goSell LightBox</button>--}}
{{--<button id="openPage" onclick="goSell.openPaymentPage()">open goSell Page</button>--}}
<script type="text/javascript" src="https://goSellJSLib.b-cdn.net/v1.6.0/js/gosell.js"></script>

<script>

    goSell.config({
        containerID:"root",
        gateway:{
            publicKey:"pk_test_ZibWVRIrECOMDxjncHl7yA6v",
            merchantId: null,
            language:"ar",
            contactInfo:true,
            supportedCurrencies:"all",
            supportedPaymentMethods: "all",
            saveCardOption:false,
            customerCards: true,
            // notifications:'standard',
            callback:(response) => {
                console.log('response', response);
            },
            onClose: () => {
                window.open('{{route('payment.cancel')}}',"_self")
            },
            onLoad:() => {
                console.log("onLoad");
                goSell.openLightBox();
            },
            backgroundImg: {
                url: 'imgURL',
                opacity: '0.5'
            },
            labels:{
                cardNumber:"Card Number",
                expirationDate:"MM/YY",
                cvv:"CVV",
                cardHolder:"Name on Card",
                actionButton:"إدفع"
            },
            style: {
                base: {
                    color: '#535353',
                    lineHeight: '18px',
                    fontFamily: 'sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: 'rgba(0, 0, 0, 0.26)',
                        fontSize:'15px'
                    }
                },
                invalid: {
                    color: 'red',
                    iconColor: '#fa755a '
                }
            }
        },
        customer:{
            id:null,
            first_name: "app user {{$user->mobile}}",
            middle_name: "",
            last_name: "",
            email: "{{$user->mobile}}@tjmel.com",
            phone: {
                country_code: "965",
                number: "{{$user->mobile}}"
            }
        },
        order:{
            amount: {{$advance_payment}},
            currency:"SAR",
            id:'{{$reservation->id}}'
        },
        transaction:{
            mode: 'charge',
            charge:{
                saveCard: false,
                threeDSecure: true,
                description: "{{ ' حجز رقم '.$reservation->display_id}}",
                statement_descriptor: "{{ $reservation->id}}",
                reference:{
                    transaction: "txn_0001",
                    order: "{{'order-'.rand(99999,10000).'-'.$reservation->id}}"
                },
                metadata:{},
                receipt:{
                    email: false,
                    sms: false
                },
                redirect: "{{route('payment.callback')}}",
                post: "{{route('payment.callback.post')}}",

            }
        }
    });

</script>
</body>
</html>
