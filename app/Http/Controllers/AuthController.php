<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            return redirect()->intended('/dashboard')
                ->with('status', 'Login successful');
        }

        return back()->withInput()
            ->with('status', 'Invalid credentials');
    }

    public function logout(): RedirectResponse
    {
        Session::flush();

        Auth::logout();

        return redirect('/')->with('status', 'Logout successful');
    }
}
