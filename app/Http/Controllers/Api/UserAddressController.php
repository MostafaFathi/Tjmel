<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Models\User\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function showUserAddresses()
    {
        $addresses = auth('sanctum')->user()->addresses;
        return response()->json(['data' => $addresses, 'status' => true], 200);
    }

    public function storeUserAddress(Request $request)
    {
        $rules = [
            'location' => 'required',
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator != 'valid') return $validator;

        $address = new UserAddress();
        $address->app_user_id = auth('sanctum')->user()->id;
        $address->title = $request->title;
        $address->location = $request->location;
        $address->city_name = $request->city_name;
        $address->is_current = auth('sanctum')->user()->addresses->count() == 0;
        $address->save();
        return response()->json(['data' => $address, 'status' => true], 200);
    }

    public function updateUserAddress(Request $request, $id)
    {
        $rules = [
            'location' => 'required',
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator != 'valid') return $validator;

        $address = auth('sanctum')->user()->addresses->where('id', $id)->first();
        if (!$address)
            return response()->json(['message' => 'العنوان غير موجود'], 422);

        $address->title = $request->title;
        $address->location = $request->location;
        $address->city_name = $request->city_name;
        $address->save();
        return response()->json(['data' => $address, 'status' => true], 200);
    }

    public function destroyUserAddress($id)
    {
        $address = auth('sanctum')->user()->addresses->where('id', $id)->first();
        if (!$address)
            return response()->json(['message' => 'العنوان غير موجود'], 422);

        UserAddress::destroy($id);

        $this->updateFirstAddressAsCurrent($address);

        return response()->json(['data' => 'success', 'status' => true], 200);
    }

    public function makeUserAddressAsCurrent($id)
    {
        $address = auth('sanctum')->user()->addresses->where('id', $id)->first();
        if (!$address)
            return response()->json(['message' => 'العنوان غير موجود'], 422);

        $this->updateAllAsNotCurrent();
        $address->is_current = true;
        $address->save();
        return response()->json(['data' => $address, 'status' => true], 200);
    }

    private function updateAllAsNotCurrent()
    {
        $addresses = auth('sanctum')->user()->addresses;
        foreach ($addresses as $address) {
            $address->is_current = false;
            $address->save();
        }
    }

    private function updateFirstAddressAsCurrent($address)
    {

        if ($address->is_current) {
            $firstAddress = UserAddress::where('app_user_id', auth('sanctum')->user()->id)->first();
            if ($firstAddress) {
                $firstAddress->is_current = true;
                $firstAddress->save();
            }
        }
    }
}
