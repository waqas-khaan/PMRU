@extends('layouts.app')

@section('title', 'Fee Structures | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-ink-900">Fee Structures</h1>
            <p class="text-sm text-ink-500 mt-1">Amount per fee type per term.</p>
        </div>
        <a href="{{ route('finance.fee-structures.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Add fee structure</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if($feeStructures->isEmpty())
            <p class="text-sm text-ink-500">No fee structures yet. Add terms and fee types first.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-ink-200 text-sm">
                    <thead class="bg-ink-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Term</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Fee type</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Class</th>
                            <th class="px-4 py-2 text-right font-medium text-ink-700">Amount</th>
                            <th class="px-4 py-2 text-right font-medium text-ink-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-100">
                        @foreach($feeStructures as $fs)
                            <tr>
                                <td class="px-4 py-2 text-ink-900">{{ $fs->term->name ?? '—' }} ({{ $fs->term->academicYear->name ?? '' }})</td>
                                <td class="px-4 py-2 text-ink-900">{{ $fs->feeType->name ?? '—' }}</td>
                                <td class="px-4 py-2 text-ink-600">{{ $fs->class_name ?? 'All' }}</td>
                                <td class="px-4 py-2 text-right font-medium">{{ number_format($fs->amount, 2) }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route('finance.fee-structures.show', $fs) }}" class="text-accent-600 hover:text-accent-700">View</a>
                                    <a href="{{ route('finance.fee-structures.edit', $fs) }}" class="text-accent-600 hover:text-accent-700">Edit</a>
                                    <form method="POST" action="{{ route('finance.fee-structures.destroy', $fs) }}" class="inline" onsubmit="return confirm('Delete this fee structure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <p class="mt-4"><a href="{{ route('finance.index') }}" class="text-sm text-accent-600 hover:text-accent-700">← Back to Finance</a></p>
@endsection
