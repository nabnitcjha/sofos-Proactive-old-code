<?php

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

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/chat', function () {
//     return view('welcome');
// });

// Route::get('Chats', 'App\Http\Controllers\ChatsController@index');
// Route::get('messages', 'App\Http\Controllers\ChatsController@fetchMessages');
// Route::post('messages', 'App\Http\Controllers\ChatsController@sendMessage'); 
// Route::post('getPrivateMessage', 'App\Http\Controllers\ChatsController@getPrivateMessage');
// Route::post('getRealTimePrivateMessage', 'App\Http\Controllers\ChatsController@getRealTimePrivateMessage');

