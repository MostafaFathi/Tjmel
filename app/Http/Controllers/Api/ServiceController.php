<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Service\Service;
use App\Traits\Location;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use Location;
    public function showService($id)
    {
        $service = Service::find($id);
        return response()->json(['data' => $service], 200);
    }
    public function showServicesByPrice()
    {
        $perPage = request('per_page') ?? 1000;
        $services = Service::where('status',1)->orderBy('price','asc')->paginate($perPage);
        return response()->json(['data' => $services], 200);
    }
    public function showServicesByLocation()
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
        $services = $this->findNearestServices( $latitude,$longitude,$city_name,$perPage);
        return response()->json(['data' => $services], 200);
    }

    private function findNearestServices($latitude, $longitude,$city_name, $perPage)
    {
        $services = Clinic::where('city_name','like','%'.$city_name.'%')->selectRaw("*,
                     truncate(( 6371 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ),2) AS distance", [$latitude, $longitude, $latitude])
            ->orderBy("distance",'asc')
            ->paginate($perPage);

        $services->transform(function($item) {
            return $item->services->where('status',1);
        });
        return $services;
    }
}
