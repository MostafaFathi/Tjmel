<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Clinic\Rate;
use App\Models\Service\Offer;
use App\Models\Service\Service;
use Illuminate\Http\Request;

class ServiceOfferController extends Controller
{
    public function services()
    {
        $services = Service::paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function showService($id)
    {
        $service = Service::find($id);
        return view('admin.services.show', compact('service'));
    }

    public function offers()
    {
        $offers = Offer::paginate(15);
        return view('admin.offers.index', compact('offers'));
    }

    public function showOffer($id)
    {
        $offer = Offer::find($id);
        return view('admin.offers.show', compact('offer'));
    }

    public function updateOffer(Request $request, $id)
    {

        $offer = Offer::find($id);
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
        Rate::destroy($id);
        return back();
    }


}
