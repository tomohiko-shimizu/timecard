<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getAuth(Request $request)
    {
        $text = ['text' => 'ログインしてください'];
        return view('login', $text);
    }

    public function postAuth(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt([
            'email' => $email,
            'password' => $password
        ])) {
            $user = Auth::user()->name;
            // $text = Auth::user()->name . 'さんがログインしました';
            return redirect('/');
        }
        // else {
        //     $text = 'ログインに失敗しました。';
        // }
        // return view('login', ['text' => $text]);
    }

}
