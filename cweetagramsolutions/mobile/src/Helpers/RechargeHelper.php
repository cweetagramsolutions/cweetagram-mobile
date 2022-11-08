<?php

namespace Cweetagramsolutions\Mobile\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class RechargeHelper
{
    private static $product_codes = [
        'Vodacom' => 'f0bbe13e-3ea3-4001-a070-84c7d99cf7e3',
        'Mtn' => '678a8515-e670-476e-acda-56615b959b08',
        'TelkomMobile' => '08089e1f-68e2-4442-9074-39e7dc17f20b',
        'CellC' => '1fa967c9-e1bd-422c-a49a-1cc8e06c6929'
    ];

    /**
     * @param $id
     * @param $msisdn
     * @param $product_code
     * @param $amount_in_cents
     * @param $recharge_type
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function recharge($id, $msisdn, $product_code, $amount_in_cents, $recharge_type = 1)
    {
        $recharge_data['UserAccount'] = array(
            'UserName' => config('cweetagramsolutions.airtime_account'),
            'Password' => config('cweetagramsolutions.airtime_account_password')
        );

        $recharge_data['Account'] = array(
            'AccountNumber' => config('cweetagramsolutions.airtime_wallet_id'),
            'Password' => config('cweetagramsolutions.airtime_wallet_password')
        );

        $recharge_data['MNORechargeRequestItems'][] = array(
            'AmountInCents' => $amount_in_cents,
            'ClientCorrelationId' => $id,
            'MNORechargeType' => $recharge_type,
            'Msisdn' => $msisdn,
            'ProductCode' => $product_code
        );

        Log::info(json_encode($recharge_data));

        $client = new Client();
        try {
            $response = $client->post(config('cweetagramsolutions.airtime_recharge_url'), [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => $recharge_data
            ]);

            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }

    /**
     * @param $network
     * @return string
     */
    public static function getProductCode($network)
    {
        return $product_code = self::$product_codes[$network];
    }
}
