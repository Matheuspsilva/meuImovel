<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LoginJwtController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->all([
            'email',
            'password'
        ]);

        Validator::make( $credentials, [
            'email' =>'required|string',
            'password' => 'required|string'
        ])->validate();

        if(!$token = Auth::attempt($credentials)){
            $message = new ApiMessages('Unauthorized');
            return response()->json($message->getMessage(),401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout()
    {

        Auth::logout();

        return response()->json(['message' => 'logout successfully !'], 200);

    }

    public function refresh()
    {

        $token = Auth::refresh();

        return response()->json([
            'token' => $token
        ]);
    }

}
