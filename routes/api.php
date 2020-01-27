<?php

use Illuminate\Http\Request;
use App\Rectangle;
use App\Png;
use App\Http\Middleware\PngMiddleware;

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

Route::get('png', function() {
    return Png::all();
});

Route::middleware(['middleware' => PngMiddleware::Class])->post('generate-rectangles', 'Api\PngController@add');

Route::get('generate-rectangles/{id}', function($id) {
    return Rectangle::all()->where('rectangle_id', $id);
});

Route::get('generate-rectangles', ['middleware' => PngMiddleware::Class , function () {
    return Rectangle::all();
}]);
