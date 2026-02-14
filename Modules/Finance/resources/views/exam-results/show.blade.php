@extends('layouts.app')

@section('title', 'Exam Result | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Exam Result #{{ $examResult->id }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('finance.exam-results.edit', $examResult) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-700 bg-ink-100 rounded-lg hover:bg-ink-200">Edit</a>
            <a href="{{ route('finance.exam-results.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6 space-y-3">
        <p><span class="text-ink-500">Exam:</span> {{ $examResult->exam->name ?? '—' }} ({{ $examResult->exam->term->name ?? '' }})</p>
        <p><span class="text-ink-500">Student ID:</span> {{ $examResult->student_id }}</p>
        <p><span class="text-ink-500">Marks:</span> {{ number_format($examResult->marks, 2) }}</p>
        <p><span class="text-ink-500">Grade:</span> {{ $examResult->grade ?? '—' }}</p>
        @if($examResult->remarks)
            <p><span class="text-ink-500">Remarks:</span> {{ $examResult->remarks }}</p>
        @endif
    </div>
@endsection
