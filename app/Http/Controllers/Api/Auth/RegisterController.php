<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Jobs\SendEmail;
use App\Models\Level\Level;
use App\Models\Level\UserLevel;
use App\Models\User\AppUser;
use App\Models\User\User;
use App\Models\User\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function sendOtpCode(Request $request)
    {
        $rules = [
            'name' => 'required',
            'mobile' => 'required',
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator !== 'valid') return $validator;


        return $this->phoneOtpCode($request);
    }

    public function registerVerifyOtpCode(Request $request)
    {
        return $this->verifyOtpCode($request);
    }

}
