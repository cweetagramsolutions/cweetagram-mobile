<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WinnersExport implements FromView
{
    protected $draw;

    /**
     * @param $draw
     * @return void
     */
    public function __construct($draw)
    {
        $this->draw = $draw;
    }

    public function view(): View
    {
        $winners = $this->draw->winners;

        return view('exports.winners', compact('winners'));
    }
}
