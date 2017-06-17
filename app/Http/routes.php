<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Product;
use App\Models\Order as Order;


Route::get('/', 'HomeController@index');


Route::get('home', 'HomeController@postData');
Route::post('addData', [
    'uses'=>'HomeController@postData',
    'as'=>'addData'
]);
Route::get('home', 'HomeController@index');


Route::get('home', 'HomeController@deleteOrder');
Route::post('deleteData', [
    'uses'=>'HomeController@deleteOrder',
    'as'=>'deleteData'
]);
Route::get('home', 'HomeController@index');
Route::post('home','HomeController@index');

Route::get('home', 'HomeController@updateOrder');
Route::post('updateData', [
    'uses'=>'HomeController@updateOrder',
    'as'=>'updateData'
]);
Route::get('home', 'HomeController@index');


