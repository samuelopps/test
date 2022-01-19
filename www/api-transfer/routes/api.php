<?php

use App\Http\Controllers\Api\V1\PurseController;
use App\Http\Controllers\Api\V1\TransferController;
use App\Http\Controllers\Api\V1\UserController;
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

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('users/{user_id}/purse', [UserController::class, 'getPurse'])
        ->name('users.getPurse');
    Route::resource('users', UserController::class);

    Route::resource('transfers', TransferController::class);

    Route::patch('purses/{purse_id}/balance', [PurseController::class, 'updateBalance'])
        ->name('purses.updateBalance');
    Route::resource('purses', PurseController::class);
});
