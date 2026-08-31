<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    /**
     * Login user melalui API
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $user = Auth::user();

        // Hapus token lama agar tidak menumpuk
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('flutter-app')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil.',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * Mendapatkan data user yang sedang login
     */
    public function user(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user(),
        ]);
    }
}