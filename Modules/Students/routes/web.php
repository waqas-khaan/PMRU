<?php

use Illuminate\Support\Facades\Route;
use Modules\Students\Http\Controllers\StudentsController;

Route::middleware(['web', 'auth'])->prefix('students')->name('students.')->group(function () {
    Route::get('/', [StudentsController::class, 'index'])->name('index');
    Route::middleware(['role:Admin,Teacher'])->group(function () {
        Route::get('/create', [StudentsController::class, 'create'])->name('create');
        Route::post('/', [StudentsController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StudentsController::class, 'edit'])->name('edit');
        Route::put('/{id}', [StudentsController::class, 'update'])->name('update');
        Route::delete('/{id}', [StudentsController::class, 'destroy'])->name('destroy');
    });
    Route::get('/{id}', [StudentsController::class, 'show'])->name('show');
});
