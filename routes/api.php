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

//Products APIS
Route::post('/getProducts','App\Http\Controllers\ProductController@getProducts');
Route::post('/addProduct','App\Http\Controllers\ProductController@addProduct');
Route::post('/updateProduct','App\Http\Controllers\ProductController@updateProduct');
Route::post('/deleteProduct','App\Http\Controllers\ProductController@deleteProduct');

//Categories APIS
Route::get('/getAllCategories','App\Http\Controllers\CategoryController@getAll');
Route::get('/getCategories','App\Http\Controllers\CategoryController@getCategories');
Route::post('/addCategory','App\Http\Controllers\CategoryController@addCategory');
Route::post('/updateCategory','App\Http\Controllers\CategoryController@updateCategory');
Route::post('/deleteCategory','App\Http\Controllers\CategoryController@deleteCategory');

//Upload API
Route::post('/uploadImage','App\Http\Controllers\UploadController@uploadImage');