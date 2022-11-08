<?php

namespace App\Listeners;

use Cweetagramsolutions\Mobile\Helpers\NetworkHelper;
use Cweetagramsolutions\Mobile\Helpers\RechargeHelper;
use Cweetagramsolutions\Mobile\Models\InfobipoutboundMessage;
use Cweetagramsolutions\Mobile\Models\MobisysRecharge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EntryIsPositiveEventListener
{
    /**
     * Handles actions when an entry is positive.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $airtime_winner_frequency = 1;
        $airtime_amount = 1500;
        $daily_total_winners = 10;
        $log = $event->log;
        if ($log->id % $airtime_winner_frequency === 0) {
            $start_date = now()->startOfDay();
            $end_date = now()->endOfDay();

            $can_reward_airtime = MobisysRecharge::whereBetween('created_at', [$start_date, $end_date])->count() < 10;
            if ($can_reward_airtime) {
                InfobipoutboundMessage::create([
                    'uid' => $log->sessionid,
                    'msisdn' => $log->msisdn,
                    'message' => trans('ussd.airtime')
                ]);

                $network = NetworkHelper::getMobisysNetworkName($log->network);
                $product_code = RechargeHelper::getProductCode($network);
                MobisysRecharge::create(
                    [
                        'uid' => $log->sessionid,
                        'msisdn' => $log->msisdn,
                        'amount_in_cents' => $airtime_amount,
                        'product_code' => $product_code,
                        'recharge_type' => 1
                    ]
                );
            }

        }
    }
}
