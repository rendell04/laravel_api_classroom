<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//view all users
//dapat e auth pa sya bago ma respondang

// Route::get('/users', 'UserController@users');
// Route::post('/create', 'UserController@create');
// Route::get('/user/{id}', 'UserController@user'); //view
// Route::post('/user/{id}', 'UserController@update');	//update
// Route::delete('user/{id}', 'UserController@destroy');

//With Sanctum
Route::middleware('auth:sanctum')->get('/users', 'UserController@users');
//view specific users
Route::middleware('auth:sanctum')->get('/user/{id}', 'UserController@user');
//create user
Route::middleware('auth:sanctum')->post('/create', 'UserController@create');
//update user
Route::middleware('auth:sanctum')->post('/user/{id}', 'UserController@update');
// Delete article
Route::middleware('auth:sanctum')->delete('user/{id}', 'UserController@destroy');

//login
Route::post('/login', 'UserController@index');
Route::get('/logout/{id}', 'UserController@logout');
//create new user
// Route::post('/register', 'UserController@create');
//logout
// Route::middleware('auth:sanctum')->get('/logout/{id}', 'UserController@logout');


//sample with admin middleware
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
	Route::get('/admin', 'UserController@admin');
});
