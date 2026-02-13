@extends('layouts.app')

@section('title', 'Dashboard | ' . config('app.name'))

@section('content')
    @auth
    <div class="mb-8">
        <h1 class="text-xl font-semibold text-ink-900">
            {{ now()->format('G') < 12 ? 'Good morning' : (now()->format('G') < 17 ? 'Good afternoon' : 'Good evening') }},
            {{ explode(' ', auth()->user()->name ?? 'User')[0] ?? 'User' }}
        </h1>
        <p class="text-sm text-ink-500 mt-0.5">Here’s an overview of your school.</p>
    </div>
    @endauth

    <section class="mb-8">
        <h2 class="text-xs font-semibold text-ink-500 uppercase tracking-wider mb-3">Overview</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg border border-ink-200/80 p-4">
                <p class="text-sm font-medium text-ink-500">Total students</p>
                <p class="text-2xl font-semibold text-ink-900 mt-1">{{ $studentCount ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-lg border border-ink-200/80 p-4 opacity-90">
                <p class="text-sm font-medium text-ink-500">Classes</p>
                <p class="text-2xl font-semibold text-ink-400 mt-1">—</p>
            </div>
            <div class="bg-white rounded-lg border border-ink-200/80 p-4 opacity-90">
                <p class="text-sm font-medium text-ink-500">Attendance today</p>
                <p class="text-2xl font-semibold text-ink-400 mt-1">—</p>
            </div>
        </div>
    </section>

    <section>
        <h2 class="text-xs font-semibold text-ink-500 uppercase tracking-wider mb-3">Modules</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @if(Route::has('students.index'))
            <div class="bg-white rounded-lg border border-ink-200/80 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-ink-100 text-ink-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-ink-900">Students</h3>
                        <p class="text-sm text-ink-500 mt-0.5">Records, enrollments, and guardians</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-ink-100">
                    <a href="{{ route('students.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-ink-700 bg-ink-100 hover:bg-ink-200 rounded-md">View all</a>
                    <a href="{{ route('students.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-white bg-accent-500 hover:bg-accent-600 rounded-md">Add student</a>
                </div>
            </div>
            @endif
            <div class="bg-white rounded-lg border border-ink-200/60 border-dashed p-5 flex flex-col justify-center min-h-[120px] text-ink-400">
                <p class="font-medium">More modules</p>
                <p class="text-sm mt-0.5">Classes, attendance, finance — coming soon</p>
            </div>
        </div>
    </section>
@endsection
