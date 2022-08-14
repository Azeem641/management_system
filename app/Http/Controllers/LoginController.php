<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['email'=>'required', 'password'=>'required']);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $data = Auth::user();
            $token = $data->createToken("user")->accessToken;

            return response()->json(['token' => $token]);
        }
        else{
            return response()->json(['error' => 'true', 'message' => 'invalid credentials']);
        }
    }

    public function logout(Request $request){
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);
        $accessToken->revoke();
        return response()->json(['error' => 'false', 'message' => 'logout successful']);
    }
}
