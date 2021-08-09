<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
