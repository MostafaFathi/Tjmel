<html>
<head>
    <title>Show Result Demo</title>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link
        rel="shortcut icon"
        href="https://goSellJSLib.b-cdn.net/v1.6.0/imgs/tap-favicon.ico"
    />
    <link
        href="https://goSellJSLib.b-cdn.net/v1.6.0/css/gosell.css"
        rel="stylesheet"
    />
</head>
<body>
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}"/>
<script src="{{asset('portal/global_assets/js/main/jquery.min.js')}}"></script>
<script
    type="text/javascript"
    src="https://goSellJSLib.b-cdn.net/v1.6.0/js/gosell.js"
></script>

<div id="root"></div>
<script>

    goSell.showResult({
        callback: response => {

            $.ajax({
                url: "{{route('payment.callback.post')}}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')
                },
                data : JSON.stringify(response),
                contentType : 'application/json',
                success: function (data) {
                    console.log(data.message,data)
                    if(data.message == 'success')
                        window.open('{{route('payment.success')}}',"_self")
                    if(data.message == 'fail')
                        window.open('{{route('payment.fail')}}',"_self")
                },
                error: function (data) { }
            })


            console.log("callback", response);
        }
    });
</script>
</body>
</html>
