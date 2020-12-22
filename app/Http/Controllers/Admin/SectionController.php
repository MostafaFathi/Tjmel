<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::get();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sections.create');
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
            'image' => 'required',
        ]);

        $section = new Section();
        $section->title_ar = $request->title_ar;
        if ($request->has('image') and $request->image != null) {
            $imageName = $request->image->store('public/sections');
            $section->image = $imageName;
        }
        $section->save();

        return redirect()->route('sections.index')->with('success', 'success')->with('id', $section->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Section::find($id);
        return view('admin.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = Section::find($id);
        return view('admin.sections.edit', compact('section'));
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


        $section = Section::find($id);
        $section->title_ar = $request->title_ar;
        if ($request->has('image') and $request->image != null) {
            $imageName = $request->image->store('public/sections');
            $section->image = $imageName;
        }
        $section->save();

        return redirect()->route('sections.index')->with('success', 'success')->with('id', $section->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Section::destroy($id);
        return back()->with('success', 'success');
    }
}
