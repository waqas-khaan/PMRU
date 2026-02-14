@extends('layouts.app')

@section('title', 'Academic Years | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-ink-900">Academic Years</h1>
            <p class="text-sm text-ink-500 mt-1">e.g. 2024-2025</p>
        </div>
        <a href="{{ route('academics.academic-years.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Add academic year</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if($academicYears->isEmpty())
            <p class="text-sm text-ink-500">No academic years yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-ink-200 text-sm">
                    <thead class="bg-ink-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Name</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Start</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">End</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Current</th>
                            <th class="px-4 py-2 text-right font-medium text-ink-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-100">
                        @foreach($academicYears as $ay)
                            <tr>
                                <td class="px-4 py-2 font-medium text-ink-900">{{ $ay->name }}</td>
                                <td class="px-4 py-2 text-ink-600">{{ $ay->start_date->format('M j, Y') }}</td>
                                <td class="px-4 py-2 text-ink-600">{{ $ay->end_date->format('M j, Y') }}</td>
                                <td class="px-4 py-2">{{ $ay->is_current ? 'Yes' : '—' }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route('academics.academic-years.show', $ay) }}" class="text-accent-600 hover:text-accent-700">View</a>
                                    <a href="{{ route('academics.academic-years.edit', $ay) }}" class="text-accent-600 hover:text-accent-700">Edit</a>
                                    <form method="POST" action="{{ route('academics.academic-years.destroy', $ay) }}" class="inline" onsubmit="return confirm('Delete this academic year?');">
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
    <p class="mt-4"><a href="{{ route('academics.index') }}" class="text-sm text-accent-600 hover:text-accent-700">← Back to Academics</a></p>
@endsection
