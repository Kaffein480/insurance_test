<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function showForm(): View
    {
        return view('register');
    }

    public function processForm(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $emailExist = User::where('email', $request->email)->exists();

        if ($emailExist) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Email sudah digunakan']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('register')
            ->with('success', 'Registration successful, you can now log in');
    }
}
