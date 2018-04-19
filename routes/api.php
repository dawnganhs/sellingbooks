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
Route::resource('/admin/authors', 'AuthorController');

Route::resource('/admin/books', 'BookController');

Route::resource('/admin/categories', 'CategoryController');
Route::get('/admin/listwithcategory', 'CategoryController@listwithcategory');

Route::resource('/admin/storages', 'StorageController');

Route::resource('/admin/tags', 'TagController');

Route::resource('/admin/users', 'UserController');

Route::put('/admin/changeorderstatus/{id}', 'OrderController@ChangeStatusOrder');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/book/highlights', 'PageController@GetHighligtsBook');
Route::get('/book/newbook', 'PageController@GetNewBook');
Route::get('/search', 'PageController@FindEveryThing');
