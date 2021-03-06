@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">تعديل الاعدادات </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">الاعدادات</span>
                </div>

            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">

            </div>

            <div class="card-body">


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form class="rated" action="{{route('settings.update',0)}}" method="post"
                      enctype="multipart/form-data">
                    @method('put')

                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-6 ">

{{--                            <div class="form-group  d-none">--}}
{{--                                <label class="control-label" for="name">Order fees amount</label>--}}
{{--                                <input type="number" class="form-control" id="value" name="value" value="{{$order_fees->value}}">--}}
{{--                            </div>--}}
                            <div class="form-group ">
                                <label class="control-label" for="name">رقم واتس اب التواصل</label>
                                <input type="number" class="form-control" id="whatsapp" name="whatsapp" value="{{$whatsapp->value}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">الدفعة المقدمة (العربون)</label>
                                <input type="number" class="form-control" id="advance_payment" name="advance_payment" value="{{$advance_payment->value}}">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">

                        <button class="btn btn-success">حفظ</button>

                    </div>

                </form>
            </div>
        </div>


    </div>
@endsection
@section('js_assets')
@endsection
@section('js_code')
@endsection
