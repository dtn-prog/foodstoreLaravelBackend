<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $fields = $request->validate([
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^\d{1,15}$/',
            ],
            'password' => ['required', 'string'],
        ]);

        if (auth()->attempt($fields)) {
            $user = auth()->user();
            $token = $user->createToken('foodstore')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);

    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        $response = ['message'=>'loged out'];

        return response()->json($response);
    }
}
