@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">الخدمات</span></h4>
            </div>

        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{route('services.acceptance')}}" class="breadcrumb-item">الخدمات</a>

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

                        <th class="numeric">#</th>
                        <th class="">عنوان الخدمة</th>
                        <th class="">العيادة</th>
                        <th class="">القسم</th>
                        <th class="">السعر</th>
                        <th class="">الحالة</th>
                        <th class="">التحكم</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($services as $service)

                        <tr @if(session('id') === $service->id)class="bg-green" @endif>
                            <td>{{$service->id}}</td>
                            <td>{{$service->name_ar}}</td>
                            <td>{{$service->clinic->name_ar ?? '--'}}</td>
                            <td>{{$service->section->title_ar ?? '--'}}</td>
                            <td>{{$service->price ?? '--'}}</td>
                            <td><span class="badge badge-{{$service->status_color}}">{{$service->status_name}}</span></td>
                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ اجراء</a>

                                <div class="dropdown-menu dropdown-menu-lg">
                                <a class="dropdown-item " data-placement="top" title="عرض"
                                   href="{{route('admin.services.show',$service->id)}}"
                                  ><i class="icon-eye"></i>عرض</a>

                                <a class="dropdown-item" data-placement="top" title="{{$service->status == 0 || $service->status == 2 ? 'موافقة ونشر' : 'رفض واخفاء'}}" href="javascript:void(0)"
                                   onclick="approve_item('{{$service->id}}','{{$service->name}}')" data-toggle="modal"
                                   data-target="#delete_item_modal"><i class="{{$service->status == 0 || $service->status == 2 ? 'icon-check2' : 'icon-cross3'}} "></i>{{$service->status == 0 || $service->status == 2 ? 'موافقة ونشر' : 'رفض واخفاء'}}</a>

                                </div>



                            </td>

                        </tr>

                    @endforeach
                    <tr>
                        <td colspan="7" class="text-center">
                            {{ $services->links() }}
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- /basic table -->
        {{----}}
        <div id="delete_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="delete_form" method="post" action="">
                        @csrf
                        <input name="id" id="item_id" class="form-control" type="hidden">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">موافقة/رفض الخدمة <span id="del_label_title"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4>تأكيد الموافقة/الرفض للخدمة</h4>
                            <p id="grup_title"></p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-success waves-effect" id="delete_url">حفظ الحالة الجديدة</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->



        </div>


        <!-- /.modal-dialog -->



    </div>
@endsection

@section('js_assets')
@endsection

@section('js_code')

    <script>

        function approve_item(id, title) {
            $('#item_id').val(id);
            var url = "{{url('admin/clinics/services/approve')}}/" + id;
            $('#delete_form').attr('action', url);
            $('#grup_title').text(title);
            $('#del_label_title').html(title);
        }


        $('#LinkNotModal').on('show.bs.modal', function (event) {

            //linking_url
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            var hash = button.data('hash') // Extract info from data-* attributes
            var url = button.attr('href') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('.modal-title').html('<b>' + title + '</b>')
            modal.find('.modal-footer .Delete-Action').attr('href', url)

            $('#linking_url').val('{{url('api/link_mobile')}}?user_id=' + hash);
            $('#url_span').text('{{url('api/link_mobile')}}?user_id=' + hash);

            console.log(hash);

        });

    </script>

@endsection

