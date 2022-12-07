<?php

namespace App\Exports\Sheets;

use App\Models\UnbUssdLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class LogExport implements FromView, WithTitle
{
    protected $state;

    protected array $date_range = [];

    public function __construct($state, array $date_range)
    {
        $this->state = $state;
        $this->date_range = $date_range;
    }

    public function view(): View
    {
        $logs = UnbUssdLog::where('state', $this->state)
            ->whereBetween('created_at', $this->date_range)
            ->get();

        return view('exports.logs', compact('logs'));
    }

    public function title(): string
    {
        return sprintf('%s entries', ucfirst($this->state));
    }
}
