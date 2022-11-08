<?php

namespace App\Http\Controllers\Api;

use App\Events\EntryIsPositive;
use App\Http\Controllers\Controller;
use App\Models\Barcode;
use App\Models\UnbUssdLog;
use App\Models\UnbUssdSurvey;
use Cweetagramsolutions\Mobile\Helpers\ChatSession;
use Illuminate\Http\Request;

class UssdController extends Controller
{
    public function __invoke(Request $request)
    {
        $session = ChatSession::findLastSession($request->sessionid, $request->shortcode, $request->msisdn);

        if ($session->process == 1 && $session->step == 1) {

            ChatSession::updateSession($request->sessionid, 1, 2);
            $request->merge(['network' => $request->mobileNetwork]);
            UnbUssdLog::create($request->only('sessionid', 'msisdn', 'network'));

            return response()->json([
                'msisdn' => $request->msisdn,
                'code' => "200",
                'menuText' => trans('ussd.barcodes'),
                'getInput' => "true"
            ]);
        }

        if ($session->process == 1 && $session->step == 2) {

            $log = UnbUssdLog::where('sessionid', $request->sessionid)->first();
            $log->barcode_input = $request->messageString;
            $log->save();

            if (UnbUssdSurvey::where('msisdn', $request->msisdn)->where('state', UnbUssdSurvey::FINISHED_STATE)->count()) {
                $message = $this->workoutEntryState($log);
                ChatSession::finishSession($request->sessionid);
                return response()->json([
                    'msisdn' => $request->msisdn,
                    'code' => "200",
                    'menuText' => $message,
                    'getInput' => "false"
                ]);
            }

            ChatSession::updateSession($request->sessionid, 1, 3);
            UnbUssdSurvey::create($request->only('sessionid', 'msisdn'));

            return response()->json([
                'msisdn' => $request->msisdn,
                'code' => "200",
                'menuText' => trans('ussd.age'),
                'getInput' => "true"
            ]);
        }

        if ($session->process == 1 && $session->step == 3) {
            $age_group = $this->formatAge($request->messageString);
            UnbUssdSurvey::where('msisdn', $request->msisdn)->update(['age_group' => $age_group]);
            ChatSession::updateSession($request->sessionid, 1, 4);

            return response()->json([
                'msisdn' => $request->msisdn,
                'code' => "200",
                'menuText' => trans('ussd.location'),
                'getInput' => "true"
            ]);
        }

        if ($session->process == 1 && $session->step == 4) {

            $location = $this->formatLocation($request->messageString);
            UnbUssdSurvey::where('msisdn', $request->msisdn)->update(['location' => $location, 'state' => UnbUssdSurvey::FINISHED_STATE]);
            ChatSession::finishSession($request->sessionid);
            $log = UnbUssdLog::where('sessionid', $request->sessionid)->first();
            $message = $this->workoutEntryState($log);

            return response()->json([
                'msisdn' => $request->msisdn,
                'code' => "200",
                'menuText' => $message,
                'getInput' => "false"
            ]);
        }
    }

    /**
     * @param $log
     * @return string
     */
    private function workoutEntryState($log)
    {
        $total_number_of_entry_a_week = 3;
        $start_date = now()->startOfWeek();
        $end_date = now()->endOfWeek()->addDay();

        $can_enter = UnbUssdLog::whereBetween('created_at', [$start_date, $end_date])
            ->where('msisdn', $log->msisdn)
            ->where('sessionid', '<>', $log->sessionid)
            ->where('state', UnbUssdLog::POSITIVE_STATE)
            ->count() < $total_number_of_entry_a_week;
        if ($can_enter) {
            $barcode_exists = Barcode::where('digits', $log->barcode_input)->count() > 0;
            if ($barcode_exists) {
                $log->state = UnbUssdLog::POSITIVE_STATE;
                $log->save();
                event(new EntryIsPositive($log));

                return trans('ussd.positive');
            }

            return trans('ussd.negative');
        }
        $log->state = UnbUssdLog::DUPLICATE_STATE;
        $log->save();

        return trans('ussd.duplicate');
    }

    private function formatAge($text)
    {
        switch ($text) {
            case "1":
                return "18-25";
            case "2":
                return "26-30";
            case "3":
                return "31-35";
            case "4":
                return "35-40";
            case "5":
                return "41+";

            default:
                return $text;
        }
    }

    private function formatLocation($text)
    {
        switch ($text) {
            case "1":
                return "Gauteng";
            case "2":
                return "Limpopo";
            case "3":
                return "Mpumalanga";
            case "4":
                return "KwaZulu-Natal";
            case "5":
                return "Western Cape";
            case "6":
                return "Free State";
            case "7":
                return "Northern Cape";
            case "8":
                return "Eastern Cape";
            case "9":
                return "North West";

            default:
                return $text;
        }
    }
}
