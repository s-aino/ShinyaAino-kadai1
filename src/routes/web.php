<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

Route::get('/',         [ContactController::class, 'create']);
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::match(['get', 'post'], '/thanks', [ContactController::class, 'thanks'])->name('contact.thanks'); // PRG用
Route::post('/store',   [ContactController::class, 'store'])->name('contact.store'); // POST保存先（/thanks直POSTでもOK）
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->middleware('auth')
        ->name('admin.index');
    Route::get('/admin/export/csv', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/admin/{contact}', [AdminController::class, 'show'])->name('admin.show');
    Route::delete('/admin/{contact}', [AdminController::class, 'destroy'])->name('admin.destroy');
});
Route::post('/contact/back', [ContactController::class, 'back'])->name('contact.back');
