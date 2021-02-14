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
    public function getUserWallet()
    {
        return response()->json(['wallet' => auth('sanctum')->user()->wallet, 'status' => true], 200);
    }

    public function userVerifyOtpCode(Request $request)
    {
        return $this->verifyOtpCode($request);
    }


}
