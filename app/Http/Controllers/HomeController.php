<?php

namespace App\Http\Controllers;

use Cweetagramsolutions\Mobile\Models\MobisysRecharge;
use Illuminate\Http\Request;

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
        $recharge = MobisysRecharge::selectRaw('SUM(amount_in_cents) as total_airtime')->first();
        $total_airtime = $recharge ? $recharge->total_airtime/100 : 0;

        return view('home', compact('total_airtime'));
    }
}
