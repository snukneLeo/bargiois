<?php

namespace App\Http\Controllers;

use App\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    // return total pasta by ajax call
    public static function totalPasta()
    {
        if(request()->ajax())
        {
            return response()->json(['total' => Statistic::getStatistics()->first()->total]);
        }
    }

    // save total pasta from form
    public static function saveTotalPasta()
    {
        // get qt_pasta from form
        $total_pasta = request()->only('qt_total_pasta');

        // save qt_total_pasta on statistics table
        Statistic::saveTotalPasta($total_pasta);

        return redirect()->back();
    }
}
