<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::post('/user',[
    'uses' => 'UserController@signup'
]);

//quotes
Route::post('/quote',[
    'uses' => 'QuoteController@postQuote'
]);

Route::get('/quotes',[
    'uses' => 'QuoteController@getQuotes'
]);

Route::put('/quote/{id}',[
    'uses' => 'QuoteController@putQuote'
]);

Route::delete('/quote/{id}',[
    'uses' => 'QuoteController@deleteQuote'
]);

//authors
Route::post('/author',[
    'uses' => 'AuthorController@postAuthor'
]);

Route::get('/authors',[
    'uses' => 'AuthorController@getAuthors'
]);

//books
Route::post('/book',[
    'uses' => 'BookController@postBook'
]);

Route::get('/books',[
    'uses' => 'BookController@getBooks'
]);

//Route::put('/author/{id}',[
//    'uses' => 'AuthorController@putAuthor'
//]);


//Route::group(['middleware' => 'auth:api'], function () {
//    Route::get('/posts', 'PostsController@index');
//});

//Route::filter(
//    'auth.basicCustom', function (Request $request) {
//    $credentials = [ 'email' => $request->getUser(), 'password' => $request->getPassword() ];
//
//    if (!Auth::check()) {
//        if (!Auth::once($credentials)) {
//            throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('x-Basic');
//        }
//    }
//}
//);