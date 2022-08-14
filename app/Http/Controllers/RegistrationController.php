<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function signUp(RegistrationRequet $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request['password']),
        ]);
        if($user){
            $response = response()->json(['error' => 'false', 'message' => 'user registered successfully', 'data' => $user]);
        } else{
            $response = response()->json(['error' => 'false', 'message' => 'registration failed']);
        }
        return $response;
    }
}
