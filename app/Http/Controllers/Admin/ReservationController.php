<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Clinic\RateCode;
use App\Models\Service\Reserve;
use App\Models\Transaction\Transaction;
use App\Models\User\AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reserve::query();
        if (request()->has('user') and request()->get('user') != '') {
            $appUser = AppUser::where('mobile',request()->get('user'))->get()->pluck('id');
            $reservations = $reservations->whereIn('app_user_id', $appUser);
        }
        $reservations = $reservations->orderBy('id','desc')->where('status','!=',0)->paginate(15);
        return view('admin.reservations.index',compact('reservations'));
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
        $message='';
        if ($reservation->status == 1){
            $hashCode = Str::random(7);
            $rateCode = new RateCode();
            $rateCode->clinic_id = $reservation->clinic_id;
            $rateCode->app_user_id = $reservation->app_user_id;
            $rateCode->hash_code = $hashCode;
            $rateCode->save();

            $clinic = Clinic::find($reservation->clinic_id);
            $user = AppUser::find($reservation->app_user_id);
            $phoneNumber = intval($user->mobile);
            $message = route('rate').'?hash='.$hashCode." لتقييم ".$clinic->name_ar." الرجاء الدخول لهذا الرابط ";
            if ($phoneNumber)
                $this->send('966' . $phoneNumber, $message);
        }

        return back();
    }

    public function advancePaymentReturnStatus(Request $request,$id,$status)
    {
        $reservation = Reserve::find($id);
        $user = AppUser::find($reservation->app_user_id);
        $transaction = Transaction::where('reserve_id',$reservation->id)->first();
        if ($status == 1){
            $user->wallet = $user->wallet + $transaction->value;
            $user->save();
            $transaction->delete();
        }
        $reservation->advance_payment_status = $status;
        $reservation->save();

        return back();
    }
}
