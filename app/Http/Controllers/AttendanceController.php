<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Timecard;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance()
    {
        // $user = Auth::user();
        // $items = [];
        $items = User::all();
        $day = Carbon::today();
        $addDay = $day->copy()->addDay();
        $subDay = $day->copy()->subDay();
        $items = Timecard::where('date', $day)->get();
        return view('attendance', compact('items', 'day', 'addDay', 'subDay'));
    }

    public function result(Request $request)
    {
        $user = Auth::user();
        $day = Carbon::today();
        $items = Timecard::where('user_id', $user->id)->where('date', $day)->get();

        return view('attendance', compact('items', 'day'));
    }
}
