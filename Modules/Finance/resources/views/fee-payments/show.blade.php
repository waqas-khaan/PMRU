@extends('layouts.app')

@section('title', 'Fee Payment | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Fee Payment #{{ $feePayment->id }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('finance.fee-payments.edit', $feePayment) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-700 bg-ink-100 rounded-lg hover:bg-ink-200">Edit</a>
            <a href="{{ route('finance.fee-payments.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6 space-y-3">
        <p><span class="text-ink-500">Student ID:</span> {{ $feePayment->student_id }}</p>
        <p><span class="text-ink-500">Fee:</span> {{ $feePayment->feeStructure->term->name ?? '—' }} / {{ $feePayment->feeStructure->feeType->name ?? '—' }}</p>
        <p><span class="text-ink-500">Amount:</span> {{ number_format($feePayment->amount, 2) }}</p>
        <p><span class="text-ink-500">Paid at:</span> {{ $feePayment->paid_at->format('M j, Y') }}</p>
        <p><span class="text-ink-500">Payment method:</span> {{ $feePayment->payment_method ?? '—' }}</p>
        <p><span class="text-ink-500">Reference:</span> {{ $feePayment->reference ?? '—' }}</p>
        @if($feePayment->remarks)
            <p><span class="text-ink-500">Remarks:</span> {{ $feePayment->remarks }}</p>
        @endif
    </div>
@endsection
