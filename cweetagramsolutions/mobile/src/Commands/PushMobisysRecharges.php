<?php

namespace Cweetagramsolutions\Mobile\Commands;

use Cweetagramsolutions\Mobile\Helpers\RechargeHelper;
use Cweetagramsolutions\Mobile\Models\MobisysRecharge;
use Illuminate\Console\Command;

class PushMobisysRecharges extends Command
{
    protected $signature = 'mobisys_recharges:push';
    protected $description = 'Command pushes mobysis airtime recharges';

    public function handle()
    {
        $this->info('Reading pending recharges');
        $pending_recharge = MobisysRecharge::where('state', MobisysRecharge::PENDING_STATE)->first();
        if ($pending_recharge) {
            $pending_recharge->state = MobisysRecharge::LOCKED_STATE;
            $pending_recharge->save();
            $this->info('Processing recharge ' . $pending_recharge->id);

            $cell_number = substr($pending_recharge->msisdn, -9);
            $cell_number = '0' . $cell_number;
            $this->info('Cell ' . $pending_recharge->msisdn . ' converted to ' .$cell_number);
            $response = RechargeHelper::recharge($pending_recharge->uid, $cell_number, $pending_recharge->product_code, $pending_recharge->amount_in_cents, $pending_recharge->recharge_type);
            $pending_recharge->state = MobisysRecharge::SENT_STATE;
            $pending_recharge->provider_response = $response;
            $pending_recharge->save();
            $this->info($pending_recharge->id . ' processed!');
        }
    }
}
