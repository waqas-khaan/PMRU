@extends('layouts.app')

@section('title', $schoolClass->name . ' | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">{{ $schoolClass->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('academics.school-classes.edit', $schoolClass) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-700 bg-ink-100 rounded-lg hover:bg-ink-200">Edit</a>
            <a href="{{ route('academics.school-classes.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6 space-y-4">
        <p><span class="text-ink-500">Level:</span> {{ $schoolClass->level ?? '—' }}</p>
        @if($schoolClass->sections->isNotEmpty())
            <p class="text-ink-500">Sections:</p>
            <ul class="list-disc list-inside">{{ $schoolClass->sections->pluck('name')->join(', ') }}</ul>
        @endif
        @if($schoolClass->subjects->isNotEmpty())
            <p class="text-ink-500">Subjects:</p>
            <ul class="list-disc list-inside">{{ $schoolClass->subjects->pluck('name')->join(', ') }}</ul>
        @endif
    </div>
@endsection
