<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
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
        $appUsers = 0;
        $agents = 0;
        $approvedOrders = 0;
        $canceledOrders = 0;
        $agentsOrders = [];
            $appUsers = 0;
            $orders = 0;
            $agents = 0;
            $agentsOrders = [];
            $todayIncome = 0;
            $monthIncome = 0;
            $yearIncome = 0;
        return view('admin.main.home',compact('appUsers','agentsOrders','orders','approvedOrders','canceledOrders','agents','todayIncome','monthIncome','yearIncome'));
    }

    public function telescope(){
        return view('admin.main.telescope');

    }

    public function logout(){
        Auth::logout();
        return redirect('login/');
    }
}
