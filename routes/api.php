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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/scores', 'Api\ScoringController@index');

Route::get('/collections', 'Api\CollectionController@index');

Route::get('/tags', 'Api\TagController@index');

Route::prefix('tags')->group(function() {
    Route::get('/', 'Api\TagController@index');
    Route::post('/create', 'Api\TagController@store');
});

Route::prefix('collections')->group(function() {
    Route::get('/{collection}', 'Api\CollectionController@show')->where('collection', '[0-9]+');
    Route::get('/{collection}/cards', 'Api\CardController@index')->where('collection', '[0-9]+');
});

Route::prefix('cards')->group(function() {
    Route::get('/card-types', 'Api\CardController@types');

    Route::delete('/{card}', 'Api\CardController@destroy')->where('card', '[0-9]+');
});

Route::prefix('validate')->group(function() {
    Route::post('/', 'Api\ValidationController@validateFields');
    Route::post('/file', 'Api\ValidationController@validateFile');
});

Route::post('/validate', 'Api\ValidationController@validateFields');
