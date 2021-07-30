<?php

use App\Http\Controllers\TimecardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoginMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [TimecardController::class, 'index'])->middleware('unauth');
Route::get('/login', [LoginController::class, 'getAuth'])->middleware('login');
Route::post('/login', [LoginController::class, 'postAuth']);
Route::get('/register', [RegisterController::class, 'getSignup']);
Route::post('/register', [RegisterController::class, 'postSignup']);
Route::post('workstart', [TimecardController::class, 'workStart'])->name('workstart');
Route::post('workfinish', [TimecardController::class, 'workFinish'])->name('workfinish');
Route::get('logout', [TimecardController::class, 'getLogout'])->name('logout');



// Route::post('login', function () {
//     return view('login');
// })->name('login');

// Route::get('dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__ . '/auth.php';