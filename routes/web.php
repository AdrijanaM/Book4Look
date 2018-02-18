<?php

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
//Route::auth();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});

//Route::get('/login', function (Request $request) {
//
//    echo $request;
//    $user = new User();
//    $user->email = $request->input('email');
//    $user->password = $request->input('password');
//
//    if (Auth::attempt(array('email' => $user->email, 'password' => $user->password))) {
//        return response()->json(Auth::user());
//        // return Redirect::to('/admin');
//    } else {
//        return response()->json(array('flash' => 'Invalid username or password'), 500);
//    }
//});

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/auth', function (Request $request) {
//    if (!Auth::check()) {
//        $user = App\User::login(2);
//        Auth::login($user);
//    }
//    return Auth::user();


//    $user = new User();
//    $user->email = $request->input('email');
//    $user->password = $request->input('password');
//
//    if (Auth::attempt(array('email' => $user->email, 'password' => $user->password))) {
//        Auth::login($user);
//        return response()->json(Auth::user());
//        // return Redirect::to('/admin');
//    } else {
//        return response()->json(array('flash' => 'Invalid username or password'), 500);
//    }

    $user = new User();
    $user->email = $request->input('email');
    $user->password = $request->input('password');

        if (!Auth::check()) {
        $userLoged = App\User::login($user);
        Auth::login($userLoged);
    }
    return Auth::user();

});

//Route::group(
//    ['before' => 'auth.basicCustom'], function () {
//    // User authenticate with sesssion
//    Route::post('authenticate', function () {
//        echo 'ok';
//    });
//}
//);

