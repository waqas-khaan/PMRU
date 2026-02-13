@extends('layouts.app')

@section('title', 'Edit Student | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Edit Student</h1>
        <a href="{{ route('students.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-100 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('students.update', $student->id) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="full_name" class="block text-sm font-medium text-ink-700 mb-1">Full name <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $student->name) }}" required
                           class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-ink-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}"
                           class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-ink-700 mb-1">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}"
                           class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-ink-700 mb-1">Date of birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="gender" class="block text-sm font-medium text-ink-700 mb-1">Gender</label>
                    <select name="gender" id="gender" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                        <option value="">Select</option>
                        <option value="male" {{ old('gender', $student->gender) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $student->gender) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $student->gender) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="block text-sm font-medium text-ink-700 mb-1">Address</label>
                    <textarea name="address" id="address" rows="2" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">{{ old('address', $student->address) }}</textarea>
                </div>
                <div>
                    <label for="class" class="block text-sm font-medium text-ink-700 mb-1">Class</label>
                    <input type="text" name="class" id="class" value="{{ old('class', $student->class) }}" placeholder="e.g. 10"
                           class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div>
                    <label for="section" class="block text-sm font-medium text-ink-700 mb-1">Section</label>
                    <input type="text" name="section" id="section" value="{{ old('section', $student->section) }}" placeholder="e.g. A"
                           class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                <div class="sm:col-span-2">
                    <label for="enrollment_date" class="block text-sm font-medium text-ink-700 mb-1">Enrollment date</label>
                    <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date', $student->enrollment_date?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                </div>
                @if(isset($guardians) && $guardians->isNotEmpty())
                <div class="sm:col-span-2">
                    <label for="guardian_id" class="block text-sm font-medium text-ink-700 mb-1">Guardian</label>
                    <select name="guardian_id" id="guardian_id" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                        <option value="">None</option>
                        @foreach($guardians as $guardian)
                            <option value="{{ $guardian->id }}" {{ old('guardian_id', $student->guardian_id) == $guardian->id ? 'selected' : '' }}>{{ $guardian->name }} ({{ $guardian->relationship ?? 'Guardian' }})</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-4 py-2 bg-accent-500 text-white font-medium rounded-lg hover:bg-accent-600 focus:ring-2 focus:ring-accent-500 focus:ring-offset-1">
                    Update Student
                </button>
                <a href="{{ route('students.index') }}" class="px-4 py-2 border border-ink-300 text-ink-700 font-medium rounded-lg hover:bg-ink-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
