<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:jwt')->get('/user', function (Request $request) {
    return Auth::user();
});

Route::post('signin', 'ChatController@signIn');
Route::middleware('auth:api')->get('/chat/room/logout', 'ApiController@signout');


Route::middleware('auth:jwt')->post('/chat/room', 'ChatController@newRoom');
Route::middleware('auth:jwt')->get('/chat/rooms/{lisnerId}', 'ChatController@rooms');
Route::middleware('auth:jwt')->get('/chat/room/{roomId}/messages', 'ChatController@messages');
Route::middleware('auth:jwt')->post('/chat/room/{roomId}/message', 'ChatController@newMessage');

//admin

Route::middleware('auth:api')->get('/admin/rooms', 'AdminController@rooms');
Route::middleware('auth:api')->get('/admin/room/{roomId}/messages', 'AdminController@messages');
Route::middleware('auth:api')->post('/admin/room/{roomId}/message', 'AdminController@newMessage');

Route::get("unauthorized",function(){
    return response()->json("Unauthorized!")->name('unauthorized');
});

