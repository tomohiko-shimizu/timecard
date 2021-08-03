<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;
    protected $guarded = array('id');

        // public function rests()
        // {
        //     return $this->belongsTo('App\Models\Timecard', 'id');
        // }
}
