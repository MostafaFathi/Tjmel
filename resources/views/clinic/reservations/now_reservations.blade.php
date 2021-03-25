<div class="row" style="    padding: 0px 25px 12px 0px;">
    <input type="text" class="form-control col-5" id="now-reservations-search" name="price_after"
           value="{{old('search')}}">
    <i class="icon-search4" style="    padding: 12px;font-size: 25px;color: #cecece;"></i>
</div>
<div class="table-responsive"
     style="       min-height: 400px; background: white;border-radius: 20px;border: 1px solid #b3b3b3;">
    <table class="table">
        <thead>

        <tr>

            <th class="numeric">رقم الحجز</th>
            <th class="">اسم العميل</th>
            <th class="">رقم الجوال</th>
            <th class="">المبلغ المدفوع</th>
            <th class="">الخدمة</th>
            <th class="">وقت وتاريخ الموعد</th>
            <th class="">حالة الحجز</th>

        </tr>

        </thead>

        <tbody>


        @foreach($comingReservations as $reservation)

            <tr @if(session('id') === $reservation->id)class="bg-green" @endif>
                <td>{{$reservation->display_id}}</td>
                <td>{{$reservation->app_user->name ?? '--'}}</td>
                <td>{{$reservation->app_user->mobile ?? '--'}}</td>
                <td>{{$reservation->paid_value ?? '--'}}</td>
                <td>{{$reservation->service_type == 'service' ? $reservation->service->name_ar ?? '--' : $reservation->offer->name_ar ?? '--'}}</td>
                <td>{{\Carbon\Carbon::parse($reservation->appointment_date)->translatedFormat('l').': '.$reservation->appointment_date.' '.$reservation->appointment_time }}</td>
                <td>
                    @if($reservation->status == 5)
                        <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ اجراء</a>

                        <div class="dropdown-menu dropdown-menu-lg">


                            <a class="dropdown-item" data-placement="top" title="مكتمل" href="javascript:void(0)"
                               onclick="approve_item('{{$reservation->id}}',1,'إكتمال الحجز','تغيير حالة الحجز لمكتمل')"
                               data-toggle="modal"
                               data-target="#change_status_item_modal"><i class="icon-task"></i>مكتمل</a>

                            <a class="dropdown-item" data-placement="top" title="غير مكتمل - عدم حضور العميل"
                               href="javascript:void(0)"
                               onclick="approve_item('{{$reservation->id}}',2,'حجز غير مكتمل','تغيير حالة الحجز لغير مكتمل')"
                               data-toggle="modal"
                               data-target="#change_status_item_modal"><i class="icon-alignment-aligned-to"></i>غير
                                مكتمل - عدم حضور العميل</a>

                            <a class="dropdown-item" data-placement="top" title="إلغاء الحجز" href="javascript:void(0)"
                               onclick="approve_item('{{$reservation->id}}',3,'إلغاء الحجز','إلغاء الحجز سيظهر انه تم الغاءه من العيادة')"
                               data-toggle="modal"
                               data-target="#change_status_item_modal"><i class="icon-user-cancel"></i>إلغاء الحجز</a>

                        </div>
                    @else
                        {{$reservation->status_name}}
                    @endif
                </td>

            </tr>

        @endforeach
        @if(count($comingReservations) == 0)
            <tr>
                <td colspan="7" class="text-center">
                    لا يوجد بيانات
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>

<!-- /basic table -->
