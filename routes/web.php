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
Route::get('logout', 'AuthController@logout')->name('logout');
Route::get('home', 'AuthController@home')->name('home');

Route::get('tests', function () {
    return view('tests.index');
});

Route::get('user', 'SettingsController@settings')->name('user');
Route::post('save-config', 'SettingsController@saveConfig');

Route::get('search','UsersListController@search');
Route::get('user-list', 'UsersListController@showUserList')->name('user-list');
Route::delete('delete-user/{id}', 'UsersListController@deleteUser')->name('user.delete');
Route::get('edit-user/{id}', 'UsersListController@editUser')->name('user.edit');

Route::get('categories', 'CategoriesController@showCategories')->name('categories');

Route::get('user_edit', function () {
    return view('users.user_edit');
});
Route::post('save-edit', 'UsersListController@saveEdit');



?>
