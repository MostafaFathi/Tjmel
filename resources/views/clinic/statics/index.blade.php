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
                        <div class="col-sm-6 col-xl-6">
                            <div class="card card-body  has-bg-image" style="min-height: 150px;background-color: #aeadaf;" >
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
                        <div class="col-sm-6 col-xl-6">
                            <div class="card card-body bg-success-400 has-bg-image" style="min-height: 150px;">
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
                        <div class="col-sm-12 col-xl-12">
                            <div class="card card-body bg-danger-400 has-bg-image" style="min-height: 150px;">
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
                        <div class="col-sm-6 col-xl-6">
                            <div class="card card-body  has-bg-image" style="min-height: 150px;background-color: #b1d095;">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="mb-0 text-size-28">{{$completedReservations??'0'}}</h3>
                                        <span class="text-uppercase font-size-xs font-weight-bold text-size-18">عدد الحجوزات المكتملة</span>
                                    </div>

                                    <div class="ml-3 align-self-center">
                                        <i class="icon-checkmark icon-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-6">
                            <div class="card card-body  has-bg-image" style="min-height: 150px;    background-color: #bd8c98;">
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
