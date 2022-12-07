<?php

namespace App\Exports\Sheets;

use App\Models\UnbUssdSurvey;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class SurveyExport implements FromView, WithTitle
{
    protected array $date_range = [];

    public function __construct(array $date_range)
    {
        $this->date_range = $date_range;
    }

    public function view(): View
    {
        $surveys = UnbUssdSurvey::whereBetween('created_at', $this->date_range)
            ->get();

        return view('exports.survey', compact('surveys'));
    }

    public function title(): string
    {
        return 'Survey';
    }
}
