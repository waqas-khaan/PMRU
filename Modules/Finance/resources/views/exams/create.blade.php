@extends('layouts.app')

@section('title', 'Add Exam | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Add Exam</h1>
        <a href="{{ route('finance.exams.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-100 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('finance.exams.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="term_id" class="block text-sm font-medium text-ink-700 mb-1">Term <span class="text-red-500">*</span></label>
                    <select name="term_id" id="term_id" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                        <option value="">Select</option>
                        @foreach($terms as $t)
                            <option value="{{ $t->id }}" {{ old('term_id') == $t->id ? 'selected' : '' }}>{{ $t->name }} ({{ $t->academicYear->name ?? '' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-ink-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500" placeholder="e.g. Mid-term, Final">
                </div>
                <div>
                    <label for="exam_date" class="block text-sm font-medium text-ink-700 mb-1">Exam date</label>
                    <input type="date" name="exam_date" id="exam_date" value="{{ old('exam_date') }}" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="total_marks" class="block text-sm font-medium text-ink-700 mb-1">Total marks</label>
                    <input type="number" name="total_marks" id="total_marks" value="{{ old('total_marks') }}" step="0.01" min="0" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="class_name" class="block text-sm font-medium text-ink-700 mb-1">Class (optional)</label>
                    <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="subject_name" class="block text-sm font-medium text-ink-700 mb-1">Subject (optional)</label>
                    <input type="text" name="subject_name" id="subject_name" value="{{ old('subject_name') }}" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Create</button>
                <a href="{{ route('finance.exams.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-600 bg-ink-100 rounded-lg hover:bg-ink-200">Cancel</a>
            </div>
        </form>
    </div>
@endsection
