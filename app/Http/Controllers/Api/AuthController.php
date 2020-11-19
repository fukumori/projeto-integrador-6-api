<?php

namespace App\Http\Controllers\Api;

class AuthController extends \App\Http\Controllers\Controller
{
    public function login(\Illuminate\Http\Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response([
                'message' => 'This User does not exist, check your details'
            ], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response([
            'user' => auth()->user(),
            'access_token' => $accessToken
        ]);
    }
}
