<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Clinic\ClinicRequest;
use App\Models\Clinic\Rate;
use App\Models\Data\Setting;
use App\Models\Service\Appointment;
use App\Models\Service\Offer;
use App\Models\Service\Reserve;
use App\Models\Service\Service;
use App\Traits\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClinicController extends Controller
{
    use Location;

    public function showClinicsByRating()
    {
        $rules = [
            'city_name' => 'required',
        ];
        $messages = [
            'city_name.required' => 'حقل اسم المدينة مطلوب',
        ];
        $validator = Validate::validateRequest(request(), $rules, $messages);
        if ($validator !== 'valid') return $validator;

        $perPage = request('per_page') ?? 1000;

        $location = $this->getLocationLongAlt();
        $city_name = '%' . $location['city_name'] . '%' ?? '';
//        $latitude = $location['latitude'] ?? '';
//        $longitude = $location['longitude'] ?? '';
        $clinics = Clinic::where('city_name', 'LIKE', $city_name)
            ->orderBy('rating', 'desc')
//            ->selectRaw("*,
//                     truncate(( 6371 * acos( cos( radians(?) ) *
//                       cos( radians( latitude ) )
//                       * cos( radians( longitude ) - radians(?)
//                       ) + sin( radians(?) ) *
//                       sin( radians( latitude ) ) )
//                     ),2) AS distance", [$latitude, $longitude, $latitude])
            ->paginate($perPage);
        return response()->json(['data' => $clinics->makeHidden('rates')], 200);
    }

    public function showClinicsByLocation()
    {
        $rules = [
            'city_name' => 'required',
        ];
        $messages = [
            'city_name.required' => 'حقل اسم المدينة مطلوب',
        ];
        $validator = Validate::validateRequest(request(), $rules, $messages);
        if ($validator !== 'valid') return $validator;


        $perPage = request('per_page') ?? 1000;
        $location = $this->getLocationLongAlt();

        $city_name = $location['city_name'] ?? '';

        $latitude = $location['latitude'] ?? '';
        $longitude = $location['longitude'] ?? '';
        $clinics = $this->findNearestClinics($latitude, $longitude, $city_name, $perPage);
        return response()->json(['data' => $clinics->makeHidden('rates')], 200);
    }

    public function searchClinics()
    {
        $searchValue = request()->get('q') ?? '';
        $location = $this->getLocationLongAlt();

        $city_name = $location['city_name'] ?? '';
        $clinics = Clinic::where('city_name', 'like', '%' . $city_name . '%')
            ->where('name_ar', 'like', '%' . $searchValue . '%')->get();
        return response()->json(['data' => $clinics->makeHidden('rates')], 200);
    }

    public function showClinic($id)
    {
        $clinic = Clinic::with(['rates', 'services' => function ($service) {
            return $service->where('status', 1);
        }, 'services.appointments'])
            ->where('id', $id)
            ->first();
        if (!$clinic)
            return response()->json(['message' => 'العيادة غير موجودة'], 422);
        return response()->json(['data' => $clinic], 200);
    }

    public function reserveClinicService(Request $request, $id, $service_id)
    {
        $rules = [
            'appointment_id' => 'required',
            'time' => 'required',
        ];
        $messages = [
            'appointment_id.required' => 'حقل رقم الموعد مطلوب',
            'time.required' => 'حقل الوقت مطلوب',
        ];
        $validator = Validate::validateRequest($request, $rules, $messages);
        if ($validator !== 'valid') return $validator;

        if (!$service_id)
            return response()->json(['message' => 'حقل رقم الخدمة مطلوب'], 422);

        $clinic = Clinic::find($id);
        if (!$clinic)
            return response()->json(['message' => 'العيادة غير موجودة'], 422);

        $service = Service::find($service_id);
        if (!$service)
            return response()->json(['message' => 'الخدمة غير موجودة'], 422);


        $appointment = Appointment::where('id', $request->appointment_id)->where('service_type', 'service')->first();
        if (!$appointment)
            return response()->json(['message' => 'الموعد غير موجود'], 422);

        $isReserved = false;
        $isFoundTime = false;
        foreach ($appointment->times as $key => $time) {
            if (isset($time['time']) and $time['time'] == $request->time and $time['status'] == 'reserved') {
                $isReserved = true;
                break;
            }
            if (isset($time['time']) and $time['time'] == $request->time) {
                $isFoundTime = true;
                break;
            }

        }
        if ($isReserved)
            return response()->json(['message' => 'الموعد محجوز لمستخدم آخر'], 422);

        if (!$isFoundTime)
            return response()->json(['message' => 'الموعد خلال هذه الساعة غير موجود'], 422);


        $reservation = new Reserve();
        $reservation->app_user_id = auth('sanctum')->user()->id;
        $reservation->display_id =  mt_rand(10000, 99999);//Carbon::today()->format('ymd').
        $reservation->clinic_id = $id;
        $reservation->service_id = $request->service_id;
        $reservation->service_type = 'service';
        $reservation->appointment_date = $appointment->date;
        $reservation->appointment_time = Carbon::parse($request->time);
        $reservation->status = 0;
        $reservation->save();


        return response()->json(['data' => $reservation->makeHidden('clinic', 'service'),
            'clinic_location' => $clinic->location_on_map,
            'advanced_payment' => Setting::getValue('advance_payment')], 200);
    }

    public function reserveClinicOffer(Request $request, $id, $offer_id)
    {
        $rules = [
            'appointment_id' => 'required',
            'time' => 'required',
        ];
        $messages = [
            'appointment_id.required' => 'حقل رقم الموعد مطلوب',
            'time.required' => 'حقل الوقت مطلوب',
        ];
        $validator = Validate::validateRequest($request, $rules, $messages);
        if ($validator !== 'valid') return $validator;

        if (!$offer_id)
            return response()->json(['message' => 'حقل رقم الخدمة مطلوب'], 422);

        $clinic = Clinic::find($id);
        if (!$clinic)
            return response()->json(['message' => 'العيادة غير موجودة'], 422);

        $offer = Offer::find($offer_id);
        if (!$offer)
            return response()->json(['message' => 'العرض غير موجودة'], 422);

        $appointment = Appointment::where('id', $request->appointment_id)->where('service_type', 'offer')->first();
        if (!$appointment)
            return response()->json(['message' => 'الموعد غير موجود'], 422);

        $isReserved = false;
        $isFoundTime = false;
        foreach ($appointment->times as $key => $time) {
            if (isset($time['time']) and $time['time'] == $request->time and $time['status'] == 'reserved') {
                $isReserved = true;
                break;
            }
            if (isset($time['time']) and $time['time'] == $request->time) {
                $isFoundTime = true;
                break;
            }

        }
        if ($isReserved)
            return response()->json(['message' => 'الموعد محجوز لمستخدم آخر'], 422);
        if (!$isFoundTime)
            return response()->json(['message' => 'الموعد خلال هذه الساعة غير موجود'], 422);

        $reservation = new Reserve();
        $reservation->app_user_id = auth('sanctum')->user()->id;
        $reservation->display_id = mt_rand(10000, 99999);;
        $reservation->clinic_id = $id;
        $reservation->service_id = $request->offer_id;
        $reservation->service_type = 'offer';
        $reservation->appointment_date = $appointment->date;
        $reservation->appointment_time = Carbon::parse($request->time);
        $reservation->status = 0;
        $reservation->save();


        return response()->json(['data' => $reservation->makeHidden('clinic', 'service'),
            'clinic_location' => $clinic->location_on_map,
            'advanced_payment' => Setting::getValue('advance_payment')
        ], 200);
    }

    private function findNearestClinics($latitude, $longitude, $city_name, $perPage)
    {
        $clinics = Clinic::where('city_name', 'like', '%' . $city_name . '%')->selectRaw("*,
                    truncate(( 6371 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ),2)  AS distance", [$latitude, $longitude, $latitude])
            ->orderBy("distance", 'asc')
            ->paginate($perPage);


        return $clinics;
    }

    public function storeClinicRequest(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator != 'valid') return $validator;

        $clinicRequest = new ClinicRequest();
        $clinicRequest->name_ar = $request->name;
        $clinicRequest->phone = $request->phone;
        $clinicRequest->save();
        return response()->json(['clinic_application' => $clinicRequest, 'status' => true], 200);


    }

    public function rateClinic(Request $request, $id)
    {
        if ($this->isGust())
            return response()->json(['message' => 'لا يمكن للزوار تقييم العيادات'], 422);

        $rules = [
            'comment' => 'required',
            'value' => 'required|numeric|min:1|max:5',
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator != 'valid') return $validator;


        $isUserRatedClinicPreviously = Rate::where('clinic_id', $id)->where('app_user_id', auth('sanctum')->user()->id)->first();
        if ($isUserRatedClinicPreviously)
            return response()->json(['message' => 'قمت بتقييم هذه العيادة مسبقاً'], 422);

        $rate = new Rate();
        $rate->clinic_id = $id;
        $rate->app_user_id = auth('sanctum')->user()->id;
        $rate->comment = $request->comment;
        $rate->rate = $request->value;
        $rate->save();
        $clinic = Clinic::find($id);
        return response()->json(['clinic' => $clinic, 'status' => true], 200);


    }
}
