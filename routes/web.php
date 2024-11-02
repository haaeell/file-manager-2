<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HomeController;
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
});
