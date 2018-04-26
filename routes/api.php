<?php

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
Route::post('/login', 'UserController@login')->name('login');

Route::group(['middleware' => 'ProtectedUserLogin'], function () {
    
    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::get('/your-orders', 'OrderController@showOrderUser');
    Route::get('/delete-your-order/{id}', 'OrderController@deleteOrderUser');
    Route::put('/edit-your-profile', 'UserController@update');
    Route::get('/your-profile', 'UserController@show');
    Route::post('/finish-checkout', 'PageController@checkout');
    Route::get('/delete-all-your-order', 'OrderController@deleteAllOrderUser');
});

Route::group(['middleware' => 'ProtectedAdminLoginMiddleware'], function () {

    Route::get('/admin/total', 'OrderController@Total');
    Route::resource('/admin/orders', 'OrderController');
    Route::resource('/admin/authors', 'AuthorController');
    Route::resource('/admin/books', 'BookController');
    Route::resource('/admin/categories', 'CategoryController');
    Route::get('/admin/categorycountbooks', 'CategoryController@categorywithcountbooks');
    Route::resource('/admin/storages', 'StorageController');
    Route::resource('/admin/tags', 'TagController');
    Route::resource('/admin/users', 'UserController');
});

Route::get('/book/highlights', 'PageController@GetHighligtsBook');
Route::get('/book/newbook', 'PageController@GetNewBook');
Route::resource('/pages', 'PageController');
