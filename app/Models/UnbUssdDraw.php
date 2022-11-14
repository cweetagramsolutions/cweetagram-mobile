<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnbUssdDraw extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function winners()
    {
        return $this->hasMany(UnbUssdWinner::class, 'draw_id', 'id');
    }
}
