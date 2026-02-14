<?php

use Illuminate\Support\Facades\Route;
use Modules\Academics\Http\Controllers\AcademicYearController;
use Modules\Academics\Http\Controllers\AcademicsController;
use Modules\Academics\Http\Controllers\ClassSubjectController;
use Modules\Academics\Http\Controllers\SchoolClassController;
use Modules\Academics\Http\Controllers\SectionController;
use Modules\Academics\Http\Controllers\SubjectController;
use Modules\Academics\Http\Controllers\TermController;
use Modules\Academics\Http\Controllers\TimetableSlotController;

Route::middleware(['web'])->prefix('academics')->name('academics.')->group(function () {
    Route::get('/', [AcademicsController::class, 'index'])->name('index');

    Route::resource('academic-years', AcademicYearController::class)->parameters(['academic-years' => 'academicYear']);
    Route::resource('terms', TermController::class);
    Route::resource('school-classes', SchoolClassController::class)->parameters(['school-classes' => 'schoolClass']);
    Route::resource('sections', SectionController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('class-subjects', ClassSubjectController::class)->parameters(['class-subjects' => 'classSubject']);
    Route::resource('timetable-slots', TimetableSlotController::class)->parameters(['timetable-slots' => 'timetableSlot']);
});
