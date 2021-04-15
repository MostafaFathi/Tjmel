
            <div class="table-responsive">
                <table class="table"  id="reservation_tb" style="width: max-content;">
                    <thead>

                    <tr>

                        <th class="numeric" scope="col">رقم الحجز</th>
                        <th class="" style="max-width: 250px" scope="col">اسم العميل</th>
                        <th class="" scope="col">رقم الجوال</th>
                        <th class="" style="max-width: 250px" scope="col">الخدمة</th>
                        <th class="" scope="col">وقت وتاريخ الموعد</th>
                        <th class="" scope="col">حالة الحجز</th>
                        <th class="" style="max-width: 250px" scope="col" >سبب الالغاء</th>
                        <th class="" scope="col">التحكم</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($clinic->reservations as $reservation)
                        <tr @if(session('id') === $reservation->id)class="bg-green" @endif>
                            <td>{{$reservation->display_id}}</td>
                            <td style="max-width: 250px">{{$reservation->app_user->name ?? '--'}}</td>
                            <td>{{$reservation->app_user->mobile ?? '--'}}</td>
                            <td style="max-width: 250px">{{$reservation->service->name_ar ?? '--'}}</td>
                            <td>{{\Carbon\Carbon::parse($reservation->appointment_date)->translatedFormat('l').': '.$reservation->appointment_date.' '.$reservation->appointment_time }}</td>

                            <td>
                                {{$reservation->status_name ?? ""}}
                                <span style="display: none">{{request('message') ?? ''}}</span>
                            </td>
                            <td style="max-width: 250px">
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
                    @if(count($clinic->reservations) == 0)
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


