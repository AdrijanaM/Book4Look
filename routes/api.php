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

//register user
Route::post('/user',[
    'uses' => 'UserController@signup'
]);
//login user
Route::post('/user/signin',[
    'uses' => 'UserController@signin'
]);

//quotes
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('/quotes/{userId}', 'QuoteController@getQuotes');
    Route::post('/quote', 'QuoteController@postQuote');
    Route::put('/quote/{id}', 'QuoteController@putQuote');
    Route::delete('/quote/{id}', 'QuoteController@deleteQuote');
});

//challenge
Route::post('/challenge/{userId}',[
    'uses' => 'ChallengeController@postChallenge',
    'middleware' => 'auth.jwt'
]);

//authors
Route::post('/author',[
    'uses' => 'AuthorController@postAuthor'
]);
Route::get('/authors',[
    'uses' => 'AuthorController@getAuthors'
]);
//Route::put('/author/{id}',[
//    'uses' => 'AuthorController@putAuthor'
//]);

//books
Route::post('/book',[
    'uses' => 'BookController@postBook',
    'middleware' => 'auth.jwt'
]);
Route::get('/books/{userId}',[
    'uses' => 'BookController@getBooks',
    'middleware' => 'auth.jwt'
]);

Route::get('/book/{userId}',[
    'uses' => 'BookController@getSearchedBook',
    'middleware' => 'auth.jwt'
]);
//Route::get('/book',[
//    'uses' => 'BookController@getSearchedBook'
//]);
