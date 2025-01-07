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
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.string' => 'Số điện thoại phải là một chuỗi.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'phone.min' => 'Số điện thoại phải có ít nhất 9 ký tự.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là một chuỗi.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 255 ký tự.',
        ]);

        $fields['password'] = bcrypt($fields['password']);
        $fields['blacklisted'] = false;

        $user = User::create($fields);

        $token = $user->createToken('foodstore')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response);
    }
}
