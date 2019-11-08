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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->post('/auctions/{id}/bid', 'AuctionController@bid')->name('auctions.bid');
Route::apiResource('auctions', 'AuctionController')
->parameters([
	'auctions'=>'auction'
]);

Route::apiResource('rubrics', 'RubricController')
->parameters([
	'rubrics'=>'rubric'
]);