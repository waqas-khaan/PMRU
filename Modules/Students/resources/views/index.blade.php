@extends('layouts.app')

@section('title', 'Students | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-ink-900">Students</h1>
            <p class="text-sm text-ink-500 mt-1">Manage and view students.</p>
        </div>
        <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">
            Add student
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        <h2 class="text-lg font-semibold text-ink-900 mb-4">Student list</h2>
        @if($students->isEmpty())
            <p class="text-sm text-ink-500">No students yet. Use "Add student" to create one.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-ink-200 text-sm">
                    <thead class="bg-ink-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Name</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Email</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Class</th>
                            <th class="px-4 py-2 text-left font-medium text-ink-700">Phone</th>
                            <th class="px-4 py-2 text-right font-medium text-ink-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-100">
                        @foreach($students as $student)
                            <tr>
                                <td class="px-4 py-2 font-medium text-ink-900"><a href="{{ route('students.show', $student->id) }}" class="text-accent-600 hover:text-accent-700 hover:underline">{{ $student->name }}</a></td>
                                <td class="px-4 py-2 text-ink-600">{{ $student->email ?? '—' }}</td>
                                <td class="px-4 py-2 text-ink-600">{{ $student->class ? $student->class . ($student->section ? ' ' . $student->section : '') : '—' }}</td>
                                <td class="px-4 py-2 text-ink-600">{{ $student->phone ?? '—' }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('students.edit', $student->id) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-ink-700 bg-ink-100 hover:bg-ink-200 rounded-md mr-1">Edit</a>
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this student? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-md">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
