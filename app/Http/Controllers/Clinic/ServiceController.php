<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Service\Section;
use App\Models\Service\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = auth()->user()->clinic->services()->paginate(10);
        return view('clinic.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('clinic.services.create', compact('sections'));
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
            'name_ar' => 'required',
            'section_id' => 'required',
            'price' => 'required',
        ], [
            'name_ar.required' => 'حقل اسم الخدمة مطلوب',
            'section_id.required' => 'حقل القسم مطلوب',
            'price.required' => 'حقل السعر مطلوب',
        ]);

        $service = new Service();
        $service->section_id = $request->section_id;
        $service->clinic_id = auth()->user()->clinic->id;
        $service->name_ar = $request->name_ar;
        $service->description_ar = $request->description_ar;
        $service->instructions_ar = $request->instructions_ar;
        $service->price = $request->price;
        $service->save();
        return redirect()->route('services.index')->with('success', 'تمت عملية الاضافة بنجاح');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $services = auth()->user()->clinic->services->where('id', $id)->first();
        return response()->json($services);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = Section::all();
        $service = auth()->user()->clinic->services->where('id',$id)->first();
        if (!$service) abort(404);
        return view('clinic.services.edit', compact('sections', 'service'));
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
        $request->validate([
            'name_ar' => 'required',
            'section_id' => 'required',
            'price' => 'required',
        ], [
            'name_ar.required' => 'حقل اسم الخدمة مطلوب',
            'section_id.required' => 'حقل القسم مطلوب',
            'price.required' => 'حقل السعر مطلوب',
        ]);
        $service = auth()->user()->clinic->services->where('id', $id)->first();
        if (!$service) {
            return back()->withErrors('إما انك لم تقم باختيار خدمة او ان هذه الخدمة ليست لعيادتكم.');
        }
        $service = Service::find($id);
        $service->section_id = $request->section_id;
        $service->name_ar = $request->name_ar;
        $service->description_ar = $request->description_ar;
        $service->instructions_ar = $request->instructions_ar;
        $service->price = $request->price;
        $service->save();
        return redirect()->route('services.index')->with('success', 'تمت عملية الحفظ بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = auth()->user()->clinic->services->where('id',$id)->first();
        if (!$service) abort(404);

        Service::destroy($id);

        return back()->with('success', 'تمت عملية الحذف بنجاح');
    }
}
