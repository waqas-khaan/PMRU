@extends('layouts.app')

@section('title', $section->name . ' | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">{{ $section->schoolClass->name ?? '—' }} – {{ $section->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('academics.sections.edit', $section) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-700 bg-ink-100 rounded-lg hover:bg-ink-200">Edit</a>
            <a href="{{ route('academics.sections.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6 space-y-3">
        <p><span class="text-ink-500">Class:</span> {{ $section->schoolClass->name ?? '—' }}</p>
        <p><span class="text-ink-500">Capacity:</span> {{ $section->capacity ?? '—' }}</p>
    </div>
@endsection
