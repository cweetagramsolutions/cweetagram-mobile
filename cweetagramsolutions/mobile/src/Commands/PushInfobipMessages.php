<?php

namespace Cweetagramsolutions\Mobile\Commands;

use Cweetagramsolutions\Mobile\Helpers\SmsHelper;
use Cweetagramsolutions\Mobile\Models\InfobipoutboundMessage;
use Illuminate\Console\Command;

class PushInfobipMessages extends Command
{
    protected $signature = 'infobip_outbound:push';

    protected $description = 'Command pushes outbound smses to provider';

    public function handle()
    {
        $this->info('Reading pending messages');
        $pending_message = InfobipoutboundMessage::where('state', InfobipoutboundMessage::PENDING_STATE)->first();
        if ($pending_message) {
            $pending_message->state = InfobipoutboundMessage::LOCKED_STATE;
            $pending_message->save();
            $this->info('Message id '.$pending_message->id . ' sending ...');
            $response = SmsHelper::sendInfoBipSms($pending_message->msisdn, $pending_message->message);
            $pending_message->state = InfobipoutboundMessage::SENT_STATE;
            $pending_message->provider_response = $response;
            $pending_message->save();

            $this->info('message sent');
        }
    }
}
