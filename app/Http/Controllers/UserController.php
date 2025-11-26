<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        //create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //output
        return response()->json([
            'user' => $user,
            'message' => 'User registered successfully'
        ], 201);
    }

    public function login(Request $request)
    {
        //validasi
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        //mencari user
        $user = User::where('email', $request->email)->first();

        //pemeriksaan apakah ada user
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        //create Personal Access Token
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        //output
        return response()->json([
            'detail' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        //cek apakah ada usernya
        if (Auth::check()) {
            //hapus token
            $request->user()->currentAccessToken()->delete();
            //output
            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['message' => 'Not logged in'], 401);
    }
}