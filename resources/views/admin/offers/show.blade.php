@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">عرض تفاصيل العرض </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{route('offers.acceptance')}}" class="breadcrumb-item">العروض</a>
                    <span class="breadcrumb-item active">عرض</span>
                </div>

            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">تفاصيل العرض</h5>

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


                <form class="rated" action="{{route('clinics.update',$offer->id)}}" method="post"
                      enctype="multipart/form-data">
                    @method('put')

                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="name">الاسم</label>
                                <input type="text" class="form-control" disabled id="clinic_name_ar"
                                       name="clinic_name_ar"
                                       value="{{$offer->name_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name"> العيادة</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$offer->clinic->name_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">القسم</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$offer->section->title_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">السعر قبل</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$offer->price_before}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">السعر بعد</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$offer->price_after}}">
                            </div>
                        </div>
                        <div class="col-6 ">
                            <div class="form-group">
                                <label class="control-label" for="name">الوصف</label>
                                <textarea name="" id="" rows="5" disabled
                                          class="form-control">{{$offer->description_ar}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">التعليمات</label>
                                <textarea name="" id="" rows="5" disabled
                                          class="form-control">{{$offer->instructions_ar}}</textarea>

                            </div>


                        </div>

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
