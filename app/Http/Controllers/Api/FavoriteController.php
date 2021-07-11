<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Clinic\Favorite;
use App\Models\Service\Offer;
use App\Traits\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FavoriteController extends Controller
{
    use Location;
    public function showUserFavorites()
    {
        if (auth('sanctum')->user()->id == 1 or auth('sanctum')->user()->id == 2)
            return response()->json(['message' => 'لا يمكن للزائر عرض المفضلة'], 422);

        $favorites = auth('sanctum')->user()->favorites;
        $favorites = $favorites->load('clinic');
        $clinics = array_column($favorites->toArray(), 'clinic');
        $favorites = $favorites->load('offer');
        $offers = array_column($favorites->toArray(), 'offer');
        $first_names = (array_merge($clinics,$offers));

        $first_names = array_values(array_filter($first_names, function($v) { return !is_null($v); }));

        return response()->json(['data' => $first_names], 200);
    }

    public function storeUserFavorite(Request $request)
    {
        if (auth('sanctum')->user()->id == 1 or auth('sanctum')->user()->id == 2)
            return response()->json(['message' => 'لا يستطيع الزائر اضافة عيادات للمفضلة'], 422);
        $rules = [
            'clinic_id' => 'required'
        ];
        $messages = [
            'clinic_id.required' => 'حقل رقم العيادة مطلوب'
        ];
        $validator = Validate::validateRequest($request, $rules, $messages);
        if ($validator !== 'valid') return $validator;

        $clinic = Clinic::find($request->clinic_id);
        if (!$clinic)
            return response()->json(['message' => 'العيادة غير موجودة'], 422);

        $favorite = auth('sanctum')->user()->favorites->where('clinic_id', $request->clinic_id)->first();
        if ($favorite)
            return response()->json(['message' => 'لا يمكن اضافة العيادة مرة اخرى للمفضلة'], 422);

        $favorite = auth('sanctum')->user()->favorites()->create(['clinic_id' => $request->clinic_id]);

        return response()->json(['data' => $favorite], 200);
    }
    public function storeOfferFavorite(Request $request)
    {
        if (auth('sanctum')->user()->id == 1 or auth('sanctum')->user()->id == 2)
            return response()->json(['message' => 'لا يستطيع الزائر اضافة عرض للمفضلة'], 422);
        $rules = [
            'offer_id' => 'required'
        ];
        $messages = [
            'offer_id.required' => 'حقل رقم العرض مطلوب'
        ];
        $validator = Validate::validateRequest($request, $rules, $messages);
        if ($validator !== 'valid') return $validator;

        $offer = Offer::find($request->offer_id);
        if (!$offer)
            return response()->json(['message' => 'العرض غير موجودة'], 422);

        $favorite = auth('sanctum')->user()->favorites->where('offer_id', $request->offer_id)->first();
        if ($favorite)
            return response()->json(['message' => 'لا يمكن اضافة العرض مرة اخرى للمفضلة'], 422);

        $favorite = auth('sanctum')->user()->favorites()->create(['offer_id' => $request->offer_id,'type' => 1]);

        return response()->json(['data' => $favorite], 200);
    }

    public function destroyUserFavorite(Request $request)
    {
        if (auth('sanctum')->user()->id == 1 or auth('sanctum')->user()->id == 2)
            return response()->json(['message' => 'لا يستطيع الزائر ازالة عيادات من المفضلة'], 422);
        $rules = [
            'clinic_id' => 'required'
        ];
        $messages = [
            'clinic_id.required' => 'حقل رقم العيادة مطلوب'
        ];
        $validator = Validate::validateRequest($request, $rules, $messages);
        if ($validator !== 'valid') return $validator;

        $clinic = Clinic::find($request->clinic_id);
        if (!$clinic)
            return response()->json(['message' => 'العيادة غير موجودة'], 422);

        $favorite = auth('sanctum')->user()->favorites->where('clinic_id', $request->clinic_id)->first();
        if (!$favorite)
            return response()->json(['message' => 'العيادة غير مضافة إلى المفضلة'], 422);

        $favorite->delete();
        return response()->json(['message' =>  'تمت إزالة العيادة من المفضلة'], 200);
    }
    public function destroyOfferFavorite(Request $request)
    {
        if (auth('sanctum')->user()->id == 1 or auth('sanctum')->user()->id == 2)
            return response()->json(['message' => 'لا يستطيع الزائر ازالة عرض من المفضلة'], 422);
        $rules = [
            'offer_id' => 'required'
        ];
        $messages = [
            'offer_id.required' => 'حقل رقم عرض مطلوب'
        ];
        $validator = Validate::validateRequest($request, $rules, $messages);
        if ($validator !== 'valid') return $validator;

        $offer = Offer::find($request->offer_id);
        if (!$offer)
            return response()->json(['message' => 'العرض غير موجودة'], 422);

        $favorite = auth('sanctum')->user()->favorites->where('offer_id', $request->offer_id)->first();
        if (!$favorite)
            return response()->json(['message' => 'العرض غير مضافة إلى المفضلة'], 422);

        $favorite->delete();
        return response()->json(['message' =>  'تمت إزالة العرض من المفضلة'], 200);
    }
}
