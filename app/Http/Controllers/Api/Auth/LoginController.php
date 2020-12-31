<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Models\User\AppUser;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function sendOtpCode(Request $request)
    {
        $rules = [
            'mobile' => 'required',
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator !== 'valid') return $validator;


        return $this->phoneOtpCode($request);
    }

    public function loginVerifyOtpCode(Request $request)
    {
        return $this->verifyOtpCode($request);
    }

}
