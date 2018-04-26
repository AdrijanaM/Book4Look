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

Route::get('getUser',[
    'uses' => 'UserController@currentUser',
    'middleware' => 'auth.jwt'
]);

Route::get('userInfo/{id}',[
    'uses' => 'UserController@userInfo',
    'middleware' => 'auth.jwt'
]);

//quotes
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('/quotes/{userId}', 'QuoteController@getQuotes');
    Route::post('/quote', 'QuoteController@postQuote');
    Route::put('/quote/{id}', 'QuoteController@putQuote');
    Route::delete('/quote/{id}', 'QuoteController@deleteQuote');
});

//challenges
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('/challenges/{userId}', 'ChallengeController@getChallenges');
    Route::post('/challenge', 'ChallengeController@postChallenge');
    Route::delete('/challenge/{id}', 'ChallengeController@deleteChallenge');
});

//authors
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('/authors/{userId}', 'AuthorController@getAuthors');
    Route::get('/author/{fullName}', 'AuthorController@getSearchedAuthor');
    Route::post('/author', 'AuthorController@postAuthor');
});

//books
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('/books/{userId}', 'BookController@getBooks');
    Route::get('/favBooks/{userId}', 'BookController@getFavBooks');
    Route::put('/booksFav/{id}', 'BookController@updateBook');
    Route::get('/book/{title}', 'BookController@getSearchedBook');
    Route::post('/book', 'BookController@postBook');
});