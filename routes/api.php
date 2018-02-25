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

//login user
Route::post('/user',[
    'uses' => 'UserController@signup'
]);

Route::post('/user/signin',[
    'uses' => 'UserController@signin'
]);

Route::get('/username',[
    'uses' => 'UserController@getUserName'
]);

//quotes
//Route::group(['middleware' => 'auth:api'], function () {
//    Route::get('/posts', 'PostsController@index');
//});

Route::post('/quote',[
    'uses' => 'QuoteController@postQuote',
    'middleware' => 'auth.jwt'
]);

Route::get('/quotes/{userId}',[
    'uses' => 'QuoteController@getQuotes',
    'middleware' => 'auth.jwt'
]);

Route::put('/quote/{id}',[
    'uses' => 'QuoteController@putQuote',
    'middleware' => 'auth.jwt'
]);

Route::delete('/quote/{id}',[
    'uses' => 'QuoteController@deleteQuote',
    'middleware' => 'auth.jwt'
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
