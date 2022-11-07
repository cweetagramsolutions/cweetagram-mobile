<?php

namespace Cweetagramsolutions\Mobile\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    const STARTED_STATE = 'started';
    const FINISHED_STATE = 'finished';

    protected $fillable = [
        'code', 'msisdn', 'sessionid', 'state', 'process', 'step'
    ];
}
