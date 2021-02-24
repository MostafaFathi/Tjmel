<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Location;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use Location;
    public function showUserReservations()
    {
        if (auth('sanctum')->user()->id == 1 or auth('sanctum')->user()->id == 2)
            return response()->json(['message' => 'لا يمكن للزائر عرض الحجوزات'], 422);

        $reservations = auth('sanctum')->user()->reservations;
        return response()->json(['data' => $reservations->makeHidden('clinic')], 200);
    }
}
