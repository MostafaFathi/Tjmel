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
        $location = $this->getLocationLongAlt();

        $latitude = $location['latitude'] ?? '';
        $longitude = $location['longitude'] ?? '';
        $services = $this->findNearestServices( $latitude,$longitude,$perPage);
        return response()->json(['data' => $services], 200);
    }
    private function findNearestServices($latitude, $longitude, $perPage)
    {
        $services = Clinic::selectRaw("*,
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
