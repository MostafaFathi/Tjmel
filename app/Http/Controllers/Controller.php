<?php

namespace App\Http\Controllers;

use App\Helpers\Validate;
use App\Models\Badge\Badge;
use App\Models\Badge\BadgeTerm;
use App\Models\Level\Level;
use App\Models\Level\UserLevel;
use App\Models\User\AppUser;
use App\Traits\SmsSender;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SmsSender;

    /* Protected functions can be used in challenges, events and quizzes api controllers  */
    protected function verifyOtpCode(Request $request)
    {
        $rules = [
            'mobile' => 'required',
            'otp_code' => 'required',
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator != 'valid') return $validator;

        $user = AppUser::where('mobile', $request->mobile)->where('otp_code', $request->otp_code)->first();

        if ($user and $user->status === 1)
            return response()->json(['message' => 'تم حظر رقم الجوال', 'status' => false], 422);

        $token = null;
        if ($user) {
            $token = $user->createToken('Tjmel Login token')->plainTextToken;
        } else {
            return response()->json(['message' => 'User not found, or otp verification error', 'status' => false], 422);
        }
        return response()->json(['user' => $user->makeHidden('addresses'), 'token' => $token, 'status' => true], 200);
    }

    protected function phoneOtpCode($request)
    {
        $otpCode = mt_rand(100000, 999999);
        if ($request->has('name') and $request->name != '') {
            $rules = [
                'mobile' => 'required|unique:app_users,mobile',
            ];
            $validator = Validate::validateRequest($request, $rules);
            if ($validator != 'valid') return $validator;
            $user = new AppUser();
            $user->mobile = $request->mobile;
            $user->name = $request->name;
            $user->email = $otpCode;
            $user->password = Hash::make(123);
        } else {
            $user = AppUser::where('mobile', $request->mobile)->first();
            if (!$user)
                return response()->json(['message' => 'User not found', 'status' => false], 422);

            if ($user->status === 1)
                return response()->json(['message' => 'تم حظر رقم الجوال', 'status' => false], 422);
        }
        $user->otp_code = $otpCode;
        $user->save();

        $phoneNumber = intval($user->mobile);
        $message = $otpCode . ' is your Tjmel verification code';
        if ($phoneNumber)
            $this->send('966' . $phoneNumber, $message);

        return response()->json(['otpCode' => $otpCode, 'status' => true], 200);
    }


}
