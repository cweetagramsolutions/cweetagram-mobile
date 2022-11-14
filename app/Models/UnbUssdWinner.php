<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnbUssdWinner extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function log()
    {
        return $this->hasOne(UnbUssdLog::class, 'sessionid', 'sessionid');
    }
}
