@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">تعديل تفاصيل الخدمة </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسيى</a>
                    <a href="{{route('services.acceptance')}}" class="breadcrumb-item">الخدمات</a>
                    <span class="breadcrumb-item active">تعديل</span>
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


                <form class="rated" action="{{route('admin.services.update',$service->id)}}" method="post"
                      enctype="multipart/form-data">
                    @method('put')

                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="name">الاسم</label>
                                <input type="text" class="form-control"  id="name_ar"
                                       name="name_ar"
                                       value="{{$service->name_ar}}">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="name">القسم</label>
                                <select name="section_id" required id="section_id" class="form-control"
                                        style="">
                                    <option value="">إختر</option>
                                    @foreach($sections as $section)
                                        <option
                                            value="{{$section->id}}" {{$section->id == $service->section->id ? 'selected' : ''}}>{{$section->title_ar}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">السعر</label>
                                <input  type="text" class="form-control" id="price" name="price"
                                       value="{{$service->price}}">
                            </div>
                        </div>
                        <div class="col-6 ">
                            <div class="form-group">
                                <label class="control-label" for="name">الوصف</label>
                                <textarea name="description_ar" id="" rows="5"
                                          class="form-control">{{$service->description_ar}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">التعليمات</label>
                                <textarea name="instructions_ar" id="" rows="5"
                                          class="form-control">{{$service->instructions_ar}}</textarea>

                            </div>


                        </div>

                    </div>
                    <div class="form-group" style="text-align: left;">

                        <button class="btn btn-success">حفظ التغييرات</button>

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
