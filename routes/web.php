<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Website\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Enums\RoleEnum; // for user roles definition (user credentials in CreateUsersSeeder)

Route::get('/', function () { 
    return redirect('articles');
});
Route::get('/articles', [ArticleController::class, 'index'])->name('articles');

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::middleware(['role:'.RoleEnum::ADMIN->value])->group(function () {
        Route::get('/edit_article/{id}', [AdminController::class, 'edit'])->name('articles.edit');
        Route::put('/update_article/{id}', [AdminController::class, 'update'])->name('articles.update');
        Route::delete('/delete_article/{id}', [AdminController::class, 'delete'])->name('articles.destroy');
        Route::get('/create_article', [AdminController::class, 'create'])->name('articles.create');
        Route::post('/store_article', [AdminController::class,'store'])->name('articles.store');
    });
    Route::get('/article_view/{id}', [AdminController::class,'article_view'])->name('articles.view');
    Route::get('/article_list', [AdminController::class,'index'])->name('articles.index');
    Route::get('/draft_list', [AdminController::class,'draft'])->name('drafts.index');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
