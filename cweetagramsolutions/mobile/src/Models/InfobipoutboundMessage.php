<?php

namespace Cweetagramsolutions\Mobile\Models;

use Illuminate\Database\Eloquent\Model;

class InfobipoutboundMessage extends Model
{
    protected $guarded = [];

    const PENDING_STATE = 'pending';
    const LOCKED_STATE = 'locked';
    const SENT_STATE = 'sent';
}
