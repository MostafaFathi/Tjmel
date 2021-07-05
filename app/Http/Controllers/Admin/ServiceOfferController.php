<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Clinic\Rate;
use App\Models\Service\Offer;
use App\Models\Service\Section;
use App\Models\Service\Service;
use Illuminate\Http\Request;

class ServiceOfferController extends Controller
{
    public function services()
    {
        $services = Service::orderBy('id','desc')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function showService($id)
    {
        $service = Service::find($id);
        return view('admin.services.show', compact('service'));
    }
    public function editService($id)
    {
        $sections = Section::all();
        $service = Service::find($id);
        return view('admin.services.edit', compact('service','sections'));
    }

    public function offers()
    {
        $offers = Offer::orderBy('id','desc')->paginate(15);
        return view('admin.offers.index', compact('offers'));
    }

    public function showOffer($id)
    {
        $offer = Offer::find($id);
        return view('admin.offers.show', compact('offer'));
    }
    public function editOffer($id)
    {
        $sections = Section::all();
        $offer = Offer::find($id);
        return view('admin.offers.edit', compact('offer','sections'));
    }

    public function updateService(Request $request, $id)
    {

         $request->validate([
            'name_ar' => 'required',
            'section_id' => 'required',
            'price' => 'required',
        ],[
            'name_ar.required' => 'حقل اسم الخدمة مطلوب',
            'section_id.required' => 'حقل القسم مطلوب',
            'price.required' => 'حقل السعر مطلوب',
        ]);
        $service =Service::find($id);
        $service->section_id = $request->section_id;
        $service->name_ar = $request->name_ar;
        $service->description_ar = $request->description_ar;
        $service->instructions_ar = $request->instructions_ar;
        $service->price = $request->price;
        $service->save();
        return redirect()->route('services.acceptance')->with('success', 'success')->with('id', $service->id);

    }

    public function updateOffer(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'section_id' => 'required',
            'price_before' => 'required',
            'price_after' => 'required',
        ],[
            'name_ar.required' => 'حقل اسم العرض مطلوب',
            'section_id.required' => 'حقل القسم مطلوب',
            'price_before.required' => 'حقل السعر قبل مطلوب',
            'price_after.required' => 'حقل السعر بعد مطلوب',
        ]);

        $offer =  Offer::find($id);
        $offer->section_id = $request->section_id;
        $offer->name_ar = $request->name_ar;
        $offer->description_ar = $request->description_ar;
        $offer->instructions_ar = $request->instructions_ar;
        $offer->price_before = $request->price_before;
        $offer->price_after = $request->price_after;

        if ($request->has('image') and $request->image != null) {
            $imageName = $request->image->store('public/offers');
            $offer->image = $imageName;
        }
        if ($request->save_type == 'save_and_accept')
            $offer->status = 1;
        $offer->save();
        return redirect()->route('offers.acceptance')->with('success', 'success')->with('id', $offer->id);

    }

    public function changeServiceStatus($id)
    {
        $service = Service::find($id);
        $status = 0;
        if ($service->status == 0) {
            $status = 1;
        } else if ($service->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        $service->status = $status;
        $service->save();
        return back();
    }

    public function changeOfferStatus($id)
    {
        $offer = Offer::find($id);
        if ($offer->status == 0) {
            $status = 1;
        } else if ($offer->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        $offer->status = $status;
        $offer->save();
        return back();
    }
    public function deleteRate($id)
    {
        $rate = Rate::find($id);
        $clinic = Clinic::find($rate->clinic_id);
        Rate::destroy($id);
        $rating = count($clinic->rates) > 0 ? $clinic->rates->sum('rate') / count($clinic->rates) : 0;
        $clinic->rating = $rating;
        $clinic->save();
        return back();
    }
    public function deleteService($id)
    {
        Service::destroy($id);
        return back();
    }
    public function deleteOffer($id)
    {
        Offer::destroy($id);
        return back();
    }
}
