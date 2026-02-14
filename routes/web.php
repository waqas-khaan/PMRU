<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $studentCount = 0;
        if (class_exists(\Modules\Students\Models\Student::class)
            && Schema::connection('mysql_students')->hasTable('students')) {
            $studentCount = \Modules\Students\Models\Student::count();
        }
        return view('dashboard', ['studentCount' => $studentCount]);
    })->name('dashboard');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');
