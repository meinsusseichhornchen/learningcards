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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/api/scores', 'Api\ScoringController@index');
Route::get('/api/collections', 'Api\CollectionController@index');

Route::get('/collections/edit/{collection}', 'CollectionController@edit')
    ->where('collection', '[0-9]+')
    ->name('edit_collection');


Route::middleware('auth')->group(function() {
    Route::prefix('collections')->group(function() {
        Route::get('/create', 'CollectionController@create')
            ->name('create_collection');
        Route::get('/edit/{collection}', 'CollectionController@edit')
            ->where('collection', '[0-9]+')
            ->name('edit_collection');
        Route::get('/show/{collection}', 'CollectionController@show')
            ->where('collection', '[0-9]+')
            ->name('show_collection');
        Route::post('update', 'CollectionController@update')
            ->name('update_collection');
        Route::post('/create', 'CollectionController@store')
            ->name('store_collection');

        Route::get('/{collection}/cards/create', 'CardController@create')
            ->where('collection', '[0-9]+')
            ->name('create_card_collection');
        Route::post('/{collection}/cards/create', 'CardController@store')
            ->where('collection', '[0-9]+')
            ->name('store_card_collection');
    });

    Route::prefix('cards')->group(function() {
        Route::get('/create', 'CardController@create')
            ->name('create_card');
        Route::get('/edit/{card}', 'CardController@edit')
            ->where('card', '[0-9]+')
            ->name('edit_card');
        Route::put('/update/{card}', 'CardController@update')
            ->where('card', '[0-9]+')
            ->name('update_card');
        Route::post('/create', 'CardController@store')
            ->name('store_card');
    });
});


