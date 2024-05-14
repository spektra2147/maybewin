<?php

use Illuminate\Support\Facades\Route;

Route::get('/teams', [\App\Http\Controllers\API\ApiController::class, 'getTeamList']);
Route::post('/generate-fixture', [\App\Http\Controllers\API\ApiController::class, 'generateFixture']);
Route::post('/play', [\App\Http\Controllers\API\ApiController::class, 'play']);
Route::post('/play-all', [\App\Http\Controllers\API\ApiController::class, 'playAll']);
Route::get('/champions', [\App\Http\Controllers\API\ApiController::class, 'championsProbabilities']);
Route::post('/reset', [\App\Http\Controllers\API\ApiController::class, 'reset']);
