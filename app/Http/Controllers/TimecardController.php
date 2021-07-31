<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Timecard;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimecardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $timestamp = Timecard::where('user_id', $user->id)->where('date', $today)->first();
        $startedWork = false;
        if ($timestamp !== null) {
            $startedWork  = true;
        } else {
            $startedWork = false;
        }
        return view('index', ['user' => $user, 'startedWork' => $startedWork]);
    }


    public function workStart()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $timestamp = Timecard::where('user_id', $user->id)->where('date', $today)->first();
        if ($timestamp === null) {
            $timestamp = Timecard::create([
                'user_id' => $user->id,
                'date' => $today,
                'work_start' => Carbon::now(),
            ]);
        }
        return redirect('/');
    }

    public function workFinish()
    {
        $user = Auth::user();
        // $timestamp = Timecard::find($request->id);
        $timestamp = Timecard::where('user_id', $user->id)->latest()->first();

        // $test = [
        //     'work_finish' => Carbon::now(),
        // ];
        // DB::table('timecards')->insert($test);

        $timestamp->update([
            'work_finish' => Carbon::now(),
        ]);
        return redirect('/');
    }


    public function getLogout()
    {
        Auth::logout();
        return redirect('login');
    }
}
