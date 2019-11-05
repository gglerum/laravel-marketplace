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

Route::apiResource('advertenties', 'AuctionController')
->names([
	'update' => 'auctions.update',
	'destroy' => 'auctions.destroy',
	'index' => 'auctions.index',
	'show' => 'auctions.show',
	'store' => 'auctions.store'
])
->parameters([
	'advertenties'=>'auction'
]);

Route::apiResource('rubrics', 'RubricController')
->parameters([
	'rubrics'=>'rubric'
]);