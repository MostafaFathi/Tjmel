<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Service\Reserve;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todayReservations = auth()->user()->clinic->reservations->where('status',5)->where('appointment_date',Carbon::today()->format('d-m-Y'))->orderBy('id','desc');
//        $nowReservations = Reserve::where('clinic_id',auth()->user()->clinic->id)->where('status',5)->where('appointment_date',Carbon::today()->format('d-m-Y'))
//            ->whereBetween('appointment_time',[Carbon::now()->subMinutes(30),Carbon::now()])->get();
        $comingReservations = Reserve::where('clinic_id',auth()->user()->clinic->id)->where('status',5)->orderBy('id','desc')->get();//->wheredate('appointment_date','>',Carbon::today())
        $completedReservations = auth()->user()->clinic->reservations->where('status',1)->orderBy('id','desc');
        $unCompletedReservations = auth()->user()->clinic->reservations->whereIn('status',[2,3,4])->orderBy('id','desc');
        return view('clinic.reservations.index',compact('todayReservations','comingReservations','completedReservations','unCompletedReservations'));
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

    public function changeStatus(Request $request,$id,$status)
    {
        $reservation = Reserve::find($id);
        $reservation->status = $status;
        $reservation->reason = $request->comment;
        $reservation->save();
        return back();
    }
}
