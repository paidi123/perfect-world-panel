<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => auth()->user(),
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign default player role
        $user->assignRole('player');

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logout successful']);
    }

    public function refresh()
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json(['token' => $token]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}
