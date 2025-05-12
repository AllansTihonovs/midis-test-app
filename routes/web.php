<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\AdminController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [MessageController::class, 'index'])->name('messages.index');

Route::resource('messages', MessageController::class)->except([
    'index', 'show'
]);
Route::resource('admin', AdminController::class)->except([
    'show'
]);

require __DIR__.'/auth.php';
