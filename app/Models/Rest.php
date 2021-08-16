<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rest extends Model
{
    use HasFactory;
    protected $guarded = array('id');

    public function timecards()
    {
        return $this->hasMany('App\Models\Timecard', 'timecard_id');
    }

    public function getRestTime()
    {
        $rest_start = new Carbon($this->rest_start);
        $rest_finish = new Carbon($this->rest_finish);
        $rest_time = $rest_finish->diffInSeconds($rest_start);
        $rest_time_hour = sprintf('%02d', floor($rest_time / 3600));
        $rest_time_minute = sprintf('%02d', floor(($rest_time / 60) % 60));
        $rest_time_second = sprintf('%02d', $rest_time % 60);
        return "${rest_time_hour}:${rest_time_minute}:${rest_time_second}";
    }
}
