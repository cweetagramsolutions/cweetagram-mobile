<?php

namespace CweetagramSolutions\Mobile\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class SmsHelper
{
    public static function sendInfoBipSms($msisdn, $message)
    {
        try {
            $client = new Client();
            $response = $client->post(config('cweetagramsolutions.infobip_sms_url'),
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'App ' . config('cweetagramsolutions.infobip_token')
                    ],
                    'json' => [
                        'messages' => [
                            'destinations' => [
                                'to' => $msisdn
                            ],
                            'from' => config('app.name'),
                            'text' => $message
                        ]
                    ]
                ]);

            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
}
