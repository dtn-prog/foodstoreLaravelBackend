<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        $response = ['message'=>'loged out'];

        return response()->json($response);
    }
}
