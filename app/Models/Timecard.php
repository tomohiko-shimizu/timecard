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

    // public function rests()
    // {
    //     return $this->hasMany('App\Models\Rest');
    // }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function rest()
    {
        return $this->belongsTo('App\Models\Rest', 'id');
    }

    public function getWorkTime()
    {
        $work_start = new Carbon($this->work_start);
        $work_finish = new Carbon($this->work_finish);
        $work_time = $work_finish->diffInSeconds($work_start);
        $work_time_hour = sprintf('%02d', floor($work_time / 3600));
        $work_time_minute = sprintf('%02d', floor(($work_time / 60) % 60));
        $work_time_second = sprintf('%02d', $work_time % 60);
        return "${work_time_hour}:${work_time_minute}:${work_time_second}";
    }
}
