<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement\Advertisement;
use App\Models\Clinic\Clinic;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Manage Advertisements');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisement::get();
        return view('admin.advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clinics = Clinic::all();
        return view('admin.advertisements.create',compact('clinics'));
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
            'image' => 'required',
        ],[
            'image.required' => 'حقل الصورة مطلوب',
        ]);

        $advertisement = new Advertisement();
        $advertisement->clinic_id = $request->clinic_id ?? '';
        if($request->has('image') and $request->image != null){
            $imageName = $request->image->store('public/advertisement');
            $advertisement->image = $imageName;
        }
        $advertisement->save();

        return redirect()->route('advertisements.index')->with('success', 'success')->with('id', $advertisement->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertisement = Advertisement::find($id);
        return view('admin.advertisements.show', compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advertisement = Advertisement::find($id);
        $clinics = Clinic::all();
        return view('admin.advertisements.edit', compact('advertisement','clinics'));
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
        $advertisement =  Advertisement::find($id);
        $advertisement->clinic_id = $request->clinic_id ?? '';
        if($request->has('image') and $request->image != null){
            $imageName = $request->image->store('public/advertisement');
            $advertisement->image = $imageName;
        }
        $advertisement->save();

        return redirect()->route('advertisements.index')->with('success', 'success')->with('id', $advertisement->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Advertisement::destroy($id);
        return back()->with('success', 'success');
    }
}
