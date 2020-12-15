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
        Route::get('/display', 'DeviceController@getDisplayedDevices')->name('display');
        Route::get('', 'DeviceController@index')->name('get');
        Route::post('', 'DeviceController@store')->name('store');
        Route::get('{id}', 'DeviceController@find')->name('find');
        Route::post('{id}', 'DeviceController@update')->name('update');
        Route::delete('{id}', 'DeviceController@destroy')->name('destroy');
        Route::get('{id}/data', 'DeviceController@getData')->name('get-data');
    });
});

Route::Group([
    'prefix' => 'sensors',
    'as' => 'sensors.'
], function () {
    
    Route::Group(['middleware' => 'auth:api'], function() {
        Route::get('', 'SensorController@index')->name('get');
        Route::post('', 'SensorController@store')->name('store');
        Route::get('{id}', 'SensorController@find')->name('find');
        Route::put('{id}', 'SensorController@update')->name('update');
        Route::delete('{id}', 'SensorController@destroy')->name('destroy');
    });
});

Route::Group([
    'prefix' => 'algorithm-parameters',
    'as' => 'algorithm-parameters.'
], function () {
    
    Route::Group(['middleware' => 'auth:api'], function() {
        Route::get('', 'AlgorithmParameterController@index')->name('get');
        Route::get('/get-one', 'AlgorithmParameterController@getOne')->name('getOne');
        Route::get('/get-all', 'AlgorithmParameterController@getAll')->name('getAll');
        Route::post('', 'AlgorithmParameterController@store')->name('store');
        Route::get('{id}', 'AlgorithmParameterController@find')->name('find');
        Route::put('{id}', 'AlgorithmParameterController@update')->name('update');
        Route::delete('{id}', 'AlgorithmParameterController@destroy')->name('destroy');
    });
});

Route::Group([
    'prefix' => 'data-collections',
    'as' => 'data-collections.'
], function () {
    
    Route::get('for-gateway', 'DataCollectionController@index')->name('get');
    Route::get('export', 'DataCollectionController@export')->name('export');
    Route::post('import', 'DataCollectionController@import')->name('import');
    Route::Group(['middleware' => 'auth:api'], function() {
        Route::get('', 'DataCollectionController@index')->name('get');
        Route::get('/delete', 'DataCollectionController@delete')->name('delete');
        Route::get('get-by-waspmote-id/{id}', 'DataCollectionController@getByWaspmoteId')->name('get-by-waspmote-id');
        Route::post('seed', 'DataCollectionController@seed')->name('seed');
        Route::delete('{id}', 'DataCollectionController@destroy')->name('destroy');
    });
});

Route::Group([
    'prefix' => 'settings',
    'as' => 'settings.'
], function () {
    
    Route::Group(['middleware' => 'auth:api'], function() {
        Route::get('', 'SettingController@index')->name('get');
        Route::get('/comparision-page', 'SettingController@getComparisionPage')->name('getComparisionPage');
        Route::put('', 'SettingController@update')->name('update');
    });
});
