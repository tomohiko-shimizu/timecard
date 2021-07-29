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
        $user = Auth::user()->name;
        return view('index', ['user' => $user]);
    }


    public function workStart()
    {
        $user = Auth::user();
        $timestamp = Timecard::where('user_id', $user->id)->latest()->first();
        $timestamp = Timecard::create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'work_start' => Carbon::now(),
        ]);
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
}
