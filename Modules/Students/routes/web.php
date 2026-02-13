<?php

use Illuminate\Support\Facades\Route;
use Modules\Students\Http\Controllers\StudentsController;

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