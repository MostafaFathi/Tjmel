<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Service\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function showOffersByPrice()
    {
        $perPage = request('per_page') ?? 10;
        $offers = Offer::where('status',1)->orderBy('price_after','asc')->paginate($perPage);
        return response()->json(['data' => $offers], 200);
    }
    public function showOffersByLocation()
    {
        $perPage = request('per_page') ?? 10;
        $location = $this->getLocationLongAlt();

        $latitude = $location['latitude'] ?? '';
        $longitude = $location['longitude'] ?? '';
        $offers = $this->findNearestOffers( $latitude,$longitude,$perPage);
        return response()->json(['data' => $offers], 200);
    }
    private function findNearestOffers($latitude, $longitude, $perPage)
    {

        $offers = Clinic::selectRaw("*,
                     truncate(( 6371 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ),2) AS distance", [$latitude, $longitude, $latitude])
            ->orderBy("distance",'asc')
            ->paginate($perPage);

        $offers->transform(function($item) {
            return $item->offers->where('status',1);
        });
        return $offers;
    }
}
