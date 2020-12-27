
            <div class="table-responsive" style="       min-height: 400px; background: white;border-radius: 20px;border: 1px solid #b3b3b3;">
                <table class="table">
                    <thead>

                    <tr>

                        <th class="numeric">رقم الحجز</th>
                        <th class="">اسم العميل</th>
                        <th class="">رقم الجوال</th>
                        <th class="">المبلغ المتبقي</th>
                        <th class="">الخدمة</th>
                        <th class="">وقت وتاريخ الموعد</th>
                        <th class="">حالة الحجز</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($todayReservations as $reservation)

                        <tr @if(session('id') === $reservation->id)class="bg-green" @endif>
                            <td>{{$reservation->display_id}}</td>
                            <td>{{$reservation->app_user->name ?? '--'}}</td>
                            <td>{{$reservation->app_user->mobile ?? '--'}}</td>
                            <td>{{$reservation->remained_value ?? '--'}}</td>
                            <td>{{$reservation->service->name_ar ?? '--'}}</td>
                            <td>{{\Carbon\Carbon::parse($reservation->appointment_date)->translatedFormat('l').': '.$reservation->appointment_date.' '.$reservation->appointment_time }}</td>
                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ اجراء</a>

                                <div class="dropdown-menu dropdown-menu-lg">

                                <a class="dropdown-item" data-placement="top" title="{{$reservation->status == 0 || $reservation->status == 2 ? 'موافقة ونشر' : 'رفض واخفاء'}}" href="javascript:void(0)"
                                   onclick="approve_item('{{$reservation->id}}','{{$reservation->name}}')" data-toggle="modal"
                                   data-target="#delete_item_modal"><i class="{{$reservation->status == 0 || $reservation->status == 2 ? 'icon-check2' : 'icon-cross3'}} "></i>{{$reservation->status == 0 || $reservation->status == 2 ? 'موافقة ونشر' : 'رفض واخفاء'}}</a>

                                </div>
                            </td>

                        </tr>

                    @endforeach
                    @if(count($todayReservations) == 0)
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


