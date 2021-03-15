<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Data\Setting;
use App\Models\Service\Reserve;
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
        };
        return view('payment.callback', compact('status'));
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
        return response()->json(['message' => 'تم الحجز بنجاح'], 200);
    }

    public function doPayment()
    {

        $products = [
            [
                "CurrencyCode" => $this->currencyCode,
                "Quantity" => 1,
                "TotalPrice" => 20,
                "UnitDesc" => "Samsung-Galaxy-A50 Description",
                "UnitID" => "Apple #1",
                "UnitName" => "Samsung-Galaxy-A50",
                "UnitPrice" => 20,
                "VndID" => ""
            ]
        ];

        $CustomerDC = [
            "Email" => "sara@test.com",
            "Floor" => "4",
            "Gender" => "M",
            "ID" => "",
            "Mobile" => "965298568711",
            "Name" => "Nawwar AlMakhlouf",
            "Nationality" => "SA",
            "Street" => "Street 1",
            "Area" => "Homs",
            "CivilID" => "",
            "Building" => "Building 1",
            "Apartment" => "1",
            "DOB" => "1992-01-01"
        ];


        $response = $this->doTapPayment($CustomerDC, $products);
        dd($response);
        if ($response->ResponseMessage == 'Success') {
            return redirect($response->PaymentURL);
        } else {
            return redirect()->back()->with('error', 'Error while calling Tap Gateway!');
        }
    }


    public function redirect()
    {
        // Get the passed data whether from query string or from the post body
        $Tap_Ref = $_REQUEST['ref'];
        $Txn_Result = $_REQUEST['result'];
        $Txn_OrderID = $_REQUEST['trackid'];
        $Hash = $_REQUEST['hash'];


// Create a hash string from the passed data + the data that are related to you.
        $APIKey = $this->APIKey; //Your API Key Provided by Tap
        $MerchantID = $this->MerchantID; //Your ID provided by Tap
        $toBeHashedString = 'x_account_id' . $MerchantID . 'x_ref' . $Tap_Ref . 'x_result' . $Txn_Result . 'x_referenceid' . $Txn_OrderID . '';
        $myHashStr = hash_hmac('sha256', $toBeHashedString, $APIKey);


// Legitimate the request by comparing the hash string you computed with the one passed with the request
        if ($myHashStr == $Hash) {
            return redirect()->route('home')->with('success', 'Valid Payment');
        } else {
            return redirect()->route('home')->with('error', 'Invalid Payment');
        }
    }

    function doTapPayment($CustomerDC, $products)
    {
        return json_decode($this->CallAPI('POST', 'http://tapapi.gotapnow.com/TapWebConnect/Tap/WebPay/PaymentRequest', $this->getTapGatwayData($CustomerDC, $products)));
    }

    function getTapGatwayData($CustomerDC, $lstProductDC)
    {
        $data = [
            "CustomerDC" => $CustomerDC,
            "lstProductDC" => $lstProductDC,
            "lstGateWayDC" => [
                [
                    "Name" => "ALL"
                ]
            ],
            "MerMastDC" => [
                "AutoReturn" => "Y",
                "ErrorURL" => "https://github.com/nosuchpage",
                "HashString" => $this->getTapGatewayHash($lstProductDC),
                "LangCode" => "AR",
                "MerchantID" => $this->MerchantID,
                "Password" => "test",
                "PostURL" => url('/'),
                "ReferenceID" => "45870225000",
                "ReturnURL" => route('payment.tap-redirect'),
                "UserName" => $this->userName
            ]
        ];
        return $data;
    }


    function getTapGatewayHash($products)
    {
        $str =
            'X_MerchantID' . $this->MerchantID .
            'X_UserName' . $this->userName .
            'X_ReferenceID' . '45870225000' .
            'X_Mobile' . '965298568711' .
            'X_CurrencyCode' . $this->currencyCode .
            'X_Total' . $products[0]['TotalPrice'] . '';
        return hash_hmac('sha256', $str, $this->APIKey);
    }


    function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
