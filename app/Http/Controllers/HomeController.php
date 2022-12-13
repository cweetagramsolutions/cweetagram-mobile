<?php

namespace App\Http\Controllers;

use App\Exports\AirtimeRecharges;
use App\Exports\EntriesExport;
use Carbon\Carbon;
use Cweetagramsolutions\Mobile\Models\MobisysRecharge;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $end_date = Carbon::parse($request->end_date)
            ->addDay()
            ->format('Y-m-d');

        return Excel::download(new EntriesExport($request->start_date, $end_date), time() . '.xlsx');
    }

    public function exportAirtime()
    {
        return Excel::download(new AirtimeRecharges(), sprintf('airtime_download%s.%s', time(), '.xlsx'));
    }
}
