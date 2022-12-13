<?php

namespace App\Exports;

use Cweetagramsolutions\Mobile\Models\MobisysRecharge;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AirtimeRecharges implements FromView
{
   public function view(): View
   {
       $recharges = MobisysRecharge::orderBy('id', 'desc')->get();

       return view('exports.recharges', compact('recharges'));
   }
}
