<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileCategoryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('files', FileController::class)->except(['show', 'edit', 'update']);
    Route::post('files/{id}/restore', [FileController::class, 'restore'])->name('files.restore');
    Route::get('/folders/{id}', [FileController::class, 'showFolder'])->name('showFolder');
    Route::patch('/rename-item', [FileController::class, 'rename'])->name('renameItem');
    Route::post('/toggle-favorite', [FileController::class, 'toggleFavorite'])->name('toggleFavorite');
    Route::get('/download-folder/{id}', [FileController::class, 'downloadFolder'])->name('downloadFolder');
    Route::post('/delete-items', [FileController::class, 'deleteItems'])->name('deleteItems');
    Route::post('/share-items', [FileController::class, 'shareItems'])->name('shareItems');

    Route::get('/shared-by-me', [HomeController::class, 'sharedByMe'])->name('sharedByMe');
    Route::get('/shared-with-me', [HomeController::class, 'sharedWithMe'])->name('sharedWithMe');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/trash', [HomeController::class, 'trash'])->name('trash');
    Route::post('/trash/restore', [HomeController::class, 'restoreItem'])->name('trash.restore');
    Route::post('/trash/delete', [HomeController::class, 'deleteItemPermanently'])->name('trash.delete');
    Route::get('/search', [HomeController::class, 'search']);
    Route::post('/notifications/mark-as-read', [HomeController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::resource('departments', DepartmentController::class);
    Route::resource('file-categories', FileCategoryController::class);
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('userManagement');
    Route::get('/user-management/create', [UserManagementController::class, 'create'])->name('userManagement.create');
    Route::post('/user-management/store', [UserManagementController::class, 'store'])->name('userManagement.store');
    Route::get('/user-management/{id}/edit', [UserManagementController::class, 'edit'])->name('userManagement.edit');
    Route::put('/user-management/{id}', [UserManagementController::class, 'update'])->name('userManagement.update');
    Route::delete('/user-management/{id}', [UserManagementController::class, 'destroy'])->name('userManagement.destroy');
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::get('/favorites', [HomeController::class, 'favorites'])->name('favorites');
    Route::get('/departemen-files/{id}', [HomeController::class, 'departemenFiles'])->name('departemen-files');
});
