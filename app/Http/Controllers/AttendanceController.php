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

        // $items = Timecard::where('date', $day)->get();
        $items = Timecard::where('date', $day)->paginate(3);

        return view(
            'attendance',
            // 'test',
            compact(
                'items',
                'day',
            )
        );
    }
}
