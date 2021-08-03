<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Timecard;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class TimecardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();
        $timestamp = Timecard::where('user_id', $user->id)->where('date', $today)->first();

        // 退勤チェック
        $timestampForFinishWork = Timecard::where('user_id', $user->id)->where('work_finish', $now)->first();

        // 休憩スタートチェック registerから遷移不可
        // $timecardId = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        // $timestampForStartRest = Rest::where('timecard_id', $timecardId->id)->where('rest_start', $now)->first();

        // 初回アクセス時
        $startedWork = false;
        $finishedWork = true;
        $startedRest = true;
        $finishedRest = true;

        // 退勤
        if ($timestampForFinishWork !== null) {
            $startedWork = true;
            $finishedWork = true;
            $startedRest = true;
            $finishedRest = true;

            // 休憩
            // } else if ($timestampForStartRest !== null) {
            //     $startedWork = true;
            //     $finishedWork = true;
            //     $startedRest = true;
            //     $finishedRest = false;

            // 出勤
        } else
        if ($timestamp !== null) {
            $startedWork = true;
            $finishedWork = false;
            $startedRest = false;
            $finishedRest = false;
        };

        return view(
            'index',
            [
                'user' => $user,
                'startedWork' => $startedWork,
                'finishedWork' => $finishedWork,
                'startedRest' => $startedRest,
                'finishedRest' => $finishedRest,
            ]
        );
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
            return redirect('/');
        }
    }

    public function workFinish()
    {
        $user = Auth::user();
        $timestamp = Timecard::where('user_id', $user->id)->latest()->first();
        // var_dump($timestamp);

        $timestamp->update([
            'work_finish' => Carbon::now(),
        ]);

        return redirect()->action([TimecardController::class, 'index']);
    }

    // 休憩+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function restStart()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $timecardId = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        $timestamp = Rest::where('timecard_id', $timecardId->id)->first();
        if ($timestamp === null) {
            $timestamp = Rest::create([
                'timecard_id' => $timecardId->id,
                'rest_start' => Carbon::now(),
            ]);
        }
        // return redirect('/');
        return redirect()->action([TimecardController::class, 'index']);
    }

    public function restFinish()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $timecardId = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        $timestamp = Rest::where('timecard_id', $timecardId->id)->first();
        $timestamp->update([
            'rest_finish' => Carbon::now(),
        ]);
        return redirect()->action([TimecardController::class, 'index']);
    }



    public function getLogout()
    {
        Auth::logout();
        return redirect('login');
    }
}
