@extends('clinic.layouts.app')

@section('content')



    <div class="content">

        <div class="card">
            <div class="card-body"
                 style="    background:white;border-radius: 30px;margin-top: 21px;">


                @if ($errors->any())
                    <div class="row">
                        <div class="col-4 " style="margin: 0 auto">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if (session('success'))
                    <div class="row">
                        <div class="col-4 " style="margin: 0 auto">
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @endif

                    <style>
                        .text-size-18{
                            font-size: 18px !important;
                        }
                        .text-size-28{
                            font-size: 28px !important;
                        }
                    </style>
                    <div class="row">
                        <div class="col-sm-6 col-xl-12 text-right" style="padding: 25px;">
                            <a class="btn btn-success" style="font-size: 18px;padding: 5px 30px;height: 50px;background: #4bec68;" target="_blank" href="https://api.whatsapp.com/send?phone=966569670978">
                                <i class="fab fa-whatsapp" style="font-size: 32px;margin-top: -18px;"></i>
                                <span style="margin-top: 8px;display: inline-block;">الدعم الفني المباشر</span>
                            </a>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xl-4">
                            <div class="card card-body  has-bg-image" style="min-height: 110px;background-color: #aeadaf;" >
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="mb-0 text-size-28">{{number_format($dailyIncome??'0',2)}} ر.س.</h3>
                                        <span class="text-uppercase font-size-xs font-weight-bold text-size-18" >الدخل اليومي</span>
                                    </div>

                                    <div class="ml-3 align-self-center">
                                        <i class="icon-coins icon-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-4">
                            <div class="card card-body bg-success-400 has-bg-image" style="min-height: 110px;">
                                <div class="media">
                                    <div class="media-body ">
                                        <h3 class="mb-0 text-size-28">{{number_format($monthlyIncome??'0',2)}} ر.س.</h3>
                                        <span class="text-uppercase font-size-xs font-weight-bold text-size-18">الدخل الشهري</span>
                                    </div>

                                    <div class="mr-3 align-self-center">
                                        <i class="icon-coin-dollar icon-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xl-4">
                            <div class="card card-body bg-danger-400 has-bg-image" style="min-height: 110px;">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="mb-0 text-size-28">{{number_format($yearlyIncome??'0',2)}} ر.س.</h3>
                                        <span class="text-uppercase font-size-xs font-weight-bold text-size-18">الدخل السنوي</span>
                                    </div>

                                    <div class="ml-3 align-self-center">
                                        <i class="icon-cash icon-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xl-12">
                            <div class="card card-body bg-danger-400 has-bg-image" style="background: #bebebe;min-height: 110px;">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="mb-0 text-size-28">{{$totalReservations}} </h3>
                                        <span class="text-uppercase font-size-xs font-weight-bold text-size-18">إجمالي عدد الحجوزات</span>
                                    </div>

                                    <div class="ml-3 align-self-center">
                                        <i class="icon-sigma icon-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xl-4">
                            <div class="card card-body  has-bg-image" style="min-height: 110px;background-color: #88d9e3;">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="mb-0 text-size-28">{{$comingReservations??'0'}}</h3>
                                        <span class="text-uppercase font-size-xs font-weight-bold text-size-18">عدد الحجوزات النشطة</span>
                                    </div>

                                    <div class="ml-3 align-self-center">
                                        <i class="icon-checkmark icon-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xl-4">
                            <div class="card card-body  has-bg-image" style="min-height: 110px;background-color: #b1d095;">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="mb-0 text-size-28">{{$completedReservations??'0'}}</h3>
                                        <span class="text-uppercase font-size-xs font-weight-bold text-size-18">عدد الحجوزات المكتملة</span>
                                    </div>

                                    <div class="ml-3 align-self-center">
                                        <i class="icon-checkmark-circle2 icon-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xl-4">
                            <div class="card card-body  has-bg-image" style="min-height: 110px;    background-color: #bd8c98;">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="mb-0 text-size-28">{{$unCompletedReservations??'0'}}</h3>
                                        <span class="text-uppercase font-size-xs font-weight-bold text-size-18">عدد الحجوزات الغير المكتملة</span>
                                    </div>

                                    <div class="ml-3 align-self-center">
                                        <i class="icon-cross3 icon-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>



    </div>
@endsection
@section('js_assets')


@endsection
@section('js_code')

@endsection
