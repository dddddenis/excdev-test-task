<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            // Аутентификация прошла успешно
            return redirect()->intended('dashboard');
        } else {
            // Аутентификация не удалась
            return back()->withErrors([
                'email' => 'Указанные учетные данные неверны.',
            ]);
        }
    }
}
