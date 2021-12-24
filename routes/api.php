<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('signin', 'ApiController@signIn');
Route::middleware('auth:api')->get('/chat/room/logout', 'ApiController@signout');


Route::middleware('auth:api')->post('/chat/room', 'ChatController@newRoom');
Route::middleware('auth:api')->get('/chat/rooms/{lisnerId}', 'ChatController@rooms');
Route::middleware('auth:api')->get('/chat/room/{roomId}/messages', 'ChatController@messages');
Route::middleware('auth:api')->post('/chat/room/{roomId}/message', 'ChatController@newMessage');

//admin

Route::middleware('auth:api')->get('/admin/rooms', 'AdminController@rooms');
Route::middleware('auth:api')->get('/admin/room/{roomId}/messages', 'AdminController@messages');
Route::middleware('auth:api')->post('/admin/room/{roomId}/message', 'AdminController@newMessage');

