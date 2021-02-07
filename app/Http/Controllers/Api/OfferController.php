<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
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
        $offers = $this->findNearestOffers( $latitude,$longitude,$city_name,$perPage);
        return response()->json(['data' => $offers], 200);
    }
    private function findNearestOffers($latitude, $longitude,$city_name, $perPage)
    {

        $offers = Clinic::where('city_name','like','%'.$city_name.'%')->selectRaw("*,
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
