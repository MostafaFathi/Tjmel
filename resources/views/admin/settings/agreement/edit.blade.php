@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">اتفاقية المستخدم  </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                </div>

            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">اتفاقية المستخدم</h5>

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


                <form class="rated" action="{{route('agreement.update',$agreement->id ?? 0)}}" method="post"
                      enctype="multipart/form-data">
                    @method('put')

                    {{csrf_field()}}
                    <div class="row ">


                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="content_ar">المحتوى (عربي)</label>
                                <textarea rows="15" class="form-control" name="content_ar">{{$agreement->content_ar ?? ''}}</textarea>
                            </div>



                        </div>

                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="content_en">المحتوى (انجليزي)</label>
                                <textarea rows="15" class="form-control" name="content_en">{{$agreement->content_en ?? ''}}</textarea>
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
