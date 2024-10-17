<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'unique:users,phone',
                'max:15',
                'min:9',
                'regex:/^\d{1,15}$/',
            ],
            'password' => ['required', 'string', 'confirmed', 'min:6', 'max:255'],
        ]);

        $fields['password'] = bcrypt($fields['password']);
        $fields['role'] = 'customer';

        $user = User::create($fields);

        $token = $user->createToken('foodstore')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        return response()->json($response);
    }
}
