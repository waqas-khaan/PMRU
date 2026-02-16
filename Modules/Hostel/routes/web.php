<?php

use Illuminate\Support\Facades\Route;
use Modules\Hostel\Http\Controllers\HostelController;

Route::middleware(['web', 'auth', 'role:Admin'])->prefix('hostel')->name('hostel.')->group(function () {
    Route::get('/', [HostelController::class, 'index'])->name('index');
});
