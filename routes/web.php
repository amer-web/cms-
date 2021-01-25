<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes(['verify' => true]);
Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', 'IndexController@index')->name('frontend.index');
    Route::get('post/{sulg}', 'IndexController@show')->name('post.show');
    Route::post('post/{post}', 'IndexController@store')->name('post.store');

    Route::get('archive/{date}/{year}', 'IndexController@archive_show')->name('post.archive_show');

    Route::get('page/{sulg}', 'IndexController@page_show')->name('page.show');

    Route::get('category/{sulg}', 'IndexController@category_show')->name('category.show');

    Route::get('contact-us', 'ContactController@show_contact');

    Route::post('contact-us', 'ContactController@store_contact')->name('contact.store');
    Route::get('/404', function () {
        return view('errors.404handel');
    });

});
Route::group(['middleware' => ['auth','verified'], 'namespace' => 'Frontend'], function () {
    Route::resource('dashboard', 'DashboardUserController');
    Route::post('dashboard/store', 'DashboardUserController@store')->name('dashboard.store');
    Route::post('dashboard/delete/{id_dele}', 'DashboardUserController@destory_image')->name('dashboardimage.delete');
    Route::resource('comments', 'CommentController');
    Route::get('/user/notifications/get', 'NotificationsUserController@getNotifications')->name('getnotifications');
    Route::any('notifications/markAsRead', 'NotificationsUserController@markAsRead')->name('markAsRead');
    Route::get('/getpost/{sulg}', 'NotificationsUserController@redirectcomment');
    Route::get('change-password','ChangePasswordController@index')->name('changePassword');
    Route::post('change-password','ChangePasswordController@update')->name('updatePassword');
});

Route::get('admins-dash', 'Api\General\AdminsController@admins');
//Route::get('/home-amer', function (){
//    return view('home');
//});



