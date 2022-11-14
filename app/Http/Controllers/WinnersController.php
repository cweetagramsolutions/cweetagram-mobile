<?php

namespace App\Http\Controllers;

use App\Events\WinnerDrawApproved;
use App\Exports\WinnersExport;
use App\Models\UnbUssdDraw;
use App\Models\UnbUssdLog;
use App\Models\UnbUssdWinner;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WinnersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $draws = UnbUssdDraw::orderBy('id', 'desc')
            ->where('state', 'approved')
            ->get();

        return view('pages.winners.index', compact('draws'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postDraw(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'number_of_winners' => 'required|numeric'
        ]);

        $draw = UnbUssdDraw::firstOrCreate($request->only('start_date', 'end_date'), [
            'name' => sprintf('Draw %s - %s', $request->start_date, $request->end_date)
        ]);

        $past_winners = UnbUssdWinner::all()->pluck('msisdn')->toArray();
        $potential_winners = UnbUssdLog::where('state', UnbUssdLog::POSITIVE_STATE)
            ->whereBetween('created_at', [$request->start_date, date('Y-m-d', strtotime($request->end_date . ' + 1 day'))])
            ->whereNotIn('msisdn', $past_winners)
            ->limit($request->number_of_winners)
            ->get();

        if ($potential_winners->count()) {
            foreach($potential_winners as $potential_winner) {
                if (UnbUssdWinner::where('msisdn', $potential_winner->msisdn)->count() === 0) {
                    UnbUssdWinner::create([
                        'draw_id' => $draw->id,
                        'sessionid' => $potential_winner->sessionid,
                        'msisdn' => $potential_winner->msisdn
                    ]);
                }
            }

            return redirect(route('winners.draw', $draw->id));
        }

        $draw->delete();

        return redirect()->back()
            ->with('error', 'No winners found for this period')
            ->withInput();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function draw($id)
    {
        $draw = UnbUssdDraw::findOrFail($id);
        $winners = UnbUssdWinner::where('draw_id', $id)->get();

        return view('pages.winners.draw', compact('draw', 'winners'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateState($id, Request $request)
    {
        $draw = UnbUssdDraw::findOrFail($id);
        if ($request->state === 'declined') {
            $draw->delete();
        } else {
            $draw->update($request->only('state'));
        }

        return redirect(route('winners.index'));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($id)
    {
        $draw = UnbUssdDraw::findOrFail($id);

        return Excel::download(new WinnersExport($draw), $draw->name . '.xlsx');
    }
}
