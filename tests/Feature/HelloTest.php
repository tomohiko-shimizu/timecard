<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Timecard;
use Carbon\Carbon;

class HelloTest extends TestCase
{
    use RefreshDatabase;
    
    public function testGetWorkTime()
    {
        User::factory()->create([
            'id' => 1,
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => Hash::make('test')
        ]);
        // テスト用のTimecardを作る
        Timecard::factory()->create([
            'id' => 1,
            'date' => Carbon::today(),
            'work_start' =>  Carbon::parse('2021-04-30 10:00:00'),
            'work_finish' =>  Carbon::parse('2021-04-30 12:01:01')
        ]);
        
        // テスト用のTimecardを取得
        $timecard = Timecard::where('id', 1)->first();
        // 
        $this->assertEquals('02:01:01', $timecard->getWorkTime());
    }
}
