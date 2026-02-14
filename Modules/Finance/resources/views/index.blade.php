@extends('layouts.app')

@section('title', 'Finance & Exams | ' . config('app.name'))

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Finance & Exams</h1>
        <p class="text-sm text-ink-500 mt-1">Fee types, structures, payments, exams and results.</p>
    </div>

    @if (!$hasFinanceDb)
        <div class="mb-4 p-4 rounded-lg bg-amber-50 border border-amber-200 text-sm text-amber-800">
            Run migrations for the Finance database first:
            <code class="bg-amber-100 px-1 rounded block mt-2">php artisan migrate --database=mysql_finance --path=Modules/Finance/database/migrations</code>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="p-4 bg-white rounded-xl shadow-sm border border-ink-200/80">
            <h2 class="font-semibold text-ink-900">Fee Types</h2>
            <p class="text-sm text-ink-500 mt-1">Tuition, transport, etc.</p>
        </div>
        <div class="p-4 bg-white rounded-xl shadow-sm border border-ink-200/80">
            <h2 class="font-semibold text-ink-900">Fee Structures</h2>
            <p class="text-sm text-ink-500 mt-1">Amounts per class/term</p>
        </div>
        <div class="p-4 bg-white rounded-xl shadow-sm border border-ink-200/80">
            <h2 class="font-semibold text-ink-900">Fee Payments</h2>
            <p class="text-sm text-ink-500 mt-1">Record payments</p>
        </div>
        <div class="p-4 bg-white rounded-xl shadow-sm border border-ink-200/80">
            <h2 class="font-semibold text-ink-900">Exams</h2>
            <p class="text-sm text-ink-500 mt-1">Exam definitions</p>
        </div>
        <div class="p-4 bg-white rounded-xl shadow-sm border border-ink-200/80">
            <h2 class="font-semibold text-ink-900">Exam Results</h2>
            <p class="text-sm text-ink-500 mt-1">Marks per student</p>
        </div>
    </div>
@endsection
