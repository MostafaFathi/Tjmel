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
        $offers = $this->findNearestOffers( '46.67304098848261','24.714827555713196',$perPage);
        return response()->json(['data' => $offers], 200);
    }
    private function findNearestOffers($latitude, $longitude, $perPage)
    {

        $offers = Clinic::selectRaw("*,
                     ( 6371000 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ) AS distance", [$latitude, $longitude, $latitude])
            ->orderBy("distance",'asc')
            ->paginate($perPage);

        $offers->transform(function($item) {
            return $item->offers->where('status',1);
        });
        return $offers;
    }
}
