@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">بياناتي</span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="#" class="breadcrumb-item">بياناتي</a>
                    <span class="breadcrumb-item active">{{auth()->user()->name}}</span>
                </div>

            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">الملف الشخصي</h5>

            </div>

            <div class="card-body">

                @if(session()->has('success'))
                    <div class="alert alert-success">
                        تم تحديث البيانات بنجاح
                    </div>
                @endif
                <form class="rated" action="{{route('profile.update')}}" method="post"
                      enctype="multipart/form-data">
                    @method('put')

                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-5 ">


                            <div class="form-group">
                                <label class="control-label" for="name">الاسم (عربي)</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar" value="{{auth()->user()->name_ar ?? auth()->user()->name}}">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="name">الاسم (انجليزي)</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" value="{{auth()->user()->name_en ?? auth()->user()->name}}">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="name">العنوان</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{auth()->user()->address}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="email">البريد الالكتروني</label>
                                <input type="text" class="form-control" id="email" name="email"
                                       value="{{auth()->user()->email}}">
                            </div>



                            <div class="form-group">
                                <label class="control-label" for="mobile">رقم الجوال</label>
                                <input type="text" class="form-control" id="mobile" name="mobile"
                                       value="{{auth()->user()->mobile}}">
                            </div>

                            <div class="form-group">
                                <a class="btn btn-primary collapsed" data-toggle="collapse" href="#collapse-link-collapsed" aria-expanded="false">
                                    هل تريد تغيير كلمة السر?
                                </a>
                                <div class="collapse" id="collapse-link-collapsed" style="">
                                    <div class="mt-3">
                                        <label class="control-label" for="password">كلمة السر الجديدة</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                    <div class="form-group">

                        <button class="btn btn-success">حفظ التغييرات</button>

                    </div>

                </form>
            </div>
        </div>


    </div>
@endsection
