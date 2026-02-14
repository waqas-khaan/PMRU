@extends('layouts.app')

@section('title', 'Fee Types | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-ink-900">Fee Types</h1>
            <p class="text-sm text-ink-500 mt-1">Tuition, Transport, Lab, Library, etc.</p>
        </div>
        <a href="{{ route('finance.fee-types.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Add fee type</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if($feeTypes->isEmpty())
            <p class="text-sm text-ink-500">No fee types yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-ink-200 text-sm">
                    <thead class="bg-ink-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Name</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Code</th>
                            <th class="px-4 py-2 text-right font-medium text-ink-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-100">
                        @foreach($feeTypes as $ft)
                            <tr>
                                <td class="px-4 py-2 font-medium text-ink-900">{{ $ft->name }}</td>
                                <td class="px-4 py-2 text-ink-600">{{ $ft->code ?? '—' }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route('finance.fee-types.show', $ft) }}" class="text-accent-600 hover:text-accent-700">View</a>
                                    <a href="{{ route('finance.fee-types.edit', $ft) }}" class="text-accent-600 hover:text-accent-700">Edit</a>
                                    <form method="POST" action="{{ route('finance.fee-types.destroy', $ft) }}" class="inline" onsubmit="return confirm('Delete this fee type?');">
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
