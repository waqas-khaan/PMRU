@extends('layouts.app')

@section('title', 'Finance & Exams | ' . config('app.name'))

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Finance &amp; Exams</h1>
        <p class="text-sm text-ink-500 mt-1">Manage academic years, terms, fees, payments, exams and results.</p>
    </div>

    @if (!$hasFinanceDb)
        <div class="mb-4 p-4 rounded-lg bg-amber-50 border border-amber-200 text-sm text-amber-800">
            Run migrations for the finance database first: <code class="bg-amber-100 px-1 rounded">php artisan migrate --database=mysql_finance</code>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('finance.academic-years.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Academic Years</h2>
            <p class="text-sm text-ink-500 mt-1">Define and manage academic years.</p>
        </a>
        <a href="{{ route('finance.terms.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Terms</h2>
            <p class="text-sm text-ink-500 mt-1">Term 1, Term 2, etc. per academic year.</p>
        </a>
        <a href="{{ route('finance.fee-types.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Fee Types</h2>
            <p class="text-sm text-ink-500 mt-1">Tuition, Transport, Lab, Library, etc.</p>
        </a>
        <a href="{{ route('finance.fee-structures.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Fee Structures</h2>
            <p class="text-sm text-ink-500 mt-1">Amount per fee type per term.</p>
        </a>
        <a href="{{ route('finance.fee-payments.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Fee Payments</h2>
            <p class="text-sm text-ink-500 mt-1">Record student fee payments.</p>
        </a>
        <a href="{{ route('finance.exams.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Exams</h2>
            <p class="text-sm text-ink-500 mt-1">Mid-term, Final, etc.</p>
        </a>
        <a href="{{ route('finance.exam-results.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Exam Results</h2>
            <p class="text-sm text-ink-500 mt-1">Marks and grades per student per exam.</p>
        </a>
    </div>
@endsection
