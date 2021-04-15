<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Data\Tip;
use App\Models\Service\Appointment;
use App\Models\Service\Reserve;
use App\Traits\Location;
use App\Traits\SmsSender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ReservationController extends Controller
{
    use Location, SmsSender;

    public function showUserReservations()
    {
        if (auth('sanctum')->user()->id == 1 or auth('sanctum')->user()->id == 2)
            return response()->json(['message' => 'لا يمكن للزائر عرض الحجوزات'], 422);

        $reservations = auth('sanctum')->user()->reservations->whereIn('status',[1,5]);

        $tip = Tip::orderBy('id', 'desc')->first();
        $tipImage = $tip->image_url ?? '';

        return response()->json(['data' => Arr::flatten($reservations), 'tip_image' => $tipImage], 200);
    }

    public function cancelReserve(Request $request, $id)
    {
        $reservation = auth('sanctum')->user()->reservations->where('id', $id)->first();
        if (!$reservation)
            return response()->json(['message' => 'لا يوجد حجز بهذا الرقم'], 422);

        $isCanceledBefore = auth('sanctum')->user()->reservations->where('id', $id)->where('status', 4)->first();
        if ($isCanceledBefore)
            return response()->json(['message' => 'تم إلغاء الحجز مسبقاً'], 422);

        $reservation->status = 4;
        $reservation->reason = 'تم الغاء الحجز';
        $reservation->save();

        $appointment = $this->saveAppointment($reservation);

        $reservations = auth('sanctum')->user()->reservations;
        return response()->json(['data' => $reservations], 200);
    }

    public function saveReserve($id)
    {
        $reservation = auth('sanctum')->user()->reservations->where('id', $id)->first();
        if (!$reservation)
            return response()->json(['message' => 'لا يوجد حجز بهذا الرقم'], 422);

        $phoneNumber = intval(auth('sanctum')->user()->mobile);
        $message = 'تم تأكيد حجز رقم  ' . $reservation->display_id . ' بنجاح ';
        $send = false;
        if ($phoneNumber)
            $send = $this->send('972' . $phoneNumber, $message);

        return response()->json(['data' => 'mobile message should be sent to user', 'result' => ($send)], 200);
    }

    private function saveAppointment($reservation)
    {
        $appointment = Appointment::wheredate('date', Carbon::parse($reservation->appointment_date))->where('service_type', $reservation->service_type)->first();
        $appointmentTimes = $appointment->times;
        foreach ($appointment->times as $key => $time) {
            if (isset($time['time']) and $time['time'] == Carbon::parse($reservation->appointment_time)->format('h:i a')) {
                $appointmentTimes[$key]['status'] = null;
                break;
            }
        }
        $appointment->times = $appointmentTimes;
        $appointment->save();

        return $appointment;
    }
}
