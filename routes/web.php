<?php

use App\Http\Controllers\YoutubeTimelineController;
use Illuminate\Support\Facades\Route;

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

Route::get('/api/yt/list', [YoutubeTimelineController::class, 'list']);
Route::get('/twitter', function() {
    return view('twitter');
});
