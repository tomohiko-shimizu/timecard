<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Timecard extends Model
{
    use HasFactory;
    protected $guarded = array('id');

    public function rests()
    {
        return $this->hasMany('App\Models\Rest');
    }

    public function getWorkStart()
    {
        return $this->work_start;
    }
    public function user() { //追記
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getWorkTime() {
         // Timecardテーブルのwork_startを取得して、Carbonに変換
         $work_start = new Carbon($this->work_start);

         // Timecardテーブルのwork_finishを取得して、Carbonに変換
        $work_finish = new Carbon($this->work_finish);

        // $work_finishと$work_startの時間差を秒単位で計算する。
        $work_time = $work_finish->diffInSeconds($work_start);

        // 勤務時間の○時間の部分を計算する
        $work_time_hour = floor($work_time / 3600);

        // 勤務時間の○分の部分を計算する
        $work_time_minute = floor(($work_time / 60) % 60);

        // 勤務時間の○秒の部分を計算する
        $work_time_second = $work_time % 60;

        return "${work_time_hour}:${work_time_minute}:${work_time_second}";
    }
}
