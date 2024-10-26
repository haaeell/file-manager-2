<?php

use App\Http\Controllers\FileManagerController;
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
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/filemanager', [FileManagerController::class, 'index'])->name('filemanager.index');
    Route::get('/filemanager/create', [FileManagerController::class, 'create'])->name('filemanager.create');
    Route::post('/filemanager', [FileManagerController::class, 'store'])->name('filemanager.store');
    Route::get('/filemanager/create-folder', [FileManagerController::class, 'createFolder'])->name('filemanager.create.folder');
    Route::post('/filemanager/folders', [FileManagerController::class, 'storeFolder'])->name('filemanager.store.folder');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
