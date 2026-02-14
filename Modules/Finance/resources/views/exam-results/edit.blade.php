@extends('layouts.app')

@section('title', 'Edit Exam Result | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Edit Exam Result</h1>
        <a href="{{ route('finance.exam-results.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-100 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('finance.exam-results.update', $examResult) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="exam_id" class="block text-sm font-medium text-ink-700 mb-1">Exam <span class="text-red-500">*</span></label>
                    <select name="exam_id" id="exam_id" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                        @foreach($exams as $e)
                            <option value="{{ $e->id }}" {{ old('exam_id', $examResult->exam_id) == $e->id ? 'selected' : '' }}>{{ $e->name }} ({{ $e->term->name ?? '' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="student_id" class="block text-sm font-medium text-ink-700 mb-1">Student ID <span class="text-red-500">*</span></label>
                    <input type="number" name="student_id" id="student_id" value="{{ old('student_id', $examResult->student_id) }}" min="1" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="marks" class="block text-sm font-medium text-ink-700 mb-1">Marks <span class="text-red-500">*</span></label>
                    <input type="number" name="marks" id="marks" value="{{ old('marks', $examResult->marks) }}" step="0.01" min="0" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="grade" class="block text-sm font-medium text-ink-700 mb-1">Grade</label>
                    <input type="text" name="grade" id="grade" value="{{ old('grade', $examResult->grade) }}" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div class="sm:col-span-2">
                    <label for="remarks" class="block text-sm font-medium text-ink-700 mb-1">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="2" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">{{ old('remarks', $examResult->remarks) }}</textarea>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Update</button>
                <a href="{{ route('finance.exam-results.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-600 bg-ink-100 rounded-lg hover:bg-ink-200">Cancel</a>
            </div>
        </form>
    </div>
@endsection
