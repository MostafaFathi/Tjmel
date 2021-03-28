<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Env Friends') }}</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="{{asset('portal/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/global_assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{asset('portal/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('portal/assets/css/custom.css?v=1')}}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.3.13/css/tableexport.css" rel="stylesheet"
          type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{asset('portal/global_assets/js/main/jquery.min.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->


    <!-- Theme JS files -->
    <script src="{{asset('portal/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/demo_pages/components_dropdowns.js')}}"></script>

    <script src="{{asset('portal/assets/js/app.js')}}"></script>

    <script src="{{asset('portal/global_assets/js/demo_pages/form_layouts.js')}}"></script>
    <!-- /theme JS files -->


@yield('js_css_header')
<!-- /theme JS files -->
    <style>
        .content {
            background: white !important;
        }

        .navbar-dark {
            background: rgb(252, 168, 126);
            background: white;
        }

        .sidebar-dark {
            background-color: #ffffff !important;
            color: #969696 !important;
        }

        .sidebar-dark .nav-sidebar .nav-link:not(.disabled):hover, .sidebar-light .card[class*=bg-]:not(.bg-light):not(.bg-white):not(.bg-transparent) .nav-sidebar .nav-link:not(.disabled):hover {
            color: #593B6B !important;
            background: transparent;
        }

        .sidebar-dark .nav-sidebar .nav-link, .sidebar-light .card[class*=bg-]:not(.bg-light):not(.bg-white):not(.bg-transparent) .nav-sidebar .nav-link {
            color: #969696 !important;
            font-size: 15px;
            font-weight: bold;
            padding: 15px 20px;
        }

        .nav-sidebar .nav-link i {
            margin-right: 10px;
            margin-top: 4px;
        }

        .sidebar-dark .nav-sidebar .nav-item-header, .sidebar-light .card[class*=bg-]:not(.bg-light):not(.bg-white):not(.bg-transparent) .nav-sidebar .nav-item-header {
            color: #707070 !important;
            padding-bottom: 0;
            padding-top: 0;
        }

        .nav-item-header .font-size-xs {
            font-size: 20px !important;
        }

        .sidebar-dark .nav-sidebar > .nav-item > .nav-link.active {
            background-color: #e4e4e4 !important;
        }

        .dropdown-item {

            color: #77797a !important;

        }

        .navbar {
            padding-top: 25px !important;
            padding-right: 25px !important;
            padding-left: 25px !important;
            border-bottom: none !important;
        }

        .navbar-brand {
            min-width: 17rem !important;
            text-align: center !important;
            background: white !important;
        }

        .navbar-expand-md .navbar-brand {
            min-width: 16.9rem !important;
            border-bottom: 0;
        }

        .sidebar:not(.sidebar-component) .sidebar-content {
            padding-top: 40px;
            position: inherit !important;
            top: auto !important;
            bottom: auto !important;
            width: inherit !important;
            overflow-y: hidden !important;
        }

        .nav-sidebar .nav-item:not(.nav-item-divider) {
            box-shadow: 0px 1px 1px;
            padding: 16px 5px;
            width: 145px;
            background: #fbfbfb;
            border-radius: 38px;
            margin-bottom: 6px;
            font-size: 14px !important;
        }

        .card {
            border: 0px !important;
            box-shadow: none !important;
        }

        .form-group {
            text-align: center;
        }

        .form-control {
            background: #fdfdfd;
            height: calc(1.5385em + .875rem + 10px);
            border: 1px solid #9E9E9E !important;
            text-align: center;
        }

        textarea {
            resize: none;
        }

        .btn-outline-secondary {
            background-color: #f1f1f17a !important;
            color: #777;
            font-weight: bold;
            background-image: none;
            border-color: #777;
            width: 140px;
            height: 47px;
        }

        .btn-orange {
            background-color: #fca87e !important;
            color: #969696;
            font-weight: bold;
            background-image: none;
            border-color: #777;
            width: 140px;
            height: 47px;
            font-size: 20px;
        }

        .month-days,.month-header {
            list-style: none;
        }

        .month-days li {
            float: left;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 19px;
            margin-right: 11px;
            margin-bottom: 13px;
            background: #fbfbfb;
            color: #717579;
            min-width: 76px;
            box-shadow: 0px 1px 4px -2px;
            border-radius: 5px;
            cursor: pointer;
        }

        .month-days li.checked {
            background: #cacaca;
            color: #4a4a4a;
        }
        .month-days li span {
            font-size: 9px;
            font-weight: 400;
            display: block;
        }
        .month-header li {
            float: left;
            font-size: 16px;
            font-weight: bold;
            padding: 20px 29px;
            margin-right: 11px;
            margin-bottom: 13px;
        }
        .ul-times{
            list-style: none;
        }
        .ul-times li{
            float: left;
            font-size: 12px;
            font-weight: bold;
            padding: 11px 10px;
            margin-right: 11px;
            margin-bottom: 13px;
            background: #fbfbfb;
            color: #717579;
            min-width: 68px;
            box-shadow: 0px 1px 4px -2px;
            border-radius: 17px;
            cursor: pointer;
            direction: ltr;
        }
        .ul-times li.checked {
            background: #cacaca;
            color: #4a4a4a;
        }
        .nav-sidebar .nav-item:not(.nav-item-header):first-child {
            padding-top: 16px !important;
        }

        .table thead th{
            color: #ff9460;
            font-weight: bold;
        }
        .table  th,.table  td{
            text-align: center;
        }
        .nav-tabs .nav-link {
            background-color: #f7f7f7;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            color: #777;
            margin: 0px 25px;
            font-weight: bold;
            box-shadow: 0px -1px 4px -2px;
            height: 60px;
            padding: 20px;
        }
        .nav-tabs {
            margin-bottom: 0;
            border-bottom: 0;
        }
        .nav-tabs-bottom .nav-link.active:before {
            background-color: transparent;
        }
        .nav-tabs .nav-link.active {
            background-color: #fca87e;
            color: #707070;
        }
        .sidebar {
            width: 10.875rem !important;
        }

        .nav-sidebar .nav-link {
            display: block !important;
            text-align: center;
        }

        .sidebar-expand-md:not(.sidebar-component) {
            border-left: none;
        }

        .bg-blue-400 {
            background-color: #593B6B;
        }

        .bg-success-400 {
            background-color: #ae8cbe;
        }

        .bg-danger-400 {
            background-color: #FFB045;
        }

        .card {
            border-radius: 15px;
        }

        .btn {
            border-radius: 15px;
        }

        .btn-primary {
            background-color: #FCA87E;
        }

        .btn-primary:hover {
            background-color: #ff9460;
        }

        .btn-info {
            background-color: #d6d6d6;
        }

        .btn-info:hover {
            background-color: #b3b3b3;
        }

        .btn-success {
            background-color: #FCA87E;
        }

        .btn-success:hover {
            background-color: #ff9460;
        }

        .table {
            color: #707070;
        }

        .sidebar-dark .nav-sidebar > .nav-item.active {
            background: #ff9460 !important;
            color: #593B6B !important;
        }

        .form-control {
            border-radius: 15px;
        }

        .sidebar-user {
            border-bottom: none;
        }

        .media-title {
            font-size: 17px;
            color: #593B6B;
        }

        .navbar-top {
            padding-top: 4rem;
        }
    </style>

</head>

<body class="navbar-top">

<!-- Main navbar -->
@include('clinic.layouts.navbar')
<!-- /main navbar -->

<!-- Page content -->
<div class="page-content">

    <!-- Main sidebar -->
@include('clinic.layouts.sidebar')
<!-- /main sidebar -->

    <!-- Main content -->
    <div class="content-wrapper" style="    overflow: hidden;">

        <!-- Content area -->
    @yield('content')
    <!-- /content area -->

        <!-- Footer -->
    {{--		@include('clinic.layouts.footer')--}}
    <!-- /footer -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->
@yield('js_assets')
@yield('js_code')
</body>
</html>
