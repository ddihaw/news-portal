<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login',[\App\Http\Controllers\AuthController::class, 'index'])->name('auth.index')->middleware('guest');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'verify'])->name('auth.verify');

Route::group(['middleware' => 'auth:user'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name(name: 'dashboard.index');
        Route::get('/profile', [App\Http\Controllers\DashboardController::class, 'profil'])->name(name: 'dashboard.profil');

        Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/adding', [App\Http\Controllers\CategoryController::class, 'adding'])->name('category.adding');
        Route::post('/category/addingProcess', [App\Http\Controllers\CategoryController::class, 'addingProcess'])->name('category.addingProcess');
        Route::get('/category/modify/{id}', [App\Http\Controllers\CategoryController::class, 'modify'])->name('category.modify');
        Route::post('/category/modifyProcess', [App\Http\Controllers\CategoryController::class, 'modifyProcess'])->name('category.modifyProcess');
        Route::get('/category/delete/{id}', [App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');
    });

    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});