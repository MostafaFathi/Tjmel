<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Service\Reserve;
use App\Models\Transaction\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd(auth()->user()->clinic->services[2]->earliest_appointment);
        return view('clinic.main.home');

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

    public function statics()
    {
        $dailyIncome = Transaction::where('clinic_id',auth()->user()->clinic_id)->wheredate('created_at', Carbon::today())->sum('value');
        $monthlyIncome = Transaction::where('clinic_id',auth()->user()->clinic_id)->wheredate('created_at', '>=', Carbon::today()->subMonth())->sum('value');
        $yearlyIncome = Transaction::where('clinic_id',auth()->user()->clinic_id)->wheredate('created_at', '>=', Carbon::today()->subYear())->sum('value');
        $completedReservations = Reserve::where('clinic_id', auth()->user()->clinic_id)->where('status',1)->count();
        $unCompletedReservations = Reserve::where('clinic_id', auth()->user()->clinic_id)->where('status','!=',1)->count();
        return view('clinic.statics.index',compact('dailyIncome','monthlyIncome','yearlyIncome','completedReservations','unCompletedReservations'));

    }
}
