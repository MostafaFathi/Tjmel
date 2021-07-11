<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Validate;
use App\Http\Controllers\Controller;
use App\Models\Advertisement\Advertisement;
use App\Models\Clinic\Clinic;
use App\Models\Data\AboutUs;
use App\Models\Data\Agreement;
use App\Models\Data\Category;
use App\Models\Data\City;
use App\Models\Data\ContactUs;
use App\Models\Data\District;
use App\Models\Data\Setting;
use App\Models\Service\Section;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function showAboutUs()
    {
        $about_us = AboutUs::get()->first();
        return response()->json(['data' => $about_us], 200);
    }
    public function showSections()
    {
        $sections = Section::get();
        $section = new Section();
        $section->id = 0;
        $section->title_ar = 'كل الاقسام';
        $section->image = null;
        $arr = [];
        array_push($arr,$section);
        foreach ($sections as $section) {
            array_push($arr,$section);
        }
        return response()->json(['data' => $arr], 200);
    }

    public function showAgreement()
    {
        $agreement = Agreement::get()->first();
        return response()->json(['data' => $agreement], 200);
    }

    public function showSettings()
    {
        $settings = Setting::get();
        return response()->json(['data' => $settings], 200);
    }

    public function showCities()
    {
        $cities = City::get();
        return response()->json(['data' => $cities], 200);
    }

    public function storeContactUs(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'required',
        ];
        $validator = Validate::validateRequest($request, $rules);
        if ($validator !== 'valid') return $validator;
        $contact_us = new ContactUs();
        $contact_us->name = $request->name;
        $contact_us->email = $request->email;
        $contact_us->title = $request->title;
        $contact_us->description = $request->description;
        $contact_us->save();
        return response()->json(['data' => $contact_us], 200);
    }

    public function getCities()
    {
        $cities = City::all();
        return response()->json(['data' => $cities], 200);
    }

    public function getDistrict($city_id)
    {
        $districts = District::where('city_id', $city_id)->get();
        return response()->json(['data' => $districts], 200);
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json(['data' => $categories], 200);
    }

    public function getAdvertisement()
    {
        $advertisements = Advertisement::with('clinic')->get();
        $advertisements->each(function ($advertisement) {
            if ($advertisement->clinic)
                $advertisement->clinic->makeHidden([
                    'rates',
                ]);
        });
        return response()->json(['data' => $advertisements], 200);
    }
}
