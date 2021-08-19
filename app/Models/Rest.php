<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rest extends Model
{
    use HasFactory;
    protected $guarded = array('id');

    public function timecard()
    {
        return $this->belongsTo('App\Models\Timecard', 'timecard_id');
    }
}
