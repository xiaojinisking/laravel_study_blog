<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/blog','BlogController@index');
Route::get('/blog/{slug}','BlogController@showPost');


//后台
Route::get('/admin',function(){
    return redirect('/admin/post');
});

Route::group(['namespace'=>'Admin','middleware'=>'auth'],function(){
    Route::resource('admin/post','PostController');
    Route::resource('admin/tag','TagController',['except'=>'show']);
    Route::get('admin/upload','UploadController@index');
    //上传
    Route::get('admin/upload','UploadController@index');

    Route::post('admin/upload/file','UploadController@uploadFile');
    Route::delete('admin/upload/file','UploadController@deleteFile');
    Route::post('admin/upload/folder','UploadController@createFolder');
    Route::delete('admin/upload/folder','UploadController@deleteFolder');
});



Auth::routes();

Route::get('/home', 'HomeController@index');

