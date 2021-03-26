@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">إدارة مستخدمي التطبيق</span></h4>
            </div>

        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="#" class="breadcrumb-item">إدارة مستخدمي التطبيق</a>

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

                        <th class="numeric">رقم</th>
                        <th class="">اسم العميل</th>
                        <th class="">رقم الجوال</th>
                        <th class="">المحفظة</th>
                        <th class="">تاريخ التسجيل</th>
                        <th class="">الحالة</th>
                        <th class="">التحكم</th>

                    </tr>

                    </thead>

                    <tbody>

                    @php($counter = request('page') == 1 || !request()->has('page') ? 1 : $pageCount * request('page') ?? 0)
                    @foreach($appUsers as $appUser)
                        <tr @if(session('id') === $appUser->id)class="bg-green" @endif>
                            <td>{{$counter++}}</td>
                            <td>{{$appUser->name ?? '--'}}</td>
                            <td>{{$appUser->mobile ?? '--'}}</td>
                            <td>{{$appUser->wallet ?? '--'}}</td>
                            <td>{{$appUser->created_at ?? '--'}}</td>
                            <td>
                                <span class="badge {{$appUser->status == 0 ? 'badge-success' : 'badge-danger'}}">
                                    {{$appUser->status_name ?? '--'}}
                                </span>
                            </td>


                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ
                                    اجراء</a>

                                <div class="dropdown-menu dropdown-menu-lg">
                                    @if($appUser->status === 0)
                                        <a class="dropdown-item" data-placement="top" title="حظر"
                                           href="{{route('app_users.status.change',$appUser->id)}}"
                                        ><i class="icon-blocked"></i>حظر</a>
                                    @else
                                        <a class="dropdown-item" data-placement="top" title="فك الحظر"
                                           href="{{route('app_users.status.change',$appUser->id)}}"
                                        ><i class="icon-undo"></i>فك الحظر</a>
                                    @endif

                                    <a class="dropdown-item" data-placement="top" title="التعديل على المحفظة"
                                       href="javascript:void(0)"
                                       onclick="approve_item_wallet('{{$appUser->id}}',{{$appUser->wallet}})"
                                       data-toggle="modal"
                                       data-target="#change_status_item_modal"><i class="icon-coin-dollar"></i>
                                        التعديل على المحفظة                                           </a>




                                </div>


                            </td>
                        </tr>


                    @endforeach
                    @if(count($appUsers) == 0)
                        <tr>
                            <td colspan="7" class="text-center">
                                لا يوجد بيانات
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="7" class="text-center">
                            {{ $appUsers->links() }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- /basic table -->
            {{----}}
            <div id="change_status_item_modal" class="modal fade" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="wallet_form" method="post" action="">
                            @csrf
                            <input name="id" id="item_id1" class="form-control" type="hidden">

                            <div class="modal-body">
                                <div class="form-group" style="margin-bottom: -0.75rem;">
                                    <label class="control-labell" for="">قيمة المحفظة</label>
                                    <input type="number" name="wallet" class="form-control wallet">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق
                                </button>
                                <button type="submit" class="btn btn-success waves-effect" id="delete_url">
                                    حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


        </div>
        <!-- /basic table -->
    {{----}}


    <!-- /.modal-dialog -->


    </div>
@endsection

@section('js_assets')
@endsection

@section('js_code')

    <script>

        function approve_item_wallet(id, value) {
            $('#item_id1').val(id);
            var url = "{{url('admin/app_users/')}}/" + id + "/wallet";
            $('#wallet_form').attr('action', url);
            $('.wallet').val(value);
        }

    </script>

@endsection

