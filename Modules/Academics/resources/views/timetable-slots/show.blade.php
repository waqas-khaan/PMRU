@extends('layouts.app')

@section('title', 'Timetable Slot | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Timetable Slot</h1>
        <div class="flex gap-2">
            <a href="{{ route('academics.timetable-slots.edit', $timetableSlot) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-700 bg-ink-100 rounded-lg hover:bg-ink-200">Edit</a>
            <a href="{{ route('academics.timetable-slots.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6 space-y-3">
        <p><span class="text-ink-500">Day:</span> {{ ['','Mon','Tue','Wed','Thu','Fri','Sat','Sun'][$timetableSlot->day_of_week] ?? $timetableSlot->day_of_week }}</p>
        <p><span class="text-ink-500">Period:</span> {{ $timetableSlot->period }}</p>
        <p><span class="text-ink-500">Class:</span> {{ $timetableSlot->schoolClass->name ?? '—' }}</p>
        <p><span class="text-ink-500">Section:</span> {{ $timetableSlot->section->name ?? '—' }}</p>
        <p><span class="text-ink-500">Subject:</span> {{ $timetableSlot->subject->name ?? '—' }}</p>
        <p><span class="text-ink-500">Start time:</span> {{ $timetableSlot->start_time ? substr($timetableSlot->start_time, 0, 5) : '—' }}</p>
        <p><span class="text-ink-500">End time:</span> {{ $timetableSlot->end_time ? substr($timetableSlot->end_time, 0, 5) : '—' }}</p>
        <p><span class="text-ink-500">Room:</span> {{ $timetableSlot->room ?? '—' }}</p>
    </div>
@endsection
