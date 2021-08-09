<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Timecard;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance()
    {
        $day = Carbon::today();

        $items = Timecard::where('date', $day)->first();
        var_dump($items);
        // $work_start = new Carbon($items->work_start);
        // $work_finish = new Carbon($items->work_finish);
        // $work_time = $work_finish->diffInSeconds($work_start);
        // $work_time_hour = floor($work_time / 3600);
        // $work_time_minute = floor(($work_time / 60) % 60);
        // $work_time_second = $work_time % 60;

        // $time_worked = $work_time_hour . ":" . $work_time_minute . ":" . $work_time_second;


        return view(
            'attendance',
            compact(
                'items',
                'day',
                // 'time_worked',
                // 'work_time_hour',
                // 'work_time_minute',
                // 'work_time_second',
            )
        );
    }

    public function result(Request $request)
    {
        $day = Carbon::today();
        $items = Timecard::where('date', $day)->get();

        return view('attendance', compact('items', 'day'));
    }
}
