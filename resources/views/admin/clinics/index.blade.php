@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">العيادات</span></h4>
            </div>
            <div class="header-elements">
                <a type="button" class="btn btn-primary" href="{{route('clinics.create')}}">عيادة جديدة</a>
            </div>

        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{route('clinics.index')}}" class="breadcrumb-item">العيادات</a>

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
                        <span class="input-group-text" id="addon-wrapping">اسم العيادة</span>
                    </div>
                    <input type="text" class="form-control" autocomplete="chrome-off" name="name_ar"
                           value="{{request()->get('name_ar')}}"
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
                                          id="addon-wrapping">المدينة - الحي</span>
                                </div>
                                <input type="text" class="form-control" autocomplete="chrome-off" name="city_district"
                                       value="{{request()->get('city_district')}}"
                                       aria-describedby="addon-wrapping">
                            </div>

                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">المستخدم</span>
                                </div>
                                <input type="text" class="form-control" autocomplete="chrome-off" name="user_name"
                                       value="{{request()->get('user_name')}}"
                                       aria-describedby="addon-wrapping">
                            </div>

                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">رقم الجوال</span>
                                </div>
                                <input type="text" class="form-control" name="phone"
                                       value="{{request()->get('phone')}}"
                                       aria-describedby="addon-wrapping">
                            </div>


                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">البريد الالكتروني</span>
                                </div>
                                <input type="text" class="form-control" autocomplete="chrome-off" name="email"
                                       value="{{request()->get('email')}}"
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
                        <th class="">الشعار</th>
                        <th class="">الإسم</th>
                        <th class="">المدينة - الحي</th>
{{--                        <th class=""></th>--}}
                        <th class="">المستخدم</th>
                        <th class="">التحكم</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($clinics as $clinic)

                        <tr @if(session('id') === $clinic->id)class="bg-green" @endif>
                            <td>{{$clinic->id}}</td>
                            <td><img src="{{$clinic->logo}}" alt="" style="width: 60px;border-radius: 8px"></td>
                            <td><a title="Show" href="{{route('clinics.show',$clinic->id)}}">{{$clinic->name_ar}}</a>
                                  @if(session('id') === $clinic->id) | updated @endif</td>
                            <td>{{$clinic->city_district ?? '--'}}</td>
                            <td>{{$clinic->user->name_ar ?? '--'}}</td>
                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">إتخذ اجراء</a>

                                <div class="dropdown-menu dropdown-menu-lg">
                                <a class="dropdown-item " data-placement="top" title="Show"
                                   href="{{route('clinics.show',$clinic->id)}}"
                                  ><i class="icon-eye"></i>عرض</a>

                                <a class="dropdown-item" data-placement="top" title="حذف" href="javascript:void(0)"
                                   onclick="delete_item('{{$clinic->id}}','{{$clinic->name}}')" data-toggle="modal"
                                   data-target="#delete_item_modal"><i class="icon-cross3"></i>حذف</a>

                                <a class="dropdown-item" data-toggle="tooltip" data-placement="top" title="تعديل"
                                   href="{{route('clinics.edit',$clinic->id)}}"><i class="icon-pencil7"></i>تعديل</a>

                                </div>



                            </td>

                        </tr>

                    @endforeach
                    <tr>
                        <td colspan="7" class="text-center">
                            {{ $clinics->links() }}
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
                        {{ method_field('DELETE') }}
                        <input name="id" id="item_id" class="form-control" type="hidden">
                        <input name="_method" type="hidden" value="DELETE">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">حذف عيادة <span id="del_label_title"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4>تأكيد حذف العيادة</h4>
                            <p id="grup_title"></p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-danger waves-effect" id="delete_url">حذف</button>
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
            $('#item_id').val(id);
            var url = "{{url('admin/clinics')}}/" + id;
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

