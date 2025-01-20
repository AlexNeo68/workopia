<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{

    // @desc    Show register form
    // @route   GET /register
    public function form(): View
    {
        return view('auth.register');
    }

    // @desc    Store user in database
    // @route   POST /register
    public function store(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'city' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        try {
            User::create($validatedData);
        } catch (\Throwable $th) {
            dd($th);
        }


        return redirect()->route('login')->with('success', 'User created successfully and you can login in system!');
    }
}
