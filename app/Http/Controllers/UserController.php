<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out.');
    }

    public function login() {
        return view('login');
    }

    public function authenticate(Request $request) {
        $formData = $request->validate([
            'email' => ['required','email'],
            'password' => 'required',
        ]);

        if (auth()->attempt($formData)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You have been logged in.');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->onlyInput('email');
    }
}
