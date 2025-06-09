<?php

use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing.index');
Route::get('/article/{id}', [\App\Http\Controllers\LandingController::class, 'articlePage'])->name('landing.articlePage');
Route::get('/page/{id}', [\App\Http\Controllers\LandingController::class, 'detailPage'])->name('landing.detailPage');
Route::get('/article', [\App\Http\Controllers\LandingController::class, 'allArticles'])->name('landing.allArticles');
Route::get('/menu', [\App\Http\Controllers\LandingController::class, 'getMenu'])->name('landing.getMenu');

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'index'])->name('auth.index')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'verify'])->name('auth.verify');
Route::get('/signup', [\App\Http\Controllers\AuthController::class, 'signup'])->name('auth.signup')->middleware('guest');
Route::post('/signup', [\App\Http\Controllers\AuthController::class, 'signupProcess'])->name('auth.signupProcess');

Route::group(['middleware' => 'auth:user'], function () {
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name(name: 'dashboard.index');
        Route::get('/profile', [App\Http\Controllers\AdminDashboardController::class, 'profile'])->name(name: 'dashboard.profile');
        Route::get('/resetPassword', [App\Http\Controllers\AdminDashboardController::class, 'resetPassword'])->name(name: 'dashboard.resetPassword');
        Route::post('/resetPasswordProcess', [App\Http\Controllers\AdminDashboardController::class, 'resetPasswordProcess'])->name(name: 'dashboard.resetPasswordProcess');

        Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/adding', [App\Http\Controllers\CategoryController::class, 'adding'])->name('category.adding');
        Route::post('/category/addingProcess', [App\Http\Controllers\CategoryController::class, 'addingProcess'])->name('category.addingProcess');
        Route::get('/category/modify/{id}', [App\Http\Controllers\CategoryController::class, 'modify'])->name('category.modify');
        Route::post('/category/modifyProcess', [App\Http\Controllers\CategoryController::class, 'modifyProcess'])->name('category.modifyProcess');
        Route::get('/category/delete/{id}', [App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');
        Route::get('category/export', [App\Http\Controllers\CategoryController::class, 'export'])->name('category.export');

        Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
        Route::get('/news/adding', [App\Http\Controllers\NewsController::class, 'adding'])->name('news.adding');
        Route::post('/news/addingProcess', [App\Http\Controllers\NewsController::class, 'addingProcess'])->name('news.addingProcess');
        Route::get('/news/modify/{id}', [App\Http\Controllers\NewsController::class, 'modify'])->name('news.modify');
        Route::post('/news/modifyProcess', [App\Http\Controllers\NewsController::class, 'modifyProcess'])->name('news.modifyProcess');
        Route::get('/news/delete/{id}', [App\Http\Controllers\NewsController::class, 'delete'])->name('news.delete');
        Route::get('/news/export', [App\Http\Controllers\NewsController::class, 'export'])->name('news.export');

        Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('/user/adding', [App\Http\Controllers\UserController::class, 'adding'])->name('user.adding');
        Route::post('/user/addingProcess', [App\Http\Controllers\UserController::class, 'addingProcess'])->name('user.addingProcess');
        Route::get('/user/modify/{id}', [App\Http\Controllers\UserController::class, 'modify'])->name('user.modify');
        Route::post('/user/modifyProcess', [App\Http\Controllers\UserController::class, 'modifyProcess'])->name('user.modifyProcess');
        Route::get('/user/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');

        Route::get('/page', [App\Http\Controllers\PageController::class, 'index'])->name('page.index');
        Route::get('/page/adding', [App\Http\Controllers\PageController::class, 'adding'])->name('page.adding');
        Route::post('/page/addingProcess', [App\Http\Controllers\PageController::class, 'addingProcess'])->name('page.addingProcess');
        Route::get('/page/modify/{id}', [App\Http\Controllers\PageController::class, 'modify'])->name('page.modify');
        Route::post('/page/modifyProcess', [App\Http\Controllers\PageController::class, 'modifyProcess'])->name('page.modifyProcess');
        Route::get('/page/delete/{id}', [App\Http\Controllers\PageController::class, 'delete'])->name('page.delete');

        Route::get('/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('menu.index');
        Route::get('/menu/adding', [App\Http\Controllers\MenuController::class, 'adding'])->name('menu.adding');
        Route::post('/menu/addingProcess', [App\Http\Controllers\MenuController::class, 'addingProcess'])->name('menu.addingProcess');
        Route::get('/menu/modify/{id}', [App\Http\Controllers\MenuController::class, 'modify'])->name('menu.modify');
        Route::post('/menu/modifyProcess', [App\Http\Controllers\MenuController::class, 'modifyProcess'])->name('menu.modifyProcess');
        Route::get('/menu/delete/{id}', [App\Http\Controllers\MenuController::class, 'delete'])->name('menu.delete');
        Route::get('/menu/order/{id}/{idSwap}', [App\Http\Controllers\MenuController::class, 'order'])->name('menu.order');
    });

    Route::prefix('editor')->middleware('role:editor')->group(function () {
        Route::get('/', [App\Http\Controllers\EditorDashboardController::class, 'index'])->name(name: 'dashboard.index');
        Route::get('/profile', [App\Http\Controllers\EditorDashboardController::class, 'profile'])->name(name: 'dashboard.profile');
        Route::get('/resetPassword', [App\Http\Controllers\EditorDashboardController::class, 'resetPassword'])->name(name: 'dashboard.resetPassword');
        Route::post('/resetPasswordProcess', [App\Http\Controllers\EditorDashboardController::class, 'resetPasswordProcess'])->name(name: 'dashboard.resetPasswordProcess');

        Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/adding', [App\Http\Controllers\CategoryController::class, 'adding'])->name('category.adding');
        Route::post('/category/addingProcess', [App\Http\Controllers\CategoryController::class, 'addingProcess'])->name('category.addingProcess');
        Route::get('/category/modify/{id}', [App\Http\Controllers\CategoryController::class, 'modify'])->name('category.modify');
        Route::post('/category/modifyProcess', [App\Http\Controllers\CategoryController::class, 'modifyProcess'])->name('category.modifyProcess');
        Route::get('/category/delete/{id}', [App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');
        Route::get('category/export', [App\Http\Controllers\CategoryController::class, 'export'])->name('category.export');

        Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
        Route::get('/news/adding', [App\Http\Controllers\NewsController::class, 'adding'])->name('news.adding');
        Route::post('/news/addingProcess', [App\Http\Controllers\NewsController::class, 'addingProcess'])->name('news.addingProcess');
        Route::get('/news/modify/{id}', [App\Http\Controllers\NewsController::class, 'modify'])->name('news.modify');
        Route::post('/news/modifyProcess', [App\Http\Controllers\NewsController::class, 'modifyProcess'])->name('news.modifyProcess');
        Route::get('/news/delete/{id}', [App\Http\Controllers\NewsController::class, 'delete'])->name('news.delete');
        Route::get('/news/export', [App\Http\Controllers\NewsController::class, 'export'])->name('news.export');

        Route::get('/user/modify/{id}', [App\Http\Controllers\UserController::class, 'modify'])->name('user.modify');
        Route::post('/user/modifyProcess', [App\Http\Controllers\UserController::class, 'modifyProcess'])->name('user.modifyProcess');
    });

    Route::prefix('author')->middleware('role:author')->group(function () {
        Route::get('/', [App\Http\Controllers\AuthorDashboardController::class, 'index'])->name(name: 'dashboard.index');
        Route::get('/profile', [App\Http\Controllers\AuthorDashboardController::class, 'profile'])->name(name: 'dashboard.profile');
        Route::get('/resetPassword', [App\Http\Controllers\AuthorDashboardController::class, 'resetPassword'])->name(name: 'dashboard.resetPassword');
        Route::post('/resetPasswordProcess', [App\Http\Controllers\AuthorDashboardController::class, 'resetPasswordProcess'])->name(name: 'dashboard.resetPasswordProcess');

        Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
        Route::get('/news/adding', [App\Http\Controllers\NewsController::class, 'adding'])->name('news.adding');
        Route::post('/news/addingProcess', [App\Http\Controllers\NewsController::class, 'addingProcess'])->name('news.addingProcess');
        Route::get('/news/modify/{id}', [App\Http\Controllers\NewsController::class, 'modify'])->name('news.modify');
        Route::post('/news/modifyProcess', [App\Http\Controllers\NewsController::class, 'modifyProcess'])->name('news.modifyProcess');
        Route::get('/news/delete/{id}', [App\Http\Controllers\NewsController::class, 'delete'])->name('news.delete');
        Route::get('/news/export', [App\Http\Controllers\NewsController::class, 'export'])->name('news.export');

        Route::get('/user/modify/{id}', [App\Http\Controllers\UserController::class, 'modify'])->name('user.modify');
        Route::post('/user/modifyProcess', [App\Http\Controllers\UserController::class, 'modifyProcess'])->name('user.modifyProcess');
    });

    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('files/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);

    if (!File::exists($fullPath)) {
        abort(404);
    }

    $file = File::get($fullPath);
    $type = File::mimeType($fullPath);
    return Response::make($file, 200)->header("Content-Type", $type);
})->where('path', '.*')->name('storage');