<?php

use Illuminate\Http\Request;

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

Route::post('/login', 'UserController@login')->name('login');

Route::Group([
    'prefix' => 'user',
    'as' => 'user.'
], function () {
    
    Route::Group(['middleware' => 'auth:api'], function() {
        Route::post('', 'UserController@index')->name('get');
    });
});

Route::Group([
    'prefix' => 'devices',
    'as' => 'devices.'
], function () {
    
    Route::Group(['middleware' => 'auth:api'], function() {
        Route::get('', 'DeviceController@index')->name('get');
        Route::post('', 'DeviceController@store')->name('store');
        Route::get('{id}', 'DeviceController@find')->name('find');
        Route::put('{id}', 'DeviceController@update')->name('update');
        Route::delete('{id}', 'DeviceController@destroy')->name('destroy');
        Route::get('{id}/data', 'DeviceController@getData')->name('get-data');
    });
});

Route::Group([
    'prefix' => 'transactions',
    'as' => 'transactions.'
], function () {
    
    Route::Group(['middleware' => 'auth:api'], function() {
        Route::get('', 'TransactionController@index')->name('get');
    });
});

Route::Group([
    'prefix' => 'data-collections',
    'as' => 'data-collections.'
], function () {
    
    Route::Group(['middleware' => 'auth:api'], function() {
        Route::get('', 'DataCollectionController@index')->name('get');
        Route::get('get-by-waspmote-id/{id}', 'DataCollectionController@getByWaspmoteId')->name('get-by-waspmote-id');
    });
});

Route::Group([
    'prefix' => 'settings',
    'as' => 'settings.'
], function () {
    
    Route::Group(['middleware' => 'auth:api'], function() {
        Route::get('', 'SettingController@index')->name('get');
        Route::put('', 'SettingController@update')->name('update');
    });
});
