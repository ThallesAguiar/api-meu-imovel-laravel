<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SessionController extends Controller
{
    public function login(Request $req)
    {

        $credentials = $req->all(['email', 'password']);

        Validator::make($credentials,[
            'email'=>'require|string',
            'password'=>'require|string'
        ]);

        if (!$token = auth('api')->attempt($credentials)) {
            $message = new ApiMessages("Credentials invalid");

            return response()->json($message->getMessage(), 401, ['Accept' => 'application/json']);
        }

        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['success' => 'Logout successfully.']);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json(['token' => $token]);
    }
}
