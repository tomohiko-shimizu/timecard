<?php

namespace App\Http\Controllers;

use App\Models\Timecard;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimecardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $timecardID = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();

        // 退勤チェック
        $timestampForFinishWork = Timecard::where('user_id', $user->id)->where('date', $today)->whereNotNull('work_finish')->latest()->first();

        // 休憩チェック
        if ($timecardID === null) {
            $timestampForStartRest = null;
        } else {
            $timestampForStartRest = Rest::where('timecard_id', $timecardID->id)->whereNotNull('rest_start')->latest()->first();
        }

        // 休憩終了チェック
        if ($timecardID === null) {
            $timestampForFinishRest = null;
        } else {
            $timestampForFinishRest = Rest::where('timecard_id', $timecardID->id)->WhereNull('rest_finish')->latest()->first();
        }

        // ログイン後
        if ($timecardID === null) {
            $startedWork = false;
            $finishedWork = true;
            $startedRest = true;
            $finishedRest = true;
            // 退勤ボタン押した
        } else if ($timestampForFinishWork !== null) {
            $startedWork = true;
            $finishedWork = true;
            $startedRest = true;
            $finishedRest = true;
            // 休憩開始ボタン押した
        } else if ($timestampForStartRest !== null && $timestampForFinishRest !== null) {
            $startedWork = true;
            $finishedWork = true;
            $startedRest = true;
            $finishedRest = false;
            // 休憩終了ボタン押した
        } else if ($timestampForStartRest !== null && $timestampForFinishRest === null) {
            $startedWork = true;
            $finishedWork = false;
            $startedRest = false;
            $finishedRest = true;
            // 出勤ボタン押した
        } else
        if ($timecardID !== null) {
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
        $timecardID = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        if ($timecardID === null) {
            $timecardID = Timecard::create([
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
        $today = Carbon::today();
        $timecardID = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        $timecardID->update([
            'work_finish' => Carbon::now(),
        ]);

        return redirect()->action([TimecardController::class, 'index']);
    }

    // 休憩+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function restStart()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $timecardID = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        $restID = Rest::where('timecard_id', $timecardID->id)->latest()->first();
        $restID = Rest::create([
            'timecard_id' => $timecardID->id,
            'rest_start' => Carbon::now(),
        ]);

        return redirect()->action([TimecardController::class, 'index']);
    }

    public function restFinish()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $timecardID = Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        $restID = Rest::where('timecard_id', $timecardID->id)->latest()->first();
        $restID->update([
            'rest_finish' => Carbon::now(),
        ]);
        return redirect()->action([TimecardController::class, 'index']);
    }

    // ログアウト+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function getLogout()
    {
        Auth::logout();
        return redirect('login');
    }
}
