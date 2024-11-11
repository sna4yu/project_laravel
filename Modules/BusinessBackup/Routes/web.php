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

Route::group(['middleware' => ['web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu'], 'prefix' => 'businessbackup', 'namespace' => '\Modules\BusinessBackup\Http\Controllers'], function () {
	Route::resource('backup', 'BusinessBackupController')->except(['edit']);
	Route::get('delete/{file_name}', 'BusinessBackupController@delete')->name('businessbackup.delete');
	Route::get('download/{filename}/', 'BusinessBackupController@download')->name('businessbackup.download');
	Route::post('/install/install', 'InstallController@install');
	Route::get('/install', 'InstallController@index');
    Route::get('/install/update', 'InstallController@update');
    Route::get('/install/uninstall', 'InstallController@uninstall');
});