<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function getRestTime()
    {
        $rests = $this->rests;
        $sum_rest_time = 0;
        foreach ($rests as $rest) {
            $rest_start = new Carbon($rest->rest_start);
            $rest_finish = new Carbon($rest->rest_finish);
            $rest_time = $rest_finish->diffInSeconds($rest_start);
            $sum_rest_time = $sum_rest_time + $rest_time;
        }
        $rest_time_hour = sprintf('%02d', floor($sum_rest_time / 3600));
        $rest_time_minute = sprintf('%02d', floor(($sum_rest_time / 60) % 60));
        $rest_time_second = sprintf('%02d', $sum_rest_time % 60);
        return "${rest_time_hour}:${rest_time_minute}:${rest_time_second}";
    }

    public function getWorkTime()
    {
        $work_start = new Carbon($this->work_start);
        $work_finish = new Carbon($this->work_finish);
        $work_time = $work_finish->diffInSeconds($work_start);

        $rests = $this->rests;
        $sum_rest_time = 0;
        foreach ($rests as $rest) {
            $rest_start = new Carbon($rest->rest_start);
            $rest_finish = new Carbon($rest->rest_finish);
            $rest_time = $rest_finish->diffInSeconds($rest_start);
            $sum_rest_time = $sum_rest_time + $rest_time;
        }
        $sum_work_time = $work_time - $sum_rest_time;
        $work_time_hour = sprintf('%02d', floor($sum_work_time / 3600));
        $work_time_minute = sprintf('%02d', floor(($sum_work_time / 60) % 60));
        $work_time_second = sprintf('%02d', $sum_work_time % 60);
        return "${work_time_hour}:${work_time_minute}:${work_time_second}";
    }
}
