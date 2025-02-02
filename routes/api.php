<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LinkController;

Route::post('/encode', [LinkController::class, 'encode']);
Route::post('/decode', [LinkController::class, 'decode']);
