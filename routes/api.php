<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\ShareLinkController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/user/login', [UserAuthController::class, 'login'])->name('user.login');

Route::group(['middleware' => ['jwt.auth', 'cors']], function () {
    Route::post('/user/logout', [UserAuthController::class, 'logout'])->name('user.logout');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::post('/file/upload', [FileController::class, 'upload'])->name('file.upload');
    Route::get('/file/list', [FileController::class, 'list'])->name('file.list');
    Route::post('/file/delete', [FileController::class, 'delete'])->name('file.delete');
    Route::post('/links/create', [ShareLinkController::class, 'create'])->name('links.create');
    Route::get('/links/list', [ShareLinkController::class, 'list'])->name('links.list');
    Route::get('/user/links', [UserController::class, 'links'])->name('user.links');
    Route::get('/links/share/{link}', [ShareLinkController::class, 'show'])->name('links.show');
    Route::get('/admin/create-link', [AdminDashboardController::class, 'createLink'])->name('admin.create.link');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
});
