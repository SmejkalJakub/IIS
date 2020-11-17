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
Route::get('login', 'AuthController@index')->name('login');
Route::post('post-login', 'AuthController@postLogin');
Route::get('register', 'AuthController@register');
Route::post('post-register', 'AuthController@postRegister');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::get('home', 'AuthController@home')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('tests', 'TestController');
    Route::resource('sign_on_test', 'SignOnTestApplyController');
    Route::resource('categories', 'CategoryController');
    Route::resource('test.category', 'TestCategoryController');
    Route::resource('question', 'QuestionController');
    Route::resource('categories.questions', 'QuestionController');
});
Route::get('tests', 'TestController@index')->name('tests');
Route::get('categories', 'CategoryController@index')->name('categories');
Route::get('new/{id}/{correction}/sign', 'SignOnTestApplyController@create')->name('new..sign');
Route::get('sign_on/{test_id}/test/{user_id}/{correction}/confirm', 'SignOnTestApplyController@confirm')->name('sign_on.test..confirm');
Route::get('sign_on/{test_id}/test/{user_id}/{correction}/un_confirm', 'SignOnTestApplyController@un_confirm')->name('sign_on.test..un_confirm');
Route::get('sign_on/{test_id}/test/{user_id}/{correction}/destroy', 'SignOnTestApplyController@destroy')->name('sign_on.test..destroy');

Route::get('category-search','CategoryController@search');
Route::get('test-search','TestController@search');

Route::get('reset-password-form', 'PasswordResetController@index')->name('reset-password-form');
Route::post('reset-password-request', 'PasswordResetController@checkEmailForPassReset')->name('reset-password-request');
Route::get('password/reset/{token}', 'PasswordResetController@resetPasswordForm');
Route::post('reset-password', 'PasswordResetController@resetPassword');

/*Route::get('tests.index', 'TestController@index')->name('tests.index');
Route::get('tests.create', 'TestController@create')->name('tests.create');
Route::get('tests.edit/{id}', 'TestController@edit')->name('tests.edit/{id}');
Route::delete('tests.destroy/{id}', 'TestController@destroy')->name('tests.destroy');
Route::put('tests.store', 'TestController@store')->name('tests.store');
Route::put('tests.update', 'TestController@update')->name('tests.update');*/

Route::get('user', 'SettingsController@settings')->name('user');
Route::post('save-config', 'SettingsController@saveConfig');

Route::get('user-search','UsersListController@search');
Route::get('user-list', 'UsersListController@showUserList')->name('user-list');
Route::delete('delete-user/{id}', 'UsersListController@deleteUser')->name('user.delete');
Route::get('edit-user/{id}', 'UsersListController@editUser')->name('user.edit');


Route::get('user_edit', function () {
    return view('users.user_edit');
});
Route::post('save-edit', 'UsersListController@saveEdit');

