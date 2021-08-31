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
        $timecardID =
            Timecard::where('user_id', $user->id)->where('date', $today)->latest()->first();
        if ($timecardID === null) {
            $timestampForFinishWork = null;
            $timestampForStartRest = null;
            $timestampForFinishRest = null;
        } else {
// 退勤ボタンが押されたか確認
            $timestampForFinishWork = Timecard::where('user_id', $user->id)->where('date', $today)->whereNotNull('work_finish')->latest()->first();
// 休憩ボタンが押されたか確認
            $timestampForStartRest = Rest::where('timecard_id', $timecardID->id)
                ->whereNotNull('rest_start')->latest()->first();
            $timestampForFinishRest = Rest::where('timecard_id', $timecardID->id)
                ->WhereNull('rest_finish')->latest()->first();
        }
// ログイン時のボタン表示
        $startedWork = false;
        $finishedWork = true;
        $startedRest = true;
        $finishedRest = true;
// 出勤ボタン押下後の表示
        if ($timecardID !== null) {
            $startedWork = true;
            $finishedWork = false;
            $startedRest = false;
        }
// 休憩開始・終了ボタン押下時の表示
        if ($timestampForStartRest !== null && $timestampForFinishRest !== null) {
            $finishedWork = true;
            $startedRest = true;
            $finishedRest = false;
        }
// 退勤ボタン押下後の表示
        if ($timestampForFinishWork !== null) {
            $finishedWork = true;
            $startedRest = true;
        }

        return view(
            'index',
            compact('user', 'startedWork', 'finishedWork', 'startedRest', 'finishedRest')
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
