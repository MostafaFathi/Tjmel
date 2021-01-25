<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\User\AppUser;
use App\Models\User\User;
use App\Models\User\UserAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function showUserProfile()
    {
        $user = auth('sanctum')->user();

        return response()->json(['data' => $user], 200);
    }

    public function updateUserProfile(Request $request)
    {
        $rules = [
            'name' => 'required',
            'mobile' => 'required|unique:app_users,mobile,' . auth('sanctum')->user()->id,
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator != 'valid') return $validator;

        $user = auth('sanctum')->user();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->save();
        return response()->json(['user' => $user, 'status' => true], 200);


    }
    public function updateUserAddress(Request $request)
    {
        $rules = [
            'location' => 'required',
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator != 'valid') return $validator;

        $address = auth('sanctum')->user()->address;
        if (!$address)
            $address = new UserAddress();

        $address->app_user_id = auth('sanctum')->user()->id;
        $address->title = $request->title;
        $address->location = $request->location;
        $address->save();
        return response()->json(['data' => $address, 'status' => true], 200);


    }
    public function userVerifyOtpCode(Request $request)
    {
        return $this->verifyOtpCode($request);
    }


}
