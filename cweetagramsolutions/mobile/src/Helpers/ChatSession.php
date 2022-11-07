<?php

namespace Cweetagramsolutions\Mobile\Helpers;

use Cweetagramsolutions\Mobile\Models\ChatSession as Model;

class ChatSession
{
    /**
     * @param string $sessionid
     * @param string $code
     * @param string $msisdn
     * @return mixed
     */
    public static function findLastSession(string $sessionid, string $code, string $msisdn)
    {
        $session = Model::firstOrCreate([
            'sessionid' => $sessionid,
            'code' => $code,
            'msisdn' => $msisdn,
            'state' => Model::STARTED_STATE
        ]);

        return $session;
    }

    /**
     * @param string $sessionid
     * @param int $process
     * @param int $step
     * @return void
     */
    public static function updateSession(string $sessionid, int $process, int $step)
    {
        Model::where('sessionid', $sessionid)
            ->update(['process' => $process, 'step' => $step]);
    }

    /**
     * @param $sessionid
     * @return void
     */
    public static function finishSession($sessionid)
    {
        Model::where('sessionid', $sessionid)
            ->update(['state' => Model::FINISHED_STATE]);
    }
}
