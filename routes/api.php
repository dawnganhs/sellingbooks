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
Route::post('/register', 'UserController@create');
Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout')->name('logout');

Route::group(['middleware' => 'ProtectedAdminLoginMiddleware'], function(){

    Route::get('/add-to-cart/{id}', 'CartController@addtoCart')->name('addtoCart');
    Route::get('/delete-your-order/{id}', 'OrderController@deleteOrderUser');
    Route::put('/edit-your-profile', 'UserController@update');
    Route::get('/your-profile', 'UserController@show');
    Route::get('/your-orders', 'OrderController@showOrderUser');
    Route::resource('/admin/orders', 'OrderController');
    Route::resource('/admin/authors', 'AuthorController');
    Route::resource('/admin/books', 'BookController');
    Route::resource('/admin/categories', 'CategoryController');
    Route::get('/admin/listwithcategory', 'CategoryController@listwithcategory');

    Route::resource('/admin/storages', 'StorageController');
    Route::resource('/admin/tags', 'TagController');
    Route::resource('/admin/users', 'UserController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/book/highlights', 'PageController@GetHighligtsBook');
Route::get('/book/newbook', 'PageController@GetNewBook');
Route::resource('/pages', 'PageController');
