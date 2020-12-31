<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Service\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function showServicesByPrice()
    {
        $perPage = request('per_page') ?? 10;
        $services = Service::where('status',1)->orderBy('price','asc')->paginate($perPage);
        return response()->json(['data' => $services], 200);
    }
    public function showServicesByLocation()
    {
        $perPage = request('per_page') ?? 10;
        $services = $this->findNearestServices( '46.67304098848261','24.714827555713196',$perPage);
        return response()->json(['data' => $services], 200);
    }
    private function findNearestServices($latitude, $longitude, $perPage)
    {

        $services = Clinic::selectRaw("*,
                     ( 6371000 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ) AS distance", [$latitude, $longitude, $latitude])
            ->orderBy("distance",'asc')
            ->paginate($perPage);

        $services->transform(function($item) {
            return $item->services->where('status',1);
        });
        return $services;
    }
}
