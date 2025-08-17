<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/user/login', [UserAuthController::class, 'login'])->name('user.login');
