<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Cweetagramsolutions\Mobile\Helpers\ChatSession;
use Illuminate\Http\Request;

class UssdController extends Controller
{
    public function __invoke(Request $request)
    {
        $session = ChatSession::findLastSession($request->sessionid, $request->shortcode, $request->msisdn);

        if ($session->process == 1 && $session->step == 1) {

            ChatSession::updateSession($request->sessionid, 1, 2);

            return response()->json([
                'msisdn' => $request->msisdn,
                'code' => 200,
                'menuText' => "Welcome to the Chibuku Super Campaign\nPlease enter the last 4 digits of your product barcode",
                'getInput' => true
            ]);
        }

        if ($session->process == 1 && $session->step == 2) {

            ChatSession::updateSession($request->sessionid, 1, 3);

            return response()->json([
                'msisdn' => $request->msisdn,
                'code' => 200,
                'menuText' => "Please enter your age below?\n1.18-25\n2.26-30\n3.31-35\n4.35-40\n5.41+",
                'getInput' => true
            ]);
        }

        if ($session->process == 1 && $session->step == 3) {

            ChatSession::updateSession($request->sessionid, 1, 4);

            return response()->json([
                'msisdn' => $request->msisdn,
                'code' => 200,
                'menuText' => "Which region do you reside from?\n1. GP\n2. Limpopo\n3. MP\n4. KZN\n5. WCape\n6. FState\n7. NCape\n8. ECape\n9. NWest",
                'getInput' => true
            ]);
        }

        if ($session->process == 1 && $session->step == 4) {

            ChatSession::finishSession($request->sessionid);

            return response()->json([
                'msisdn' => $request->msisdn,
                'code' => 200,
                'menuText' => "Thank you for your entry, You've been entered into the draw to Stand a chance of winning daily, weekly and grand prizes. Keep your till slip. T's and C's apply",
                'getInput' => false
            ]);
        }
    }
}
