<?php

use Illuminate\Support\Facades\Route;
use Modules\Students\Http\Controllers\StudentsController;


Route::middleware(['web'])->prefix('students')->name('students.')->group(function () {
    Route::get('/', [StudentsController::class, 'index'])->name('index');
    Route::get('/create', [StudentsController::class, 'create'])->name('create');
    Route::post('/', [StudentsController::class, 'store'])->name('store');
    Route::get('/{id}', [StudentsController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [StudentsController::class, 'edit'])->name('edit');
    Route::put('/{id}', [StudentsController::class, 'update'])->name('update');
    Route::delete('/{id}', [StudentsController::class, 'destroy'])->name('destroy');
});

// Students module routes without auth middleware
Route::prefix('students')->group(function () {

    // Resource routes
    Route::resource('/students', StudentsController::class)
        ->names('students'); // routes: students.index, students.create, etc.

    // Additional routes if needed
    Route::get('/list', function () {
        return "List of Students";
    });

});

