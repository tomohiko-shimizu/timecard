<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class HelloTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testHello()
    // {
    //     $this->assertTrue(true);

    //     $arr = [];
    //     $this->assertEmpty($arr);

    //     $txt = "hello world";
    //     $this->assertEquals('hello world', $txt);

    //     $n = random_int(0, 100);
    //     $this->assertLessThan(100, $n);
    // $response = $this->get('/');

    // $response->assertStatus(200);

    // public function testHello()
    // {
    //     $this->assertTrue(true);

    //     $response = $this->get('/');
    //     $response->assertStatus(200);

    //     $response = $this->get('/no_route');
    //     $response->assertStatus(404);
    // }

    public function testHello()
    {
        User::factory()->create([
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345',
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345'
        ]);
    }
}
