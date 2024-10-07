<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => $request->role ?? 'customer',
            'password' => Hash::make($request->password),
        ]);

        // Log in the user
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful! You are now logged in.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'unique:users,phone',
                'max:15',
                'regex:/^\d{1,15}$/',
            ],
            'password' => ['required', 'string', 'confirmed'],
        ]);
    }
}
