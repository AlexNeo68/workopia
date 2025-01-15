<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{

    // @desc    Show login form
    // @route   GET /login
    public function form(): View
    {
        return view('auth.login');
    }


    // @desc   Authenticate user
    // @route   POST /login
    public function authenticate(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string|',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'You logged in!');
        }


        return back()->withErrors(['email' => 'Credentials not correct!'])->onlyInput('email');
    }

    // @desc    Logout user
    // @route   POST /logout
    public function logout(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->intended(route('home'))->with('success', 'You are logout!');
    }
}
