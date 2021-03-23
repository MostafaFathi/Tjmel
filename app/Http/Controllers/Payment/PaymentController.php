<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Data\Setting;
use App\Models\Service\Reserve;
use App\Models\Transaction\Transaction;
use App\Models\User\AppUser;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $currencyCode = "SAR";
    protected $APIKey = "tap1234";
    protected $MerchantID = "13014";
    protected $userName = "test";

    public function index($userId, $reserveId)
    {
        $user = AppUser::find($userId);
        if (!$userId) return 'user not found';

        $reservation = Reserve::find($reserveId);
        if (!$reservation) return 'reservation not found';

        if ($reservation->app_user_id != $userId) return 'reservation not found';

        $advance_payment = Setting::getValue('advance_payment');
        return view('payment.index', compact('user', 'reservation', 'advance_payment'));
    }

    public function callback()
    {

        return view('payment.callback');
    }

    public function postCallback(Request $request)
    {
        $status = 'FAILED';
        if ($request->callback['status'] == "CAPTURED") {
            $status = "CAPTURED";
            $amount = $request->callback['amount'];
            $reference = explode('-', $request->callback['reference']['order']);

            $reserveId = end($reference);
            $reservation = Reserve::find($reserveId);
            if ($reservation->service_type == 'service')
                $reservation->remained_value = $reservation->service_price - $amount;

            if ($reservation->service_type == 'offer')
                $reservation->remained_value = $reservation->offer_price_after - $amount;

            $reservation->paid_value = $amount;

            $reservation->save();
            $transaction = new Transaction();
            $transaction->app_user_id = $reservation->app_user_id;
            $transaction->reserve_id = $reservation->id;
            $transaction->clinic_id = $reservation->clinic_id;
            $transaction->value = $amount;
            $transaction->description = 'pay to reserve from tab payment';
            $transaction->save();
            return response()->json(['message'=>'success']);
        }else{
            return response()->json(['message'=>'fail']);
        }
    }

    public function useWalletToReserve($reserveId)
    {
        $advance_payment = Setting::getValue('advance_payment');
        $user = auth('sanctum')->user();

        $reservation = Reserve::find($reserveId);
        if (!$reservation) return response()->json(['message' => 'الحجز غير موجود'], 422);

        if ($reservation->app_user_id != $user->id) return response()->json(['message' => 'الحجز غير موجود'], 422);

        if ($user->wallet < $advance_payment) return response()->json(['message' => 'المحفظة فارغة او انها غير كافية للحجز'], 422);

        if ($reservation->paid_value > 0) return response()->json(['message' => 'قمت بالحجز مسبقا'], 422);

        if ($reservation->service_type == 'service')
            $reservation->remained_value = $reservation->service_price - $advance_payment;

        if ($reservation->service_type == 'offer')
            $reservation->remained_value = $reservation->offer_price_after - $advance_payment;

        $reservation->paid_value = $advance_payment;

        $reservation->save();

        $user->wallet = $user->wallet - $advance_payment;
        $user->save();

        $transaction = new Transaction();
        $transaction->app_user_id = $user->id;
        $transaction->reserve_id = $reservation->id;
        $transaction->clinic_id = $reservation->clinic_id;
        $transaction->value = $advance_payment;
        $transaction->description = 'pay to reserve from wallet';
        $transaction->save();

        return response()->json(['message' => 'تم الحجز بنجاح'], 200);
    }

    public function success()
    {
        return "Success";
    }
    public function fail()
    {
        return "Failed";
    }


}
