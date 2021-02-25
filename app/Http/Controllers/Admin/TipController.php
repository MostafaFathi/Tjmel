<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Data\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tips = Tip::get();
        return view('admin.tips.index', compact('tips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tips.create');
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
        ]);

        $tip = new Tip();
        if($request->has('image') and $request->image != null){
            $imageName = $request->image->store('public/tips');
            $tip->image = $imageName;
        }
        $tip->save();

        return redirect()->route('tips.index')->with('success', 'success')->with('id', $tip->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tip = Tip::find($id);
        return view('admin.tips.show', compact('tip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tip = Tip::find($id);
        return view('admin.tips.edit', compact('tip'));
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
            'image' => 'required',
        ]);

        $tip =  Tip::find($id);
        if($request->has('image') and $request->image != null){
            $imageName = $request->image->store('public/tips');
            $tip->image = $imageName;
        }
        $tip->save();

        return redirect()->route('tips.index')->with('success', 'success')->with('id', $tip->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tip::destroy($id);
        return back()->with('success', 'success');
    }
}
