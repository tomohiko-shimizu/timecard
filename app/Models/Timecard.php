<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Timecard extends Model
{
    use HasFactory;
    protected $guarded = array('id');

    protected $dates = ['date', 'work_start', 'work_finish'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function rests()
    {
        return $this->hasMany('App\Models\Rest');
    }

    // public static function getWorkRecord()
    // {
    //     $user = Auth::user();
    //     $today = Carbon::today();
    //     return Timecard::where('user_id', $user->id)->where('date', $today);
    // }
    private function diffTime($start, $finish)
    {
        $c_start = new Carbon($start);
        $c_finish = new Carbon($finish);
        $time = $c_finish->diffInSeconds($c_start);
        return $time;
    }
    private function getSumRestTime()
    {
        $rests = $this->rests;
        $sum_rest_time = 0;
        foreach ($rests as $rest) {   
            $rest_time = $this->diffTime($rest->rest_start, $rest->rest_finish);
            $sum_rest_time = $sum_rest_time + $rest_time;
        }
        return $sum_rest_time;
    }

    public function getRestTime()
    {
        $sum_rest_time = $this->getSumRestTime();
        $this->formatTime($sum_rest_time);
        return $this->formatTime($sum_rest_time);
    }

    private function formatTime($time)
    {
        $time_hour = sprintf('%02d', floor($time / 3600));
        $time_minute = sprintf('%02d', floor(($time / 60) % 60));
        $time_second = sprintf('%02d', $time % 60);
        return "${time_hour}:${time_minute}:${time_second}";
    }

    public function getWorkTime()
    {
        $work_time = $this->diffTime($this->work_start, $this->work_finish);
        $sum_rest_time = $this->getSumRestTime();
        $sum_work_time = $work_time - $sum_rest_time;
        return $this->formatTime($sum_work_time);
    }
}
