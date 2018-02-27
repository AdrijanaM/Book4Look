<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        //register
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user'
        ], 201);
    }

    public function signin(Request $request)
    {
        //login
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $emailOfUser = $request->input('email');
        $user = User::where('email', 'LIKE', $emailOfUser)->first();
        $this->UserID = User::where('id', 'LIKE', $user->id)->first();
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
//                token package failed
                'error' => 'Could not create token.'
            ], 500);
        }
        return response()->json([
            'token' => $token
        ], 200);
    }


}