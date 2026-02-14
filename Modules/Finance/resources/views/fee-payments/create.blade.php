@extends('layouts.app')

@section('title', 'Record Fee Payment | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Record Fee Payment</h1>
        <a href="{{ route('finance.fee-payments.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-100 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        <p class="mb-4 text-sm text-ink-500">Student ID must match <code class="bg-ink-100 px-1 rounded">students.id</code> in the Students module (school_students_db).</p>

        <form method="POST" action="{{ route('finance.fee-payments.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="student_id" class="block text-sm font-medium text-ink-700 mb-1">Student ID <span class="text-red-500">*</span></label>
                    <input type="number" name="student_id" id="student_id" value="{{ old('student_id') }}" min="1" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500" placeholder="ID from Students module">
                </div>
                <div class="sm:col-span-2">
                    <label for="fee_structure_id" class="block text-sm font-medium text-ink-700 mb-1">Fee structure <span class="text-red-500">*</span></label>
                    <select name="fee_structure_id" id="fee_structure_id" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                        <option value="">Select</option>
                        @foreach($feeStructures as $fs)
                            <option value="{{ $fs->id }}" {{ old('fee_structure_id') == $fs->id ? 'selected' : '' }}>{{ $fs->term->name ?? '' }} / {{ $fs->feeType->name ?? '' }} — {{ number_format($fs->amount, 2) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-ink-700 mb-1">Amount <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" step="0.01" min="0" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="paid_at" class="block text-sm font-medium text-ink-700 mb-1">Paid at <span class="text-red-500">*</span></label>
                    <input type="date" name="paid_at" id="paid_at" value="{{ old('paid_at', date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-ink-700 mb-1">Payment method</label>
                    <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method') }}" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500" placeholder="e.g. Cash, Bank">
                </div>
                <div>
                    <label for="reference" class="block text-sm font-medium text-ink-700 mb-1">Reference</label>
                    <input type="text" name="reference" id="reference" value="{{ old('reference') }}" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div class="sm:col-span-2">
                    <label for="remarks" class="block text-sm font-medium text-ink-700 mb-1">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="2" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">{{ old('remarks') }}</textarea>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Record payment</button>
                <a href="{{ route('finance.fee-payments.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-600 bg-ink-100 rounded-lg hover:bg-ink-200">Cancel</a>
            </div>
        </form>
    </div>
@endsection
