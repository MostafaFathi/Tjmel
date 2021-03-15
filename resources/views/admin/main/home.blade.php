@extends('admin.layouts.app')
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
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">الرئيسية</span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">الاحصائيات</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">


                </div>
            </div>
        </div>
    </div>
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

        <div class="row">
            @hasanyrole('admin')
            <div class="col-sm-6 col-xl-4">
                <div class="card card-body">
                    <div class="media">
                        <div class="media-body" style="">
                            <h6 class="media-title font-weight-semibold">عدد مستخدمين التطبيق</h6>
                            <h3><b>{{$appUsers}}</b></h3>

                        </div>
                    </div>
                </div>
            </div>
            @endhasanyrole
            <div class="col-sm-6 col-xl-4">
                <div class="card card-body">
                    <div class="media">
                        <div class="media-body" style="">
                            <h6 class="media-title font-weight-semibold">عدد العيادات</h6>
                            <h3><b>{{$clinicCount}}</b></h3>

                        </div>
                    </div>
                </div>
            </div>
            @hasanyrole('admin')
            <div class="col-sm-6 col-xl-4">
                <div class="card card-body">
                    <div class="media">
                        <div class="media-body" style="">
                            <h6 class="media-title font-weight-semibold">عدد طلبات العيادات</h6>
                            <h3><b>{{$clinicRequestCount}}</b></h3>

                        </div>
                    </div>
                </div>
            </div>
            @endhasanyrole

        </div>

        <div class="row">
            <div class="col-sm-6 col-xl-4">
                <div class="card card-body bg-blue-400 has-bg-image">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">{{$dailyIncome??''}}</h3>
                            <span class="text-uppercase font-size-xs font-weight-bold">الدخل اليومي</span>
                        </div>

                        <div class="ml-3 align-self-center">
                            <i class="icon-coins icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card card-body bg-success-400 has-bg-image">
                    <div class="media">
                        <div class="media-body ">
                            <h3 class="mb-0">{{$monthlyIncome??''}}</h3>
                            <span class="text-uppercase font-size-xs font-weight-bold">الدخل الشهري</span>
                        </div>

                        <div class="mr-3 align-self-center">
                            <i class="icon-coin-dollar icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card card-body bg-danger-400 has-bg-image">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">{{$yearlyIncome??''}}</h3>
                            <span class="text-uppercase font-size-xs font-weight-bold">الدخل السنوي</span>
                        </div>

                        <div class="ml-3 align-self-center">
                            <i class="icon-cash icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            @hasanyrole('admin')
            <div class="col-sm-12 col-xl-12">
                <div class="card card-body  has-bg-image">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>اسم العيادة</th>
                            <th>الدخل اليومي</th>
                            <th>الدخل الشهري</th>
                            <th>الدخل السنوي</th>
                            <th>حجوزات مكتملة</th>
                            <th>حجوزات غير مكتملة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clinicIncomeArray ?? [] as $item)
                            <tr>
                                <td>
                                    <a title="Show"
                                       href="{{route('clinics.show',$item->clinic_id)}}">{{$item->clinic_name}}</a>
                                </td>
                                <td><span class="badge badge-info">{{$item->daily}} ر.س.</span></td>
                                <td><span class="badge badge-info">{{$item->monthly}} ر.س.</span></td>
                                <td><span class="badge badge-info">{{$item->yearly}} ر.س.</span></td>
                                <td><span class="badge badge-success">{{$item->completedReservations}}</span></td>
                                <td><span class="badge badge-warning">{{$item->unCompletedReservations}}</span></td>

                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @endhasanyrole
        </div>
    </div>
@endsection

@section('js_code')


@endsection
