<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BackgroundImageController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\MenuController;
use App\Models\Api\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/confirm-code/{email}', [AuthController::class, 'confirmCode']);

Route::post('/set-password/{email}', [AuthController::class, 'setPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/get-components', [ComponentController::class, 'get']);

    Route::post('/get-background-images', [ BackgroundImageController::class, 'get' ]);

    Route::prefix('component/')->group(function () {

        Route::post('save', [ComponentController::class, 'save']);
        Route::get('view/{menuId}', [ComponentController::class, 'getView']);

    });

    Route::prefix('menu/')->group(function () {

        Route::post('update/{menuId}', [ComponentController::class, 'update']);

        Route::prefix('templates')->group(function() {
            Route::get('', [MenuController::class, 'getTemplates']);
        });
        Route::get('get', [MenuController::class, 'getByUser']);
        Route::post('delete/{menuId}', [MenuController::class, 'delete']);
    });
});
