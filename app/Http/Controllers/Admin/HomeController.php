<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Clinic\ClinicRequest;
use App\Models\Order\Order;
use App\Models\Service\Reserve;
use App\Models\Transaction\Transaction;
use App\Models\User\AppUser;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $appUsers = AppUser::count() - 1;
        $clinicCount = Clinic::count();
        $clinicRequestCount = ClinicRequest::count();
        $dailyIncome = Transaction::wheredate('created_at', Carbon::today())->sum('value');
        $monthlyIncome = Transaction::wheredate('created_at', '>=', Carbon::today()->subMonth())->sum('value');
        $yearlyIncome = Transaction::wheredate('created_at', '>=', Carbon::today()->subYear())->sum('value');

        $clinicIncome = Transaction::all()->groupBy('clinic_id');
        $clinicIncomeArray = [];
        foreach ($clinicIncome as $item) {
            $itemArray = [];
            foreach ($item as $income) {
                $itemArray['clinic_id'] = $income->clinic->id;
                $itemArray['clinic_name'] = $income->clinic->name_ar;
                $itemArray['daily'] = $income->where('clinic_id', $income->clinic_id)->wheredate('created_at', Carbon::today())->sum('value');
                $itemArray['monthly'] = $income->where('clinic_id', $income->clinic_id)->wheredate('created_at', '>=', Carbon::today()->subMonth())->sum('value');
                $itemArray['yearly'] = $income->where('clinic_id', $income->clinic_id)->wheredate('created_at', '>=', Carbon::today()->subYear())->sum('value');
                $itemArray['completedReservations'] = Reserve::where('clinic_id', $income->clinic_id)->where('status',1)->count();
                $itemArray['unCompletedReservations'] = Reserve::where('clinic_id', $income->clinic_id)->where('status','!=',1)->count();
                break;
            }
            array_push($clinicIncomeArray, (object) $itemArray);

        }
        $clinicIncomeArray = (object)($clinicIncomeArray);

        return view('admin.main.home', compact('appUsers','clinicCount','clinicRequestCount', 'dailyIncome','monthlyIncome','yearlyIncome','clinicIncomeArray'));
    }

    public function telescope()
    {
        return view('admin.main.telescope');

    }

    public function logout()
    {
        Auth::logout();
        return redirect('login/');
    }
}
