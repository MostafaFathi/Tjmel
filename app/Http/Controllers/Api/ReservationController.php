<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service\Reserve;
use App\Traits\Location;
use App\Traits\SmsSender;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use Location, SmsSender;

    public function showUserReservations()
    {
        if (auth('sanctum')->user()->id == 1 or auth('sanctum')->user()->id == 2)
            return response()->json(['message' => 'لا يمكن للزائر عرض الحجوزات'], 422);

        $reservations = auth('sanctum')->user()->reservations;
        return response()->json(['data' => $reservations->makeHidden('clinic')], 200);
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

        $reservations = auth('sanctum')->user()->reservations;
        return response()->json(['data' => $reservations->makeHidden('clinic')], 200);
    }

    public function saveReserve($id)
    {
        $reservation = auth('sanctum')->user()->reservations->where('id', $id)->first();
        if (!$reservation)
            return response()->json(['message' => 'لا يوجد حجز بهذا الرقم'], 422);

        $phoneNumber = auth('sanctum')->user()->mobile;
        $message = 'تم تأكيد حجز رقم  ' . $reservation->display_id . ' بنجاح ';
        $send = false;
        if ($phoneNumber)
            $send = $this->send('972' . $phoneNumber, $message);

        return response()->json(['data' => 'mobile message should be sent to user', 'result' => ($send)], 200);
    }
}
