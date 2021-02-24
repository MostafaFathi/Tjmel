@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">طلبات العيادات</span></h4>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{route('applications.index')}}" class="breadcrumb-item">طلبات العيادات</a>

                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <!-- Basic table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead>

                    <tr>

                        <th class="numeric" style="width: 10%">#</th>
                        <th class="">الاسم</th>
                        <th class="">رقم الجوال</th>
                        <th class="">التاريخ</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($clinicRequests as $clinicRequest)

                        <tr @if(session('id') === $clinicRequest->id)class="bg-green" @endif>
                            <td>{{$loop->index + 1 }}</td>
                            <td >{{$clinicRequest->name_ar}}</td>
                            <td >{{$clinicRequest->phone}}</td>
                            <td >{{$clinicRequest->created_at}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-center">
                            {{ $clinicRequests->links() }}
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
        <!-- /basic table -->




    </div>
@endsection
