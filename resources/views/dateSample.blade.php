<html>
@php
use Carbon\Carbon;
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
@endphp
あなたの勤務時間(休憩考慮しない)は{{$work_time_hour}}:{{$work_time_minute}}:{{$work_time_second}}です
</html>