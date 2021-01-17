
            <div class="table-responsive">
                <table class="table">
                    <thead>

                    <tr>

                        <th class="numeric">رقم الحجز</th>
                        <th class="">اسم العميل</th>
                        <th class="">رقم الجوال</th>
                        <th class="">الخدمة</th>
                        <th class="">وقت وتاريخ الموعد</th>
                        <th class="">سبب الالغاء</th>
                        <th class="">التحكم</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($clinic->rejectedReservationsByClinic as $reservation)
                        <tr @if(session('id') === $reservation->id)class="bg-green" @endif>
                            <td>{{$reservation->display_id}}</td>
                            <td>{{$reservation->app_user->name ?? '--'}}</td>
                            <td>{{$reservation->app_user->mobile ?? '--'}}</td>
                            <td>{{$reservation->service->name_ar ?? '--'}}</td>
                            <td>{{\Carbon\Carbon::parse($reservation->appointment_date)->translatedFormat('l').': '.$reservation->appointment_date.' '.$reservation->appointment_time }}</td>

                            <td>
                                {{$reservation->reason ?? '--'}}
                            </td>
                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ اجراء</a>

                                <div class="dropdown-menu dropdown-menu-lg">
                                    <a class="dropdown-item " data-placement="top" title="#"
                                       href="#"
                                    ><i class="icon-eye"></i>#</a>


                                </div>



                            </td>
                        </tr>


                    @endforeach
                    @if(count($clinic->rejectedReservationsByClinic) == 0)
                        <tr>
                            <td colspan="6" class="text-center">
                                لا يوجد بيانات
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
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


