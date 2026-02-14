@extends('layouts.app')

@section('title', 'Academics | ' . config('app.name'))

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Academics</h1>
        <p class="text-sm text-ink-500 mt-1">Academic years, terms, classes, sections, subjects and timetable.</p>
    </div>

    @if (!$hasAcademicsDb)
        <div class="mb-4 p-4 rounded-lg bg-amber-50 border border-amber-200 text-sm text-amber-800">
            Run migrations first: <code class="bg-amber-100 px-1 rounded">php artisan migrate --database=mysql_academics --path=Modules/Academics/database/migrations</code>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('academics.academic-years.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Academic Years</h2>
            <p class="text-sm text-ink-500 mt-1">e.g. 2024-2025</p>
        </a>
        <a href="{{ route('academics.terms.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Terms</h2>
            <p class="text-sm text-ink-500 mt-1">Semesters within an academic year</p>
        </a>
        <a href="{{ route('academics.school-classes.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Classes</h2>
            <p class="text-sm text-ink-500 mt-1">Class 1, Grade 10, etc.</p>
        </a>
        <a href="{{ route('academics.sections.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Sections</h2>
            <p class="text-sm text-ink-500 mt-1">A, B, C per class</p>
        </a>
        <a href="{{ route('academics.subjects.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Subjects</h2>
            <p class="text-sm text-ink-500 mt-1">Math, Science, English</p>
        </a>
        <a href="{{ route('academics.class-subjects.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Class–Subjects</h2>
            <p class="text-sm text-ink-500 mt-1">Which subjects per class</p>
        </a>
        <a href="{{ route('academics.timetable-slots.index') }}" class="block p-4 bg-white rounded-xl shadow-sm border border-ink-200/80 hover:border-accent-300 hover:shadow transition">
            <h2 class="font-semibold text-ink-900">Timetable Slots</h2>
            <p class="text-sm text-ink-500 mt-1">Day, period, class, section, subject</p>
        </a>
    </div>
@endsection
