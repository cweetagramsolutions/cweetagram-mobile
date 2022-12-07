<?php

namespace App\Exports;

use App\Exports\Sheets\LogExport;
use App\Exports\Sheets\SurveyExport;
use App\Models\UnbUssdLog;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EntriesExport implements WithMultipleSheets
{

    protected $start_date;
    protected $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function sheets(): array
    {
        return [
            new LogExport(UnbUssdLog::POSITIVE_STATE, [$this->start_date, $this->end_date]),
            new LogExport(UnbUssdLog::NEGATIVE_STATE, [$this->start_date, $this->end_date]),
            new LogExport(UnbUssdLog::DUPLICATE_STATE, [$this->start_date, $this->end_date]),
            new SurveyExport([$this->start_date, $this->end_date])
        ];
    }
}
