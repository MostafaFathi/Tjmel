<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Service\Offer;
use App\Traits\Location;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use Location;

    public function showOffer($id)
    {
        $offer = Offer::find($id);
        return response()->json(['data' => $offer], 200);
    }

    public function showOffersByPrice()
    {
        $perPage = request('per_page') ?? 1000;
        $location = $this->getLocationLongAlt();
        $city_name = '%' . $location['city_name'] . '%' ?? '';
        $clinics = Clinic::where('city_name', 'LIKE', $city_name)->get()->pluck('id');
//        dd($city_name);
        $offers = Offer::query();
        if (request()->has('section_id') and request()->get('section_id') != 0){

            $offers = $offers->where('section_id', request()->get('section_id'));
        }
        $offers = $offers->where('status', 1)->wherein('clinic_id', $clinics)->orderBy('price_after', 'asc')->get();
//            ->paginate($perPage);
        return response()->json(['data' => $offers->makeHidden('clinic')], 200);
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

        $perPage = request('per_page') ?? 1000;
        $location = $this->getLocationLongAlt();

        $city_name = $location['city_name'] ?? '';

        $latitude = $location['latitude'] ?? '';
        $longitude = $location['longitude'] ?? '';
        $offers = $this->findNearestOffers($latitude, $longitude, $city_name, $perPage);

        return response()->json(['data' => $offers], 200);
    }

    private function findNearestOffers($latitude, $longitude, $city_name, $perPage)
    {

        $clinics = Clinic::where('city_name', 'like', '%' . $city_name . '%')->selectRaw("*,
                     truncate(( 6371 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ),2) AS distance", [$latitude, $longitude, $latitude])
            ->orderBy("distance", 'asc')
            ->get();
//            ->paginate($perPage);
        $array = [];
        foreach ($clinics as $clinic) {

            if (isset($clinic->offers) and count($clinic->offers) > 0) {
                $offers = $clinic->offers->where('status', 1);
                if (request()->has('section_id') and request()->get('section_id') != 0){
                    $offers = $clinic->offers->where('status', 1)->where('section_id', request()->get('section_id'));
                }
                foreach ($offers as $item) {
                    array_push($array, $item->makeHidden('clinic'));
                }

            }
        }
        return $array;
    }
}
