@extends('layouts.app')

@section('title', 'Edit Academic Year | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Edit Academic Year</h1>
        <a href="{{ route('finance.academic-years.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-100 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('finance.academic-years.update', $academicYear) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-ink-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $academicYear->name) }}" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-medium text-ink-700 mb-1">Start date <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $academicYear->start_date->format('Y-m-d')) }}" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-ink-700 mb-1">End date <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $academicYear->end_date->format('Y-m-d')) }}" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_current" value="1" {{ old('is_current', $academicYear->is_current) ? 'checked' : '' }} class="rounded border-ink-300 text-accent-600 focus:ring-accent-500">
                        <span class="text-sm font-medium text-ink-700">Current academic year</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Update</button>
                <a href="{{ route('finance.academic-years.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-600 bg-ink-100 rounded-lg hover:bg-ink-200">Cancel</a>
            </div>
        </form>
    </div>
@endsection
