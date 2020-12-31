<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Data\City;
use App\Models\Data\Setting;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinics = Clinic::paginate(15);
        return view('admin.clinics.index', compact('clinics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clinic = new Clinic();
        $cities = City::all();
        $location = Setting::getValue('location');
        return view('admin.clinics.create', compact('clinic','cities','location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'email|required|unique:users',
            'clinic_name_ar' => 'required',
            'password' => 'required',
        ]);
        $clinic = new Clinic();
        $clinic->name_ar = $request->clinic_name_ar;
        $clinic->phone = $request->phone;
        $clinic->full_address_ar = $request->full_address_ar;
        $clinic->location = $request->location;
        $clinic->longitude = Str::replaceFirst('(','',explode(', ',$request->location)[0]);
        $clinic->latitude= Str::replaceLast(')','',explode(', ',$request->location)[1]);
        $clinic->city_id = $request->city_id;
        $clinic->district_id = $request->district_id;
        if ($request->has('logo') and $request->logo != null) {
            $imageName = $request->logo->store('public/clinic/logo');
            $clinic->logo = $imageName;
        }
        if ($request->has('images') and $request->images != null) {
            $imageNames = $this->saveMultiImage($clinic, $request);
            $clinic->images = $imageNames;
        }
        $user = $this->addNewUser($request);
        $clinic->user_id = $user->id;
        $clinic->save();
        $this->updateClinicUser($clinic->user_id,$request,$clinic->id);

        return redirect()->route('clinics.index')->with('success', 'success')->with('id', $clinic->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clinic = Clinic::find($id);
        return view('admin.clinics.show', compact('clinic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clinic = Clinic::find($id);
        $cities = City::all();
        $location = Setting::getValue('location');
        return view('admin.clinics.edit', compact('clinic','cities','location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $clinic = Clinic::find($id);
        $request->validate([
            'email' => 'required|unique:users,email,' . $clinic->user_id,
            'clinic_name_ar' => 'required',
        ]);

        $clinic->name_ar = $request->clinic_name_ar;
        $clinic->phone = $request->phone;
        $clinic->full_address_ar = $request->full_address_ar;
        $clinic->location = $request->location;
        $clinic->longitude = Str::replaceFirst('(','',explode(', ',$request->location)[0]);
        $clinic->latitude= Str::replaceLast(')','',explode(', ',$request->location)[1]);
        $clinic->city_id = $request->city_id;
        $clinic->district_id = $request->district_id;
        if ($request->has('logo') and $request->logo != null) {
            $imageName = $request->logo->store('public/clinic/logo');
            $clinic->logo = $imageName;
        }
        if ($request->has('images') and $request->images != null) {
            $imageNames = $this->saveMultiImage($clinic, $request);
            $clinic->images = $imageNames;
        }
        $clinic->save();

        $this->updateClinicUser($clinic->user_id,$request,$clinic->id);

        return redirect()->route('clinics.index')->with('success', 'success')->with('id', $clinic->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Clinic::destroy($id);
        return back()->with('success', 'success');
    }

    private function addNewUser($request)
    {
        $user = new User;
        $user->name = $request->user_name_ar;
        $user->name_ar = $request->user_name_ar;
        $user->name_en = $request->user_name_ar;
        $user->email = $request->email != '' ? $request->email : $request->user_name_ar;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->syncRoles(['clinic']);
        return $user;
    }

    private function saveMultiImage($clinic, Request $request)
    {
        $imageNames = $clinic->images ?? [];
        foreach ($request->images as $image) {
            $imageName = $image->store('public/clinic/images');
            array_push($imageNames, $imageName);
        }
        return $imageNames;
    }

    private function updateClinicUser($user_id,$request,$clinic_id)
    {
        $user = User::find($user_id);
        $user->clinic_id = $clinic_id;
        $user->name = $request->user_name_ar;
        $user->name_ar = $request->user_name_ar;
        $user->email = $request->email;
        if ($request->password and $request->password != '') {
            $user->password = Hash::make($request->password);
        }
        $user->save();
    }
    public function destroyClinicImage(Request $request, $clinic_id)
    {
        $clinic = Clinic::find($clinic_id);
        if ($clinic->images and count($clinic->images) > 0) {
            $currentImages = $clinic->images;
            foreach ($clinic->images as $key => $image) {
                if ($image == $request->key) {
                    unset($currentImages[$key]);
                    Storage::delete($image);
                }
            }
            $clinic->images = $currentImages;
            $clinic->save();

        }
        return true;
    }
}
