<?php

use \Core\Router as Route;
use App\Http\Controllers\AuthController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

Route::get('/login', AuthController::class, 'index', [GuestMiddleware::class]);

Route::post('/login', AuthController::class, 'attempt', [GuestMiddleware::class]);

Route::post('/logout', AuthController::class, 'destroy', [AuthMiddleware::class]);
