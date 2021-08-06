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
        $now = new Carbon();
        $timestamp = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();

        // 退勤チェック
        $timestampForFinishWork = Timecard::where('user_id', $user->id)->where('work_finish', $now)->latest()->first();

        // 休憩チェック
        $id = Timecard::where('user_id', $user->id)->latest()->first();
        $timestampForStartRest = Rest::whereIn('timecard_id', $id)->whereNotNull('rest_start')->latest()->first();

        // 休憩終了チェック
        $timestampForFinishRest = Rest::whereIn('timecard_id', $id)->WhereNull('rest_finish')->latest()->first();
        // $timestampForFinishRest = Rest::whereNull('rest_finish')->whereIn('timecard_id', $id);
        // $timestampForFinishRest->latest()->first();

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
        } else if ($timestampForStartRest !== null && $timestampForFinishRest === null) {
            $startedWork = true;
            $finishedWork = true;
            $startedRest = true;
            $finishedRest = false;

            // 休憩終了
        } else if ($timestampForFinishRest !== null) {
            $startedWork = true;
            $finishedWork = false;
            $startedRest = false;
            $finishedRest = true;

            // 出勤
        } else
        if ($timestamp !== null) {
            $startedWork = true;
            $finishedWork = false;
            $startedRest = false;
            $finishedRest = true;
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
            // return redirect()->action([TimecardController::class, 'index']);
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
        $id = Timecard::where('user_id', $user->id)->latest()->first();
        $timestamp = Rest::whereIn('timecard_id', $id)->latest()->first();
        $timestamp = Rest::create([
            'timecard_id' => $id->id,
            'rest_start' => Carbon::now(),
        ]);

        return redirect()->action([TimecardController::class, 'index']);
    }


    public function restFinish()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $id = Timecard::where('user_id', $user->id)->latest()->first();
        // $timecardId = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        // $timestamp = Rest::where('timecard_id', $id->id)->latest()->first();
        $timestamp = Rest::whereIn('timecard_id', $id)->latest()->first();
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
