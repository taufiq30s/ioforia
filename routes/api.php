<?php

use App\Http\Controllers\TwitterFeedController;
use App\Http\Controllers\YoutubeTimelineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/yt/update', [YoutubeTimelineController::class, 'update']);
Route::get('/yt/list', [YoutubeTimelineController::class, 'list']);
Route::get('/yt/test', [YoutubeTimelineController::class, 'test']);
Route::get('/twitter/test/', [TwitterFeedController::class, 'tester']);
