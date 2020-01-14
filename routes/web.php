<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','Index\IndexController@index');
Route::get('/user/reg','User\IndexController@reg');
Route::post('/user/reg','User\IndexController@doReg');      //注册
Route::get('/user/login','User\IndexController@login');      //登录
Route::post('/user/login','User\IndexController@doLogin');      //登录
Route::get('/user/center','User\IndexController@center');      //个人中心

