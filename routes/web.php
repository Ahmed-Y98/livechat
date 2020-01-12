<?php

use App\Events\newUserRegisterd;


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

Route::view('/login', 'ChatHome')->name('login')->middleware('guest');

Route::get('/' , 'AppAuth@ViewHome')->name('home');

Route::get('/register' , 'index@register')->name('register');

Route::post('/register' , 'index@addUser');

Route::post('/login' , 'index@login');

Route::get('/logout' , 'AppAuth@logOut');

Route::post('/chat' , 'AppAuth@chat');

Route::post('/message' , 'AppAuth@sendMessage');

Route::post('/api/activeusers' , 'AppAuth@getActiveUsers')->name('activeUsers');


Route::get('/event', function () {
    event(new newUserRegisterd('ahmed'));
    return 'ok';
});