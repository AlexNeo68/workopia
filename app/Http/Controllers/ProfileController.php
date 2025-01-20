<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|min:3',
            'city' => 'required|min:3',
            'email' => 'required|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->city = $request->input('city');

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('dashboard.index')->with('success', 'Profile updated!');
    }
}
