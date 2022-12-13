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

// Public routes

// List articles
Route::get('articles', 'App\Http\Controllers\ArticleController@index');

// List single article
Route::get('articles/{id}', 'App\Http\Controllers\ArticleController@show');

// Create new article
Route::post('articles', 'App\Http\Controllers\ArticleController@store');

// update an article
Route::put('articles/{id}', 'App\Http\Controllers\ArticleController@update');

// delete an article
Route::delete('articles/{id}', 'App\Http\Controllers\ArticleController@destroy');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
