<div class="row" style="    padding: 0px 25px 12px 0px;">
    <input type="text" class="form-control col-5" id="completed-reservations-search" name="price_after"
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

        </tr>

        </thead>

        <tbody>


        @foreach($completedReservations as $reservation)

            <tr @if(session('id') === $reservation->id)class="bg-green" @endif>
                <td>{{$reservation->display_id}}</td>
                <td>{{$reservation->app_user->name ?? '--'}}</td>
                <td>{{$reservation->app_user->mobile ?? '--'}}</td>
                <td>{{$reservation->paid_value ?? '--'}}</td>
                <td>{{$reservation->service_type == 'service' ? $reservation->service->name_ar ?? '--' : $reservation->offer->name_ar ?? '--'}}</td>
                <td>{{\Carbon\Carbon::parse($reservation->appointment_date)->translatedFormat('l').': '.$reservation->appointment_date.' '.$reservation->appointment_time }}</td>


            </tr>

        @endforeach
        @if(count($completedReservations) == 0)
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
