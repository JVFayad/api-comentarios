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

Route::get('/', function () {
    return response()->json(['message' => 'API Comentários', 'status' => 'Connected']);;
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# Rotas Comentários
Route::get('comments', 'CommentsController@index');
Route::get('comments/post/{post}', 'CommentsController@index_post');
Route::get('comments/user/{user}', 'CommentsController@index_user');
//Route::get('comments/{comment}', 'CommentsController@show');
Route::post('comments', 'CommentsController@store');
//Route::put('comments/{comment}', 'CommentsController@update');
Route::delete('comments/{comment}', 'CommentsController@delete');