@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">عرض تفاصيل الخدمة </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسيى</a>
                    <a href="{{route('services.acceptance')}}" class="breadcrumb-item">الخدمات</a>
                    <span class="breadcrumb-item active">عرض</span>
                </div>

            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">تفاصيل الخدمة</h5>

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


                <form class="rated" action="{{route('clinics.update',$service->id)}}" method="post"
                      enctype="multipart/form-data">
                    @method('put')

                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="name">الاسم</label>
                                <input type="text" class="form-control" disabled id="clinic_name_ar"
                                       name="clinic_name_ar"
                                       value="{{$service->name_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">العيادة</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$service->clinic->name_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">القسم</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$service->section->title_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">السعر</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$service->price}}">
                            </div>
                        </div>
                        <div class="col-6 ">
                            <div class="form-group">
                                <label class="control-label" for="name">الوصف</label>
                                <textarea name="" id="" rows="5" disabled
                                          class="form-control">{{$service->description_ar}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">التعليمات</label>
                                <textarea name="" id="" rows="5" disabled
                                          class="form-control">{{$service->instructions_ar}}</textarea>

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
