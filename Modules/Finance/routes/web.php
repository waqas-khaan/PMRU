<?php

use Illuminate\Support\Facades\Route;
use Modules\Finance\Http\Controllers\AcademicYearController;
use Modules\Finance\Http\Controllers\ExamController;
use Modules\Finance\Http\Controllers\ExamResultController;
use Modules\Finance\Http\Controllers\FeePaymentController;
use Modules\Finance\Http\Controllers\FeeStructureController;
use Modules\Finance\Http\Controllers\FeeTypeController;
use Modules\Finance\Http\Controllers\FinanceController;
use Modules\Finance\Http\Controllers\TermController;

Route::middleware(['web'])->prefix('finance')->name('finance.')->group(function () {
    Route::get('/', [FinanceController::class, 'index'])->name('index');

    Route::resource('academic-years', AcademicYearController::class)->parameters(['academic-years' => 'academicYear']);
    Route::resource('terms', TermController::class);
    Route::resource('fee-types', FeeTypeController::class)->parameters(['fee-types' => 'feeType']);
    Route::resource('fee-structures', FeeStructureController::class)->parameters(['fee-structures' => 'feeStructure']);
    Route::resource('fee-payments', FeePaymentController::class)->parameters(['fee-payments' => 'feePayment']);
    Route::resource('exams', ExamController::class);
    Route::resource('exam-results', ExamResultController::class)->parameters(['exam-results' => 'examResult']);
});
