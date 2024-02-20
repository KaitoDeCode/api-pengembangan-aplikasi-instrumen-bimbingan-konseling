<?php

use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('cekKey')->group(function () {
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get("/test",fn()=> response()->json(auth()->user()));
    });
    Route::middleware(['auth:sanctum','cekAdmin'])->group(function () {
        Route::get("/test-admin",fn()=> response()->json(auth()->user()));
    });

    Route::middleware(['auth:sanctum','cekUser'])->group(function () {
        Route::get("/test-user",fn()=> response()->json(auth()->user()));
        Route::controller(AuthController::class)->group(function () {

        });
    });
});


Route::apiResource('instrument', App\Http\Controllers\InstrumentController::class);


Route::apiResource('instrument', App\Http\Controllers\InstrumentController::class);

Route::apiResource('group', App\Http\Controllers\GroupController::class);

Route::apiResource('question', App\Http\Controllers\QuestionController::class);

Route::apiResource('answer', App\Http\Controllers\AnswerController::class);

Route::apiResource('criteria', App\Http\Controllers\CriteriaController::class);

Route::apiResource('participation', App\Http\Controllers\ParticipationController::class);
