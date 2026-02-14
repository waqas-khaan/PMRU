@extends('layouts.app')

@section('title', 'Fee Structure | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Fee Structure</h1>
        <div class="flex gap-2">
            <a href="{{ route('finance.fee-structures.edit', $feeStructure) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-700 bg-ink-100 rounded-lg hover:bg-ink-200">Edit</a>
            <a href="{{ route('finance.fee-structures.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6 space-y-3">
        <p><span class="text-ink-500">Term:</span> {{ $feeStructure->term->name ?? '—' }} ({{ $feeStructure->term->academicYear->name ?? '' }})</p>
        <p><span class="text-ink-500">Fee type:</span> {{ $feeStructure->feeType->name ?? '—' }}</p>
        <p><span class="text-ink-500">Class:</span> {{ $feeStructure->class_name ?? 'All' }}</p>
        <p><span class="text-ink-500">Amount:</span> {{ number_format($feeStructure->amount, 2) }}</p>
        <p><span class="text-ink-500">Due date:</span> {{ $feeStructure->due_date?->format('M j, Y') ?? '—' }}</p>
    </div>
@endsection
