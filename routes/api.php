<?php

use Illuminate\Support\Facades\Route;

Route::get('/teams', [\App\Http\Controllers\API\ApiController::class, 'getTeamList']);
Route::get('/generate-fixture', [\App\Http\Controllers\API\ApiController::class, 'generateFixture']);
Route::get('/play', [\App\Http\Controllers\API\ApiController::class, 'play']);
Route::get('/play-all', [\App\Http\Controllers\API\ApiController::class, 'playAll']);
Route::get('/champions', [\App\Http\Controllers\API\ApiController::class, 'championsProbabilities']);
Route::get('/reset', [\App\Http\Controllers\API\ApiController::class, 'reset']);
