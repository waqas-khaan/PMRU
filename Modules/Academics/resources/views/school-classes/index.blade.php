@extends('layouts.app')

@section('title', 'Classes | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-ink-900">Classes</h1>
            <p class="text-sm text-ink-500 mt-1">Class 1, Grade 10, etc.</p>
        </div>
        <a href="{{ route('academics.school-classes.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Add class</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if($schoolClasses->isEmpty())
            <p class="text-sm text-ink-500">No classes yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-ink-200 text-sm">
                    <thead class="bg-ink-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Name</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Level</th>
                            <th class="px-4 py-2 text-right font-medium text-ink-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-100">
                        @foreach($schoolClasses as $c)
                            <tr>
                                <td class="px-4 py-2 font-medium text-ink-900">{{ $c->name }}</td>
                                <td class="px-4 py-2 text-ink-600">{{ $c->level ?? '—' }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route('academics.school-classes.show', $c) }}" class="text-accent-600 hover:text-accent-700">View</a>
                                    <a href="{{ route('academics.school-classes.edit', $c) }}" class="text-accent-600 hover:text-accent-700">Edit</a>
                                    <form method="POST" action="{{ route('academics.school-classes.destroy', $c) }}" class="inline" onsubmit="return confirm('Delete this class?');">
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
