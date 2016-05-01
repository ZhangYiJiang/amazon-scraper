<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api', 'middleware' => ['api']], function(){
    Route::resource('authors', 'AuthorController', ['only' => ['index', 'show']]);
    Route::resource('keywords', 'KeywordController', ['only' => ['index', 'show']]);
    Route::resource('books', 'BookController', ['only' => ['index', 'show']]);
});


Route::get('topic/{keyword}', 'PageController@keyword');
Route::get('/', 'PageController@index');

