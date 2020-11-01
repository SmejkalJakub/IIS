<?php

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

Route::get('/', 'AuthController@index');
Route::get('login', 'AuthController@index');
Route::post('post-login', 'AuthController@postLogin');
Route::get('register', 'AuthController@register');
Route::post('post-register', 'AuthController@postRegister');
Route::get('home', 'AuthController@home')->name('home');
Route::get('logout', 'AuthController@logout');

Route::get('tests', function () {
    return view('tests');
});

Route::get('user', 'SettingsController@settings');
Route::post('save-config', 'SettingsController@saveConfig');

Route::get('user-list', 'UsersListController@showUserList')->name('user.list');
Route::delete('delete-user/{id}', 'UsersListController@deleteUser')->name('user.delete');
Route::post('edit-user/{id}', 'UsersListController@editUser')->name('user.edit');

Route::get('user_edit', function () {
    return view('user_edit');
});
Route::post('save-edit', 'UsersListController@saveEdit');



?>
