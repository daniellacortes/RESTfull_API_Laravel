<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/articles', ArticleController::class)->middleware('auth:sanctum');

Route::post('/user/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('/user', UserController::class)->middleware('auth:sanctum');