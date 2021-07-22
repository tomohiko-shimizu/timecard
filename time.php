<?php
require 'vendor/autoload.php';

use Carbon\Carbon;

// $dt = Carbon::now();
$carbon = new Carbon('12:30:30');
echo ($carbon->addHours(5));
