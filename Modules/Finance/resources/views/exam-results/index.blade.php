@extends('layouts.app')

@section('title', 'Exam Results | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-ink-900">Exam Results</h1>
            <p class="text-sm text-ink-500 mt-1">Marks and grades per student (student_id = Students module id).</p>
        </div>
        <a href="{{ route('finance.exam-results.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Add result</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if($examResults->isEmpty())
            <p class="text-sm text-ink-500">No exam results yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-ink-200 text-sm">
                    <thead class="bg-ink-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Exam</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Student ID</th>
                            <th class="px-4 py-2 text-right font-medium text-ink-700">Marks</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Grade</th>
                            <th class="px-4 py-2 text-right font-medium text-ink-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-100">
                        @foreach($examResults as $er)
                            <tr>
                                <td class="px-4 py-2 text-ink-900">{{ $er->exam->name ?? '—' }} ({{ $er->exam->term->name ?? '' }})</td>
                                <td class="px-4 py-2 font-medium">{{ $er->student_id }}</td>
                                <td class="px-4 py-2 text-right font-medium">{{ number_format($er->marks, 2) }}</td>
                                <td class="px-4 py-2 text-ink-600">{{ $er->grade ?? '—' }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route('finance.exam-results.show', $er) }}" class="text-accent-600 hover:text-accent-700">View</a>
                                    <a href="{{ route('finance.exam-results.edit', $er) }}" class="text-accent-600 hover:text-accent-700">Edit</a>
                                    <form method="POST" action="{{ route('finance.exam-results.destroy', $er) }}" class="inline" onsubmit="return confirm('Delete this result?');">
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
