@extends('layouts.app')

@section('title', $student->name . ' | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">{{ $student->name }}</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('students.edit', $student->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-700 bg-ink-100 hover:bg-ink-200 rounded-lg">Edit</a>
            <a href="{{ route('students.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div><dt class="font-medium text-ink-500">Email</dt><dd class="text-ink-900 mt-0.5">{{ $student->email ?? '—' }}</dd></div>
            <div><dt class="font-medium text-ink-500">Phone</dt><dd class="text-ink-900 mt-0.5">{{ $student->phone ?? '—' }}</dd></div>
            <div><dt class="font-medium text-ink-500">Class</dt><dd class="text-ink-900 mt-0.5">{{ $student->class ? $student->class . ($student->section ? ' ' . $student->section : '') : '—' }}</dd></div>
            <div><dt class="font-medium text-ink-500">Date of birth</dt><dd class="text-ink-900 mt-0.5">{{ $student->date_of_birth?->format('M j, Y') ?? '—' }}</dd></div>
            <div><dt class="font-medium text-ink-500">Gender</dt><dd class="text-ink-900 mt-0.5">{{ ucfirst($student->gender ?? '—') }}</dd></div>
            <div><dt class="font-medium text-ink-500">Enrollment date</dt><dd class="text-ink-900 mt-0.5">{{ $student->enrollment_date?->format('M j, Y') ?? '—' }}</dd></div>
            @if($student->address)
            <div class="sm:col-span-2"><dt class="font-medium text-ink-500">Address</dt><dd class="text-ink-900 mt-0.5">{{ $student->address }}</dd></div>
            @endif
        </dl>
    </div>
@endsection
