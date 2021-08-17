<?php

namespace App\Http\Controllers;

use App\Models\Timecard;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance(Request $request)
    {
        $date = $request->date;
        if ($date === null) {
            $day = Carbon::today();
        } else {
            $day = new Carbon($date);
        }
        $addDay = $day->addDay();
        $subDay = $day->subDay();

        $items = Timecard::where('date', $day)->get();
        /*
        foreach ($items as $item) {
            $work_start = new Carbon($item->work_start);
            $work_finish = new Carbon($item->work_finish);
            $work_time = $work_finish->diffInSeconds($work_start);
            $work_time_hour = floor($work_time / 3600);
            $work_time_minute = floor(($work_time / 60) % 60);
            $work_time_second = $work_time % 60;
        }

        */
        return view(
            'attendance',
            compact(
                'items',
                'day',
                'addDay',
                'subDay',
            )
        );
    }

    public function subday()
    {
        $day = Carbon::today();
        $subDay = $day->subDay();

        $items = Timecard::where('date', $subDay)->get();

        foreach ($items as $item) {
            $work_start = new Carbon($item->work_start);
            $work_finish = new Carbon($item->work_finish);
            $work_time = $work_finish->diffInSeconds($work_start);
            $work_time_hour = floor($work_time / 3600);
            $work_time_minute = floor(($work_time / 60) % 60);
            $work_time_second = $work_time % 60;
        }

        return view(
            'attendance',
            ['subDay' => $subDay],
            compact(
                'items',
                'day',
                'subDay'
            )
        );
    }



    // テスト
    public function test()
    {
        $day = Carbon::today();
        $subDay = $day->subDay();

        $items = Timecard::where('date', $subDay)->get();

        foreach ($items as $item) {
            $work_start = new Carbon($item->work_start);
            $work_finish = new Carbon($item->work_finish);
            $work_time = $work_finish->diffInSeconds($work_start);
            $work_time_hour = floor($work_time / 3600);
            $work_time_minute = floor(($work_time / 60) % 60);
            $work_time_second = $work_time % 60;
        }

        return view(
            'attendance',
            ['subDay' => $subDay],
            compact(
                'items',
                'day',
                'subDay',
            )
        );
    }
}
