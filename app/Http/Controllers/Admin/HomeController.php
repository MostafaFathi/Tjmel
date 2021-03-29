<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic\Clinic;
use App\Models\Clinic\ClinicRequest;
use App\Models\Order\Order;
use App\Models\Service\Appointment;
use App\Models\Service\Offer;
use App\Models\Service\Reserve;
use App\Models\Service\Service;
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
        if (!auth()->user()->hasRole('admin')) return redirect()->to(route('dashboard'));
        $appUsers = AppUser::count() - 1;
        $clinicCount = Clinic::count();
        $clinicRequestCount = ClinicRequest::count();
        $services = Service::count();
        $offers = Offer::count();
        $totalReservations = Reserve::where('status','!=',0)->count();
        $totalCompletedReservations = Reserve::where('status',1)->count();
        $totalComingReservations = Reserve::where('status',5)->count();
        $totalUnCompletedReservations = Reserve::whereIn('status',[2,3,4])->count();
        $usersWallet = AppUser::sum('wallet');
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
                $itemArray['totalReservations'] = Reserve::where('clinic_id', $income->clinic_id)->where('status','!=',0)->count();
                $itemArray['totalComingReservations'] = Reserve::where('clinic_id', $income->clinic_id)->where('status',5)->count();
                $itemArray['completedReservations'] = Reserve::where('clinic_id', $income->clinic_id)->where('status',1)->count();
                $itemArray['unCompletedReservations'] = Reserve::where('clinic_id', $income->clinic_id)->whereIn('status',[2,3,4])->count();
                break;
            }
            array_push($clinicIncomeArray, (object) $itemArray);

        }
        $clinicIncomeArray = (object)($clinicIncomeArray);

        return view('admin.main.home', compact('appUsers','services','offers','totalReservations','totalCompletedReservations','totalUnCompletedReservations','totalComingReservations','usersWallet','clinicCount','clinicRequestCount', 'dailyIncome','monthlyIncome','yearlyIncome','clinicIncomeArray'));
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

    public function test($id)
    {
        $reservation = Reserve::find($id);
        $appointment = Appointment::wheredate('date', Carbon::parse($reservation->appointment_date))->where('service_type', $reservation->service_type)->first();
        $appointmentTimes = $appointment->times;
        foreach ($appointment->times as $key => $time) {
            if (isset($time['time']) and $time['time'] == Carbon::parse($reservation->appointment_time)->format('h:i a')) {
                $appointmentTimes[$key]['status'] = 'reserved';
                dd( $time['time']);
                break;
            }
        }
        dd($appointmentTimes);
        $appointment->times = $appointmentTimes;
    }
}
