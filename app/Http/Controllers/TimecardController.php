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
        $timecard = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        if ($timecard === null) {
            $timestampForStartRest = null;
        } else {
            $timestampForStartRest = Rest::where('timecard_id', $timecard->id)->whereNotNull('rest_start')->latest()->first();
        }
        // 休憩終了チェック
        if ($timecard === null) {
            $timestampForFinishRest = null;
        } else {
            $timestampForFinishRest = Rest::where('timecard_id', $timecard->id)->WhereNull('rest_finish')->latest()->first();
        }

        
        // $timestampForFinishRest = Rest::whereNull('rest_finish')->whereIn('timecard_id', $id);
        // $timestampForFinishRest->latest()->first();

        // 初回アクセス時
        $startedWork = false;
        $finishedWork = true;
        $startedRest = true;
        $finishedRest = true;

        // 退勤
        if ($timestamp === null) {
            $startedWork = false;
            $finishedWork = true;
            $startedRest = true;
            $finishedRest = true;
        } else if ($timestampForFinishWork !== null) {
            $startedWork = true;
            $finishedWork = true;
            $startedRest = true;
            $finishedRest = true;

            // 休憩
        } else if ($timestampForStartRest !== null && $timestampForFinishRest !== null) {
            $startedWork = true;
            $finishedWork = true;
            $startedRest = true;
            $finishedRest = false;

            // 休憩終了
        } else if ($timestampForFinishRest  === null) {
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

    public function dateSample() {
        $user = Auth::user();
        $timecard = Timecard::where('user_id', $user->id)->latest()->first();

        // Timecardテーブルのwork_startを取得して、Carbonに変換
        $work_start = new Carbon($timecard->work_start);

         // Timecardテーブルのwork_finishを取得して、Carbonに変換
        $work_finish = new Carbon($timecard->work_finish);

        // $work_finishと$work_startの時間差を秒単位で計算する。
        $work_time = $work_finish->diffInSeconds($work_start);

        // 勤務時間の○時間の部分を計算する
        $work_time_hour = floor($work_time / 3600);

        // 勤務時間の○分の部分を計算する
        $work_time_minute = floor(($work_time / 60) % 60);

        // 勤務時間の○秒の部分を計算する
        $work_time_second = $work_time % 60;

        return "あなたの勤務時間(休憩考慮しない)は${work_time_hour}:${work_time_minute}:${work_time_second}です";
    }



    public function getLogout()
    {
        Auth::logout();
        return redirect('login');
    }
}
