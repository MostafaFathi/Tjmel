@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">الحجوزات</span></h4>
            </div>

        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="#" class="breadcrumb-item">الحجوزات</a>

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
                    <input type="text" class="form-control" autocomplete="chrome-off" name="clinic_name_ar"
                           value="{{request()->get('clinic_name_ar')}}"
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
                                          id="addon-wrapping">حالة الحجز</span>
                                </div>
                                <select name="reservation_status" class="form-control" id="">
                                    <option value="" {{request()->get('reservation_status') == 0 ? 'selected' : ''}}>إختر</option>
                                    <option value="5" {{request()->get('reservation_status') == 5 ? 'selected' : ''}}>تم الحجز</option>
                                    <option value="1" {{request()->get('reservation_status') == 1 ? 'selected' : ''}}>مكتمل</option>
                                    <option value="2" {{request()->get('reservation_status') == 2 ? 'selected' : ''}}>غير مكتمل عدم حضور العميل</option>
                                    <option value="3" {{request()->get('reservation_status') == 3 ? 'selected' : ''}}>إلغاء من العيادة</option>
                                    <option value="4" {{request()->get('reservation_status') == 4 ? 'selected' : ''}}>إلغاء من العميل</option>
                                </select>
                            </div>

                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">اسم العميل</span>
                                </div>
                                <input type="text" class="form-control" autocomplete="chrome-off" name="user_name"
                                       value="{{request()->get('user_name')}}"
                                       aria-describedby="addon-wrapping">
                            </div>

                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">رقم جوال العميل</span>
                                </div>
                                <input type="text" class="form-control" name="phone"
                                       value="{{request()->get('phone')}}"
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
                <table class="table" id="reservation_tb" style="{{count($reservations) > 0 ? 'width: max-content;' : ''}}">
                    <thead>

                    <tr>

                        <th class="numeric">رقم الحجز</th>
                        <th class="" style="max-width: 250px">اسم العميل</th>
                        <th class="">رقم الجوال</th>
                        <th class="" style="max-width: 250px">العيادة</th>
                        <th class="" style="max-width: 250px">الخدمة</th>
                        <th class="">وقت وتاريخ الحجز</th>
                        <th class="">موعد الحجز</th>
                        <th class="">حالة الحجز</th>
                        <th class="" style="max-width: 250px">سبب الالغاء</th>
                        <th class="">التحكم</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($reservations as $reservation)
                        <tr style="background-color:{{$reservation->status_color}}">
                            <td>{{$reservation->display_id}}</td>
                            <td style="max-width: 250px">{{$reservation->app_user->name ?? '--'}}</td>
                            <td>{{$reservation->app_user->mobile ?? '--'}}</td>
                            <td style="max-width: 250px">{{$reservation->clinic->name_ar ?? '--'}}</td>
                            <td style="max-width: 200px">{{$reservation->service->name_ar ?? '--'}}</td>
                            <td>{{\Carbon\Carbon::parse($reservation->created_at)}}</td>
                            <td>{{$reservation->appointment_date}} {{$reservation->appointment_time}}</td>

                            <td>
                                {{$reservation->status_name ?? ""}}
                            </td>
                            <td style="max-width: 200px">
                                {{$reservation->reason ?? "--"}}
                            </td>
                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ اجراء</a>

                                <div class="dropdown-menu dropdown-menu-lg">
                                    <a class="dropdown-item" data-placement="top" title="مكتمل" href="javascript:void(0)"
                                       onclick="approve_item_reservation('{{$reservation->id}}',1,'إكتمال الحجز','تغيير حالة الحجز لمكتمل')"
                                       data-toggle="modal"
                                       data-target="#change_status_item_modal"><i class="icon-task"></i>مكتمل</a>

                                    <a class="dropdown-item" data-placement="top" title="غير مكتمل - عدم حضور العميل"
                                       href="javascript:void(0)"
                                       onclick="approve_item_reservation('{{$reservation->id}}',2,'حجز غير مكتمل','تغيير حالة الحجز لغير مكتمل')"
                                       data-toggle="modal"
                                       data-target="#change_status_item_modal"><i class="icon-alignment-aligned-to"></i>غير مكتمل -
                                        عدم حضور العميل</a>

                                    <a class="dropdown-item" data-placement="top" title="إلغاء الحجز" href="javascript:void(0)"
                                       onclick="approve_item_reservation('{{$reservation->id}}',3,'إلغاء الحجز','إلغاء الحجز سيظهر انه تم الغاءه من العيادة')"
                                       data-toggle="modal"
                                       data-target="#change_status_item_modal"><i class="icon-user-cancel"></i>إلغاء الحجز</a>


                                </div>



                            </td>
                        </tr>


                    @endforeach
                    @if(count($reservations) == 0)
                        <tr>
                            <td colspan="10" class="text-center">
                                لا يوجد بيانات
                            </td>
                        </tr>
                    @endif
                    @if(count($reservations) > 0)
                        <tr>
                            <td colspan="10" class="text-center">
                                {{ $reservations->appends(request()->all())->links() }}
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <!-- /basic table -->
            {{----}}
            <div id="change_status_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="reservation_form" method="post" action="">
                            @csrf
                            <input name="id" id="item_id1" class="form-control" type="hidden">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <h4 id="modalDescription">تأكيد الموافقة/الرفض للخدمة</h4>
                                <div class="form-group">
                                    <label class="control-labell" for="">تعليق</label>
                                    <textarea name="comment" id="comment"  rows="3" class="form-control"></textarea>
                                </div>
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
        $(document).on('mousemove','#reservation_tb tr td',function () {
            if ($(this).index() >= 4){
                $(".table-responsive").scrollLeft(-10000);
            }else{
                $(".table-responsive").scrollLeft(0);
            }
        });
        function approve_item_reservation(id, status, title, description) {
            $('#item_id1').val(id);
            var url = "{{url('admin/reservations/')}}/" + id + "/status/" + status;
            $('#reservation_form').attr('action', url);
            $('#myModalLabel').text(title);
            $('#modalDescription').html(description);
        }

    </script>

@endsection

