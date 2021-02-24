<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Clinic\ClinicRequest;
use App\Models\Service\Appointment;
use App\Models\Service\Reserve;
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

        $perPage = request('per_page') ?? 10;

        $location = $this->getLocationLongAlt();
        $city_name = '%'.$location['city_name'].'%' ?? '';
//        $latitude = $location['latitude'] ?? '';
//        $longitude = $location['longitude'] ?? '';
        $clinics = Clinic::where('city_name','LIKE',$city_name)
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


        $perPage = request('per_page') ?? 10;
        $location = $this->getLocationLongAlt();

        $city_name = $location['city_name'] ?? '';

        $latitude = $location['latitude'] ?? '';
        $longitude = $location['longitude'] ?? '';
        $clinics = $this->findNearestClinics($latitude, $longitude,$city_name, $perPage);
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


        $appointment = Appointment::find($request->appointment_id);
        if (!$appointment)
            return response()->json(['message' => 'الحجز غير موجود'], 422);

        $reservation = new Reserve();
        $reservation->app_user_id = auth('sanctum')->user()->id;
        $reservation->display_id = mt_rand(100000, 999999) . '-' . Carbon::today()->format('m-Y');
        $reservation->clinic_id = $id;
        $reservation->service_id = $request->service_id;
        $reservation->appointment_date = $appointment->date;
        $reservation->appointment_time = Carbon::parse($request->time);
        $reservation->status = 0;
        $reservation->save();

        $appointmentTimes = $appointment->times;
        foreach ($appointment->times as $key => $time) {
            if ($time['time'] == $request->time)
                $appointmentTimes[$key]['status'] = 'reserved';

        }
        $appointment->times = $appointmentTimes;
        $appointment->save();

        return response()->json(['data' => $reservation->makeHidden('clinic', 'service')], 200);
    }

    private function findNearestClinics($latitude, $longitude,$city_name, $perPage)
    {
        $clinics = Clinic::where('city_name','like','%'.$city_name.'%')->selectRaw("*,
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
}
