<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
/* Route Charts */
Route::get('chart/comment', 'Backend\Api\ChartController@chartcomment');
Route::get('chart/user', 'Backend\Api\ChartController@chartuser');
/* end Route Charts */
/* admins for dashboard */
//Route::get('admins-dash', 'Api\General\AdminsController@admins');
/* end admins for dashboard */

/* Route Auth */
Route::post('login', 'Api\Auth\AuthController@login');
Route::post('register', 'Auth\RegisterController@register');
Route::middleware('auth:api')->group(function (){
Route::post('logout', 'Api\Auth\AuthController@logout');
Route::post('refresh', 'Api\Auth\AuthController@refresh');
});
/* end route Auth */

/*General Routs */
Route::get('all-posts', 'Api\General\PostController@get_posts');
Route::get('/show-post/{slug}', 'Api\General\PostController@show_post')->name('show-post.api');
Route::get('category/{sulg}', 'Api\General\PostController@showPostByCategory');
Route::get('archives', 'Api\General\PostController@archives');
Route::get('archive/{date}/{year}', 'Api\General\PostController@archive_show')->name('archives.api');
Route::post('create-comment/{idPost}', 'Api\General\PostController@createComment');
/* end General Routs */

Route::middleware('auth:api')->group(function(){
Route::get('notifications', 'Api\User\NotificationController@getNotifications');
Route::get('markNotifications', 'Api\User\NotificationController@markAsRead');
Route::resource('my-posts', 'Api\User\UserPotsController');
Route::resource('my-comments', 'Api\User\UserCommentsController');
});
