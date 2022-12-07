<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnbUssdLog;
use App\Models\UnbUssdSurvey;
use Cweetagramsolutions\Mobile\Models\MobisysRecharge;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardDataSetController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logCounts()
    {
        $states = [
            UnbUssdLog::POSITIVE_STATE,
            UnbUssdLog::NEGATIVE_STATE,
            UnbUssdLog::DUPLICATE_STATE
        ];

        $data['Total'] = UnbUssdLog::count();
        foreach ($states as $state) {
            $data[ucfirst($state)] = UnbUssdLog::where('state', $state)->count();
        }

        return response()->json($data);
    }

    public function airtime()
    {
        return datatables()->of(MobisysRecharge::orderBy('id', 'desc'))
            ->editColumn('provider_response', function ($recharge) {
                return view('partials.dashboard.provider_response', ['log' => $recharge]);
            })
            ->make(true);
    }

    /**
     * @param $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function dailyCounts($month)
    {
        $start_date = Carbon::create('2022', $month, '01');
        $end_date = Carbon::create('2022', $month, '01')->addMonth()->format('Y-m-d');
        $data[] = DB::table('unb_ussd_logs')->whereBetween('created_at', [$start_date->format('Y-m-d'), Carbon::create('2022', $month, '01')->addDay()->format('Y-m-d')])
            ->count();
        $date_data[] = $start_date->format('d M');
        $start = Carbon::create('2022', $month, '01')->addDay();
        $end = Carbon::create('2022', $month, '01')->addDays(2);
        do {
            $date_data[] = $start->format('d M');
            $data[] = DB::table('unb_ussd_logs')->whereBetween('created_at', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                ->count();
            $start->addDay();
            $end->addDay();
        } while (strtotime($start->format('Y-m-d')) < strtotime($end_date));

        return response()->json([
            'labels' => $date_data,
            'data' => $data
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Yajra\DataTables\Exceptions\Exception
     */
    public function entriesList()
    {
        return datatables()->of(UnbUssdLog::orderBy('id', 'desc'))
            ->editColumn('created_at', function ($log) {
                return date('Y-m-d H:i:s', strtotime($log->created_at));
            })
            ->editColumn('state', function ($log) {
                return ucfirst($log->state);
            })
            ->make(true);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ageStats()
    {
        $ages = ["18-25", "26-30", "31-35", "35-40", "41+"];
        $age_data = [];

        foreach($ages as $age) {
            $age_data['labels'][] = $age;
            $age_data['data'][] = DB::table('unb_ussd_surveys')
                ->where('age_group', $age)
                ->count();
            $age_data['bgColors'][] = 'rgb(54, 162, 235)';
        }

        return response()->json($age_data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function regionStats()
    {
        $regions = ["Gauteng", "KwaZulu-Natal", "Limpopo", "North West", "Northern Cape", "Western Cape", "Eastern Cape", "Mpumalanga", "Free State"];
        $region_data = [];

        foreach($regions as $region) {
            $region_data['labels'][] = $region;
            $region_data['data'][] = DB::table('unb_ussd_surveys')
                ->where('location', $region)
                ->count();
            $region_data['bgColors'][] = 'rgb(54, 162, 235)';
        }

        return response()->json($region_data);
    }
}
