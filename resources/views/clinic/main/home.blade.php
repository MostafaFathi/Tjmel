@extends('clinic.layouts.app')
@section('js_css_header')
    <script src="{{asset('portal/global_assets/js/plugins/visualization/echarts/echarts.min.js')}}"></script>

    <script src="{{asset('portal/global_assets/js/demo_charts/echarts/light/pies/pie_basic.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/demo_charts/echarts/light/pies/pie_donut.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/demo_charts/echarts/light/pies/pie_nested.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/demo_charts/echarts/light/pies/pie_rose.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/demo_charts/echarts/light/pies/pie_rose_labels.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/demo_charts/echarts/light/pies/pie_levels.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/demo_charts/echarts/light/pies/pie_timeline.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/demo_charts/echarts/light/pies/pie_multiple.js')}}"></script>
    <script src="{{asset('portal/global_assets/js/plugins/visualization/d3/d3.min.js')}}"></script>
@endsection
@section('content')

    <!-- Page header -->

    <!-- /page header -->


    <div class="content">
        <style>
            .gm-style-iw-d {
                overflow: auto !important;
            }

            .gm-style-iw {
                background: #f3ffe5 !important;
            }
        </style>
        <!-- Basic card -->

        <div class="row" style="padding: 100px;">
           <div class="col-md-12 text-center">
               <h1 style="    font-size: 100px;font-weight: bold;color: #583b6b">نُورت</h1>
               <p class="font-weight-bold mb-0" style="color: #707070">عیادتك عیادتنا ، وھدفنا نصیر جزء من نجاحكم</p>
               <p class="font-weight-bold mb-0" style="color: #707070">أختر من القائمة الیمنى المھمة المطلوبة</p>
           </div>
        </div>
    </div>
@endsection

@section('js_code')


@endsection
