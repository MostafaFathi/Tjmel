<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Service\Offer;
use App\Models\Service\Section;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers= auth()->user()->clinic->offers()->paginate(10);
        return view('clinic.offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('clinic.offers.create',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        $offer = new Offer();
        $offer->section_id = $request->section_id;
        $offer->clinic_id  = auth()->user()->clinic->id;
        $offer->name_ar = $request->name_ar;
        $offer->description_ar = $request->description_ar;
        $offer->instructions_ar = $request->instructions_ar;
        $offer->price_before = $request->price_before;
        $offer->price_after = $request->price_after;
        $offer->save();
        return redirect()->route('offers.index')->with('success', 'تمت عملية الاضافة بنجاح');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offers = auth()->user()->clinic->offers->where('id',$id)->first();
        return response()->json($offers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = Section::all();
        $offer = auth()->user()->clinic->offers->where('id',$id)->first();
        if (!$offer) abort(404);
        return view('clinic.offers.edit',compact('sections','offer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        $offer = auth()->user()->clinic->offers->where('id',$id)->first();
        if (!$offer){
            return back()->withErrors('إما انك لم تقم باختيار العرض او ان هذا العرض ليس لعيادتكم.');
        }
        $offer =  Offer::find($id);
        $offer->section_id = $request->section_id;
        $offer->clinic_id  = auth()->user()->clinic->id;
        $offer->name_ar = $request->name_ar;
        $offer->description_ar = $request->description_ar;
        $offer->instructions_ar = $request->instructions_ar;
        $offer->price_before = $request->price_before;
        $offer->price_after = $request->price_after;
        $offer->save();
        return redirect()->route('offers.index')->with('success', 'تمت عملية الحفظ بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = auth()->user()->clinic->offers->where('id',$id)->first();
        if (!$offer) abort(404);

        Offer::destroy($id);

        return back()->with('success', 'تمت عملية الحذف بنجاح');
    }
}
