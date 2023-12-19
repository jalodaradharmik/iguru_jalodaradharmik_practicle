<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BlogController;
use App;

   
Route::middleware('setLang')->group( function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [RegisterController::class, 'login']);
});
     
Route::middleware(['auth:api','setLang'])->group( function () {
    Route::post('blog/list', [BlogController::class, 'list']);
    Route::post('blog/store', [BlogController::class, 'store']);
    Route::post('blog/delete', [BlogController::class, 'delete']);
    Route::post('blog/detail', [BlogController::class, 'detail']);
    Route::post('blog/edit', [BlogController::class, 'edit']);
});