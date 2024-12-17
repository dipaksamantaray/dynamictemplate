<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    // Get the authenticated user's profile
    public function profile()
    {
        return response()->json(Auth::user());
    }

    // Admin index (protected route)
    public function adminIndex()
    {
        return response()->json(['message' => 'Welcome to the Admin area']);
    }

    // Create a new admin (example)
    public function adminCreate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['user' => $user], 201);
    }
}
