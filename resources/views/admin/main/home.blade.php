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
        @hasanyrole('admin|user')
        @can('Show Dashboard')
            <div class="row">

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
                <div class="col-sm-6 col-xl-4">
                    <div class="card card-body">
                        <div class="media">
                            <div class="media-body" style="">
                                <h6 class="media-title font-weight-semibold">إجمالي الخدمات</h6>
                                <h3><b>{{$services}}</b></h3>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="card card-body">
                        <div class="media">
                            <div class="media-body" style="">
                                <h6 class="media-title font-weight-semibold">إجمالي العروض</h6>
                                <h3><b>{{$offers}}</b></h3>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="card card-body">
                        <div class="media">
                            <div class="media-body" style="">
                                <h6 class="media-title font-weight-semibold">إجمالي الحجوزات</h6>
                                <h3><b>{{$totalReservations}}</b></h3>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="card card-body">
                        <div class="media">
                            <div class="media-body" style="">
                                <h6 class="media-title font-weight-semibold">إجمالي الحجوزات النشطة</h6>
                                <h3><b>{{$totalComingReservations}}</b></h3>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="card card-body">
                        <div class="media">
                            <div class="media-body" style="">
                                <h6 class="media-title font-weight-semibold">إجمالي الحجوزات المكتملة</h6>
                                <h3><b>{{$totalCompletedReservations}}</b></h3>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="card card-body">
                        <div class="media">
                            <div class="media-body" style="">
                                <h6 class="media-title font-weight-semibold">إجمالي الحجوزات الغير المكتملة</h6>
                                <h3><b>{{$totalUnCompletedReservations}}</b></h3>

                            </div>
                        </div>
                    </div>
                </div>


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
                <div class="col-sm-6 col-xl-6">
                    <div class="card card-body  has-bg-image" style="background: #38d038">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">{{$usersWallet??''}}</h3>
                                <span class="text-uppercase font-size-xs font-weight-bold">المبالغ المدفوعة</span>
                            </div>

                            <div class="ml-3 align-self-center">
                                <i class="icon-cash icon-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-6">
                    <div class="card card-body  has-bg-image" style="background: #38a0d0">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">{{$usersPaidWallet??''}}</h3>
                                <span class="text-uppercase font-size-xs font-weight-bold">المبالغ المصروفة</span>
                            </div>

                            <div class="ml-3 align-self-center">
                                <i class="icon-cash icon-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-xl-12">
                    <div class="card card-body  has-bg-image">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>اسم العيادة</th>
                                <th>الدخل اليومي</th>
                                <th>الدخل الشهري</th>
                                <th>الدخل السنوي</th>
                                <th>إجمالي الحجوزات</th>
                                <th> حجوزات نشطة</th>
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
                                    <td><span class="badge badge-danger">{{$item->totalReservations}}</span></td>
                                    <td><span class="badge badge-secondary">{{$item->totalComingReservations}}</span>
                                    </td>
                                    <td><span class="badge badge-success">{{$item->completedReservations}}</span></td>
                                    <td><span class="badge badge-warning">{{$item->unCompletedReservations}}</span></td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-12">
                    <div class="card card-body  has-bg-image">
                        <div class="table-responsive">
                            <table class="table" id="reservation_tb" style="">
                                <thead>
                                <tr>
                                    <th colspan="8">
                                        حجوزات ملغية من العيادة
                                    </th>
                                </tr>
                                <tr>

                                    <th class="numeric" scope="col">رقم الحجز</th>
                                    <th class="" style="max-width: 250px" scope="col">اسم العميل</th>
                                    <th class="" scope="col">رقم الجوال</th>
                                    <th class="" style="max-width: 250px" scope="col">الخدمة</th>
                                    <th class="" scope="col">وقت وتاريخ الموعد</th>
                                    <th class="" scope="col">حالة الحجز</th>
                                    <th class="" style="max-width: 250px" scope="col">سبب الالغاء</th>
                                    <th class="" scope="col">التحكم</th>

                                </tr>

                                </thead>

                                <tbody>


                                @foreach($canceledReservation as $reservation)
                                    <tr @if(session('id') === $reservation->id)class="bg-green" @endif>
                                        <td>{{$reservation->display_id}}</td>
                                        <td style="max-width: 250px">{{$reservation->app_user->name ?? '--'}}</td>
                                        <td>{{$reservation->app_user->mobile ?? '--'}}</td>
                                        <td style="max-width: 250px">{{$reservation->service->name_ar ?? '--'}}</td>
                                        <td>{{\Carbon\Carbon::parse($reservation->appointment_date)->translatedFormat('l').': '.$reservation->appointment_date.' '.$reservation->appointment_time }}</td>

                                        <td>
                                            {{$reservation->status_name ?? ""}}
                                        </td>
                                        <td style="max-width: 250px">
                                            {{$reservation->reason ?? "--"}}
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ
                                                اجراء</a>

                                            <div class="dropdown-menu dropdown-menu-lg">
                                                <a class="dropdown-item" data-placement="top" title="إرجاع العربون"
                                                   href="{{route('reservations.advance_payment.status',['id'=>$reservation->id,'status'=>1])}}"
                                                ><i class="icon-check2"></i>إرجاع العربون</a>
                                                <a class="dropdown-item" data-placement="top" title="عدم إرجاع العربون"
                                                   href="{{route('reservations.advance_payment.status',['id'=>$reservation->id,'status'=>2])}}"
                                                ><i class="icon-cross3"></i>عدم إرجاع العربون</a>

                                            </div>


                                        </td>
                                    </tr>


                                @endforeach
                                @if(count($canceledReservation) == 0)
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            لا يوجد بيانات
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        @endcan
        @endhasanyrole
        @cannot('Show Dashboard')
            <div class="row">
                <div class="card col-12 text-center">
                    <div class="card-body">
                        <h2>أهلا بكم في لوحة تحكم تجميل</h2>
                    </div>
                </div>
            </div>
        @endcannot
    </div>

@endsection

@section('js_code')


@endsection
