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
        $timecard = Timecard::where('user_id', $user->id)->where('date', $today)->first();

        // 勤務開始前か
        $isWorkingBefore = $timecard === null;
        // 勤務時間内か(勤務終了を押していない。)
        $isWorkingTime = false;
        // 休憩中か？(休憩開始して終了していないRestがある)
        $isBreakTime = false;

        if (!$isWorkingBefore) {
            $isWorkingTime = $timecard->work_finish === null;
            $isBreakTime = !Rest::where('timecard_id', $timecard->id)->whereNull('rest_finish')->get()->isEmpty();
        }

        // 勤務状況からボタンの押せる・押せないを判定する。
        $workBeginEnable = $isWorkingBefore;
        $workFinishEnable = $isWorkingTime && !$isBreakTime;
        $restBeginEnable = $workFinishEnable; // 勤務終了と休憩開始は押せるタイミング同じ
        $restEndEnable = $isWorkingTime && $isBreakTime;

        return view(
            'index',
            compact('user', 'workBeginEnable', 'workFinishEnable', 'restBeginEnable', 'restEndEnable')
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
