<?php

namespace Cweetagramsolutions\Mobile\Helpers;

use Illuminate\Support\Facades\Log;

class NetworkHelper
{
    /**
     * @param $network
     * @return string
     */
    public static function getMobisysNetworkName($network)
    {
        $infoBipNetworkNames = [
            'VodaCom' => 'Vodacom',
            'Cell C' => 'CellC',
            'MTN-SA' => 'Mtn',
            'TELKOM (8TA)' => 'TelkomMobile'
        ];

        try {
            return $infoBipNetworkNames[$network];
        } catch (\Exception $e) {
            Log::error('Could not fetch network name for ' . $network);

            return $network;
        }
    }
}
