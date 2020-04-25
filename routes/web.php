<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ActorController;

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

Route::get('/', [MovieController::class, 'index'])
    ->name('movies.index');
Route::get('movies/{movieId}', [MovieController::class, 'show'])
    ->name('movies.show');

Route::get('actors', [ActorController::class, 'index'])
    ->name('actors.index');
Route::get('actors/{actorId}', [ActorController::class, 'show'])
    ->name('actors.show');
