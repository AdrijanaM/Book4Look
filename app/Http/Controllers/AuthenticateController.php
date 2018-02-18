<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class AuthenticateController extends Controller
{


//    public function postUser(Request $request)
//    {
//        $user = new User();
//        $user->username = $request->input('username');
//        $user->email = $request->input('email');
//        $user->password = $request->input('password');
//        echo $user;
////        $user->save();
//        return response()->json(['user' => $user], 201); //ok
//
//    }

    public function angularLogin(Request $request) {
//        $user = new User();
//        $user->email = $request->input('email');
//        $user->password = $request->input('password');
//
//        if (Auth::attempt(array('email' => $user->email, 'password' => $user->password))) {
//            return response()->json(Auth::user());
//            // return Redirect::to('/admin');
//        } else {
//            return response()->json(array('flash' => 'Invalid username or password'), 500);
//        }

        $user = new User();
        $user->email = $request->input('email');
        $user->password = $request->input('password');


//
//        if (!Auth::check()) {
////        $user = App\User::login($user);
//            Auth::login($user);
//        }

        $currentUser = User::create($user);
        Auth::user();
//        return Auth::user();
        return response()->json(Auth::user());
    }


}
