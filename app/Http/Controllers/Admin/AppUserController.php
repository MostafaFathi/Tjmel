<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\AppUser;
use Illuminate\Http\Request;

class AppUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Manage App users');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageCount = 15;
        $appUsers = AppUser::query();
        if (request()->has('mobile') and request()->get('mobile') != '') {
            $appUsers = $appUsers->where('mobile', 'like', '%' . request()->get('mobile') . '%');
        }
        if (request()->has('name') and request()->get('name') != '') {
            $appUsers = $appUsers->where('name', 'like', '%' . request()->get('name') . '%');
        }
        if (request()->has('wallet') and request()->get('wallet') != '') {
            $appUsers = $appUsers->where('wallet',  request()->get('wallet'));
        }
        $appUsers = $appUsers->where('id','!=','10101010')->paginate($pageCount);

        return view('admin.app_users.index',compact('appUsers','pageCount'));

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function changeStatus($id)
    {
        $appUser = AppUser::find($id);
        $appUser->status = !$appUser->status;
        $appUser->save();
        return back();
    }
    public function changeWallet(Request $request,$id)
    {
        $appUser = AppUser::find($id);
        $appUser->wallet_from_admin = ($appUser->wallet_from_admin ?? 0) + ($request->wallet - $appUser->wallet);
        $appUser->wallet = $request->wallet;
        $appUser->save();
        return back();
    }
}
