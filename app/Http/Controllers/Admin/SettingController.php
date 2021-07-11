<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Data\District;
use App\Models\Data\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Manage Settings');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $order_fees = Setting::firstorcreate(['key'=>'order_fees'],['key'=>'order_fees','value'=>0]);
        $whatsapp = Setting::firstorcreate(['key'=>'whatsapp'],['key'=>'whatsapp','value'=>599]);
        $advance_payment = Setting::firstorcreate(['key'=>'advance_payment'],['key'=>'advance_payment','value'=>0]);
        return view('admin.settings.order_fees.edit', compact('whatsapp','advance_payment'));
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
//        $order_fees =  Setting::firstorcreate(['key'=>'order_fees'],['key'=>'order_fees','value'=>0]);
//        $order_fees->value = $request->value;
//        $order_fees->save();
        $whatsapp =  Setting::firstorcreate(['key'=>'whatsapp'],['key'=>'whatsapp','value'=>599]);
        $whatsapp->value = $request->whatsapp;
        $whatsapp->save();
        $advance_payment = Setting::firstorcreate(['key'=>'advance_payment'],['key'=>'advance_payment','value'=>0]);
        $advance_payment->value = $request->advance_payment;
        $advance_payment->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cityDistricts($id)
    {
        $districts = District::where('city_id', $id)->get();
        $district_id = request('district_id') ?? '';
        $generatedOptions = '';
        foreach ($districts as $district) {
            if ($district_id and $district_id == $district->id)
                $generatedOptions .= '<option value="' . $district->id . '" selected>' . $district->name_ar . '</option>';
            else
                $generatedOptions .= '<option value="' . $district->id . '">' . $district->name_ar . '</option>';
        }
        return response()->json(['options' => $generatedOptions]);
    }
}
