<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnbUssdSurvey extends Model
{
    use HasFactory;
    const FINISHED_STATE = 'finished';
    const PENDING_STATE = 'pending';

    protected $fillable= [
        'sessionid', 'msisdn', 'age_group', 'location', 'state'
    ];
}
