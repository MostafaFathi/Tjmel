<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Clinic\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function showUserFavorites()
    {
        if (auth('sanctum')->user()->id == 1 or auth('sanctum')->user()->id == 2)
            return response()->json(['message' => 'لا يمكن للزائر عرض المفضلة'], 422);

        $favorites = auth('sanctum')->user()->favorites;
        $favorites = $favorites->load('clinic');
        $first_names = array_column($favorites->toArray(), 'clinic');

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
}
