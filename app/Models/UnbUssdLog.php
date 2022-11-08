<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnbUssdLog extends Model
{
    use HasFactory;

    const POSITIVE_STATE = 'positive';
    const NEGATIVE_STATE = 'negative';
    const DUPLICATE_STATE = 'duplicate';

    protected $fillable = [
        'sessionid', 'msisdn', 'network', 'barcode_input', 'state'
    ];
}
