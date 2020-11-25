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

use Illuminate\Support\Facades\Artisan;

Route::get('/', 'AuthController@index');
Route::get('login', 'AuthController@index')->name('login');
Route::post('post-login', 'AuthController@postLogin');
Route::get('register', 'AuthController@register');
Route::post('post-register', 'AuthController@postRegister');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::get('home', 'HomeController@index')->name('home');

Route::put('tests/store', 'TestController@store')->name('tests-store');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('tests', 'TestController');
    Route::resource('sign_on_test', 'SignOnTestApplyController');
    Route::resource('categories', 'CategoryController');
    Route::resource('test.category', 'TestCategoryController');
    Route::resource('question', 'QuestionController');
    Route::resource('categories.questions', 'QuestionController');
});

Route::get('/foo', function () {
    Artisan::call('storage:link');
});

Route::get('test/{id}/instances', 'TestController@showAllInstances')->name('test.all');
Route::get('tests/{role}/{filter}', 'TestController@index')->name('tests..');
Route::get('tests/{role}/{filter}/{id}/show', 'TestController@show')->name('tests...show');
Route::get('tests/{role}/{filter}/{from}/{id}/edit', 'TestController@edit')->name('tests....edit');
Route::put('tests/{role}/{filter}/{from}/{id}/update', 'TestController@update')->name('tests....update');
Route::get('tests/{role}/{filter}/{from}/{id}/edit/addCategory', 'TestCategoryController@create')->name('tests....edit/addCategory');
Route::post('tests/{role}/{filter}/{from}/{id}/edit/storeCategory', 'TestCategoryController@store')->name('tests....edit/storeCategory');
Route::get('tests/{role}/{filter}/{from}/{id}/edit/editCategory/{categoryId}', 'TestCategoryController@edit')->name('tests....edit/editCategory.');
Route::put('tests/{role}/{filter}/{from}/{id}/edit/updateCategory/{categoryId}', 'TestCategoryController@update')->name('tests....edit/updateCategory.');
Route::delete('tests/{role}/{filter}/{from}/{id}/edit/removeCategory/{categoryId}', 'TestCategoryController@destroy')->name('tests....edit/removeCategory.');

Route::get('categories', 'CategoryController@index')->name('categories');
Route::get('new/{id}/{correction}/sign', 'SignOnTestApplyController@create')->name('new..sign');
Route::get('sign_on/{test_id}/test/{user_id}/{correction}/confirm', 'SignOnTestApplyController@confirm')->name('sign_on.test..confirm');
Route::get('sign_on/{test_id}/test/{user_id}/{correction}/un_confirm', 'SignOnTestApplyController@un_confirm')->name('sign_on.test..un_confirm');
Route::get('sign_on/{test_id}/test/{user_id}/{correction}/destroy', 'SignOnTestApplyController@destroy')->name('sign_on.test..destroy');


Route::get('tests/{from}/{id}/instance/{assistant_id}', 'TestController@showInstances')->name('tests..instance.');

Route::get('tests/{from}/{instance_id}/end', 'TestInstanceCorrectionController@endReview')->name('test-correct..instances-end');

Route::get('tests/{from}/{instance_id}/correction', 'TestInstanceCorrectionController@index')->name('test-correct..');
Route::get('tests/{from}/{instance_id}/{question_id}/correction', 'TestInstanceCorrectionController@question')->name('question-correct...');
Route::post('tests/{from}/{instance_id}/{question_index}/correction', 'TestInstanceCorrectionController@saveCorrection')->name('correction-save...');

Route::get('tests/{from}/{id}/{student_id}/results', 'TestInstanceController@showResults')->name('tests...results');


Route::get('test/{test_id}/preview', 'TestInstanceController@index')->name('test.preview');
Route::get('test/{test_id}/create', 'TestInstanceController@create')->name('test.create');
Route::get('test/{test_id}/end', 'TestInstanceController@endTest')->name('test.end');
Route::get('test/{test_id}/finish', 'TestInstanceController@finish')->name('test.finish');
Route::get('test/fill/{instance_id}/{question_index}', 'TestInstanceController@question')->name('test-fill..');
Route::post('question/save/{instance_id}{question_index}', 'TestInstanceController@saveQuestion')->name('question-save..');

Route::get('category-search','CategoryController@search');
Route::get('test-search','TestController@search');

Route::get('reset-password-form', 'PasswordResetController@index')->name('reset-password-form');
Route::post('reset-password-request', 'PasswordResetController@checkEmailForPassReset')->name('reset-password-request');
Route::get('password/reset/{token}', 'PasswordResetController@resetPasswordForm');
Route::post('reset-password', 'PasswordResetController@resetPassword');

Route::get('user', 'SettingsController@settings')->name('user');
Route::get('user/create', 'UsersListController@create')->name('user.create');
Route::post('user/create/save', 'UsersListController@createUser')->name('user.create.save');
Route::post('save-config', 'SettingsController@saveConfig');

Route::get('user-search','UsersListController@search');
Route::get('user-list', 'UsersListController@showUserList')->name('user-list');
Route::delete('delete-user/{id}', 'UsersListController@deleteUser')->name('user.delete');
Route::get('edit-user/{id}', 'UsersListController@editUser')->name('user.edit');


Route::get('user_edit', function () {
    return view('users.user_edit');
});
Route::post('save-edit', 'UsersListController@saveEdit');

