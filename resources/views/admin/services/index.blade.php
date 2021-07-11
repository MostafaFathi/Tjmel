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
        <form action="" method="get" class="submit-search-form form">
            <h5>البحث</h5>
            <div class="form-row">


                <div class="input-group col-3 mb-md-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">اسم الخدمة</span>
                    </div>
                    <input type="text" class="form-control" autocomplete="chrome-off" name="service_name"
                           value="{{request()->get('service_name')}}"
                           aria-describedby="addon-wrapping">
                </div>


                <input type="hidden" name="is_search_opened" class="is_search_opened"
                       value="{{request()->has('is_search_opened') ? request()->get('is_search_opened') : 0}}">

                <div class="collapse w-100 mb-3 {{request()->get('is_search_opened') == 1 ? 'show' : ''}}"
                     id="collapseExample">
                    <div class="card card-body">

                        <div class="form-row">

                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">اسم العيادة</span>
                                </div>
                                <input type="text" class="form-control" autocomplete="chrome-off" name="clinic_name_ar"
                                       value="{{request()->get('clinic_name_ar')}}"
                                       aria-describedby="addon-wrapping">
                            </div>
                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">حالة العرض</span>
                                </div>
                                <select name="service_status" class="form-control" id="">
                                    <option value="100" {{request()->has('service_status') && request()->get('service_status') == 100 ? 'selected' : ''}}>إختر</option>
                                    <option value="0" {{request()->has('service_status') && request()->get('service_status') == 0 ? 'selected' : ''}}>قيد الانتظار</option>
                                    <option value="1" {{request()->has('service_status') && request()->get('service_status') == 1 ? 'selected' : ''}}>تم نشره</option>
                                    <option value="2" {{request()->has('service_status') && request()->get('service_status') == 2 ? 'selected' : ''}}>مرفوض</option>
                                </select>
                            </div>
                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">القسم</span>
                                </div>
                                <select name="section_id" class="form-control" id="">
                                    <option value="" {{request()->get('section_id') == 0 ? 'selected' : ''}}>إختر</option>
                                    @foreach($sections as $section)
                                        <option value="{{$section->id}}" {{request()->get('section_id') == $section->id ? 'selected' : ''}}>{{$section->title_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group col-5 mb-md-5">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">السعر</span>
                                </div>
                                <select id="role" style="border-radius: 0" name="operation" class="form-control col-4">
                                    <option value="" >اختر</option>
                                    <option value="=" {{request()->get('operation') == "=" ? 'selected' : ''}}>يساوي</option>
                                    <option value=">" {{request()->get('operation') == ">" ? 'selected' : ''}}> أكبر </option>
                                    <option value="<" {{request()->get('operation') == "<" ? 'selected' : ''}}> أصغر </option>
                                    <option value=">=" {{request()->get('operation') == ">=" ? 'selected' : ''}}> أكبر او يساوي </option>
                                    <option value="<=" {{request()->get('operation') == "<=" ? 'selected' : ''}}> أصغر او يساوي </option>
                                </select>
                                <input type="text" class="form-control" autocomplete="chrome-off" name="price"
                                       value="{{request()->get('price')}}"
                                       aria-describedby="addon-wrapping">
                            </div>
                        </div>


                    </div>

                </div>


                <div class="input-group-append col-2 mb-md-3">
                    <button class="btn btn-success mr-1 " type="submit">بحث</button>
                    <button class="btn btn-success mr-1 search-advanced" type="button" data-toggle="collapse"
                            data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        متقدم
                    </button>
                </div>

                <div
                    class="input-group-append {{request()->get('is_search_opened') == 1 ? 'col-10' : 'col-7'}} mb-md-3 export-div">


                </div>


            </div>
        </form>
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
                            <td>
                                <a title="عرض"
                                   href="{{route('admin.services.show',$service->id)}}"
                                >{{$service->name_ar}}</a>
                                </td>
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

                                <a class="dropdown-item " data-placement="top" title="تعديل"
                                   href="{{route('admin.services.edit',$service->id)}}"
                                  ><i class="icon-pencil7"></i>تعديل</a>

                                    <a class="dropdown-item" data-placement="top" title="حذف" href="javascript:void(0)"
                                       onclick="delete_item('{{$service->id}}','{{$service->name}}')" data-toggle="modal"
                                       data-target="#delete_item_modal"><i class="icon-cross3"></i>حذف</a>

                                <a class="dropdown-item" data-placement="top" title="{{$service->status == 0 || $service->status == 2 ? 'موافقة ونشر' : 'رفض واخفاء'}}" href="javascript:void(0)"
                                   onclick="approve_item('{{$service->id}}','{{$service->name}}')" data-toggle="modal"
                                   data-target="#approve_item_modal"><i class="{{$service->status == 0 || $service->status == 2 ? 'icon-check2' : 'icon-blocked'}} "></i>{{$service->status == 0 || $service->status == 2 ? 'موافقة ونشر' : 'رفض واخفاء'}}</a>

                                </div>



                            </td>

                        </tr>

                    @endforeach
                    <tr>
                        <td colspan="7" class="text-center">
                            {{ $services->appends(request()->all())->links() }}

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
                    <form id="delete_form_delete" method="post" action="">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input name="id" id="item_id_delete" class="form-control" type="hidden">
                        <input name="_method" type="hidden" value="DELETE">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">حذف الخدمة <span id="del_label_title_delete"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4>تأكيد حذف الخدمة</h4>
                            <p id="grup_title_delete"></p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-danger waves-effect" id="delete_url_delete">حذف</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->



        </div>


        <div id="approve_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
        $(document).on('click', '.search-advanced', function () {
            var is_search_opened = $('.is_search_opened').val();
            if (is_search_opened == '0') {
                is_search_opened = '1';
                $('.export-div').removeClass('col-7');
                $('.export-div').addClass('col-10');
            } else {
                $('.export-div').removeClass('col-10');
                $('.export-div').addClass('col-7');
                is_search_opened = '0';
            }

            $('.is_search_opened').val(is_search_opened);
            return false;
        });
        function delete_item(id, title) {
            $('#item_id_delete').val(id);
            var url = "<?php echo e(url('admin/services/delete')); ?>/" + id;
            $('#delete_form_delete').attr('action', url);
            $('#grup_title_delete').text(title);
            $('#del_label_title_delete').html(title);
        }
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

