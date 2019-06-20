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
// Listar todos os comentários
Route::get('comments', 'CommentsController@index')->middleware('auth.basic');
// Listar comentários por postagem
Route::get('comments/post/{post}', 'CommentsController@index_post')->middleware('auth.basic'); 
// Listar comentários por usúario
Route::get('comments/user/{user}', 'CommentsController@index_user')->middleware('auth.basic'); 
// Criar comentário
Route::post('comments', 'CommentsController@store')->middleware('auth.basic'); 
// Deletar comentário
Route::delete('comments/{comment}', 'CommentsController@destroy')->middleware('auth.basic'); 

# Rota Notificacao
// Listar notificacoes por usúario
Route::get('notifications/user/{user}', 'NotificationsController@index_user')->middleware('auth.basic'); 