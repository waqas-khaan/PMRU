@extends('layouts.app')

@section('title', 'Add Timetable Slot | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Add Timetable Slot</h1>
        <a href="{{ route('academics.timetable-slots.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-100 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('academics.timetable-slots.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="class_id" class="block text-sm font-medium text-ink-700 mb-1">Class <span class="text-red-500">*</span></label>
                    <select name="class_id" id="class_id" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                        <option value="">Select</option>
                        @foreach($schoolClasses as $c)
                            <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="section_id" class="block text-sm font-medium text-ink-700 mb-1">Section <span class="text-red-500">*</span></label>
                    <select name="section_id" id="section_id" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                        <option value="">Select</option>
                        @foreach($schoolClasses as $c)
                            @foreach($c->sections as $sec)
                                <option value="{{ $sec->id }}" data-class="{{ $c->id }}" {{ old('section_id') == $sec->id ? 'selected' : '' }}>{{ $c->name }} – {{ $sec->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="subject_id" class="block text-sm font-medium text-ink-700 mb-1">Subject <span class="text-red-500">*</span></label>
                    <select name="subject_id" id="subject_id" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                        <option value="">Select</option>
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" {{ old('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="day_of_week" class="block text-sm font-medium text-ink-700 mb-1">Day of week <span class="text-red-500">*</span></label>
                    <select name="day_of_week" id="day_of_week" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                        <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Monday</option>
                        <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Tuesday</option>
                        <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Wednesday</option>
                        <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Thursday</option>
                        <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Friday</option>
                        <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Saturday</option>
                        <option value="7" {{ old('day_of_week') == '7' ? 'selected' : '' }}>Sunday</option>
                    </select>
                </div>
                <div>
                    <label for="period" class="block text-sm font-medium text-ink-700 mb-1">Period <span class="text-red-500">*</span></label>
                    <input type="number" name="period" id="period" value="{{ old('period') }}" min="1" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-ink-700 mb-1">Start time (HH:MM)</label>
                    <input type="text" name="start_time" id="start_time" value="{{ old('start_time') }}" placeholder="09:00" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-ink-700 mb-1">End time (HH:MM)</label>
                    <input type="text" name="end_time" id="end_time" value="{{ old('end_time') }}" placeholder="09:45" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div class="sm:col-span-2">
                    <label for="room" class="block text-sm font-medium text-ink-700 mb-1">Room</label>
                    <input type="text" name="room" id="room" value="{{ old('room') }}" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Create</button>
                <a href="{{ route('academics.timetable-slots.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-600 bg-ink-100 rounded-lg hover:bg-ink-200">Cancel</a>
            </div>
        </form>
    </div>
@endsection
