<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
|admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'Backend'], function () {
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'check'])->group(function () {
        Route::get('/', 'IndexController@index')->name('dashboard');
        Route::resource('posts', 'PostsController');
        Route::resource('categories', 'CategoriesController');
        Route::resource('pages', 'PagesController');
        Route::resource('comments', 'CommentsController');
        Route::resource('messages', 'MessagesController');
        Route::resource('users', 'UsersController');
        Route::resource('roles', 'RolesController');
    });

});
