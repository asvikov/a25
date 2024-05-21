<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request) {

        $user = User::where('email', $request->input('email'))->first();

        if(!$user || !Hash::check($request->input('password'), $user->password)) {
            return response(['message' => 'email or password is incorrect'], 401);
        }

        $token = $user->createToken('bearer_token')->plainTextToken;
        $result = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
        return response($result, 201);
    }

    public function logout(Request $request) {

        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Logged out']);
    }
}
