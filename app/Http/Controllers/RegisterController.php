<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisterController extends Controller
{
    public function getSignup(Request $request)
    {
        $text = ['text' => '会員登録'];
        return view('register', $text);
    }
    public function postSignup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect()->action([TimecardController::class, 'index']);
    }
}
