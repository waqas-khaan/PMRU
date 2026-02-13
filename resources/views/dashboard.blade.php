<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        ink: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a' },
                        accent: { 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .stat-card { transition: box-shadow 0.15s ease; }
        .stat-card:hover { box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06); }
        .module-card { transition: border-color 0.15s ease, box-shadow 0.15s ease; }
        .module-card:hover { border-color: #e2e8f0; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05); }
    </style>
</head>
<body class="bg-ink-50 min-h-screen text-ink-800 antialiased">
    <!-- Top bar -->
    <header class="bg-white border-b border-ink-200/90 sticky top-0 z-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-ink-800 flex items-center justify-center text-white text-sm font-semibold">
                        {{ strtoupper(substr(config('app.name'), 0, 1)) }}
                    </div>
                    <span class="font-semibold text-ink-900 text-sm hidden sm:block">{{ config('app.name') }}</span>
                </a>
                <nav class="flex items-center gap-1">
                    <a href="{{ route('dashboard') }}" class="px-3 py-1.5 text-sm font-medium text-ink-900 bg-ink-100 rounded-md">Dashboard</a>
                    @if(Route::has('students.index'))
                    <a href="{{ route('students.index') }}" class="px-3 py-1.5 text-sm font-medium text-ink-600 hover:text-ink-900 hover:bg-ink-100 rounded-md transition-colors">Students</a>
                    @endif
                </nav>
            </div>
            @auth
            <div class="flex items-center gap-2">
                <span class="text-sm text-ink-500 max-w-[140px] truncate hidden sm:block" title="{{ auth()->user()->name ?? auth()->user()->email }}">{{ auth()->user()->name ?? auth()->user()->email }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-ink-600 hover:text-ink-900 hover:bg-ink-100 rounded-md transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Log out
                    </button>
                </form>
            </div>
            @else
            <a href="{{ url('/') }}" class="text-sm font-medium text-accent-600 hover:text-accent-700">← Home</a>
            @endauth
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-8">
        <!-- Greeting -->
        @auth
        <div class="mb-8">
            <h1 class="text-xl font-semibold text-ink-900">
                {{ now()->format('G') < 12 ? 'Good morning' : (now()->format('G') < 17 ? 'Good afternoon' : 'Good evening') }},
                {{ explode(' ', auth()->user()->name ?? 'User')[0] ?? 'User' }}
            </h1>
            <p class="text-sm text-ink-500 mt-0.5">Here’s an overview of your school.</p>
        </div>
        @endauth

        <!-- Stats -->
        <section class="mb-8">
            <h2 class="text-xs font-semibold text-ink-500 uppercase tracking-wider mb-3">Overview</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="stat-card bg-white rounded-lg border border-ink-200/80 p-4">
                    <p class="text-sm font-medium text-ink-500">Total students</p>
                    <p class="text-2xl font-semibold text-ink-900 mt-1">{{ $studentCount ?? 0 }}</p>
                </div>
                <div class="stat-card bg-white rounded-lg border border-ink-200/80 p-4 opacity-90">
                    <p class="text-sm font-medium text-ink-500">Classes</p>
                    <p class="text-2xl font-semibold text-ink-400 mt-1">—</p>
                </div>
                <div class="stat-card bg-white rounded-lg border border-ink-200/80 p-4 opacity-90">
                    <p class="text-sm font-medium text-ink-500">Attendance today</p>
                    <p class="text-2xl font-semibold text-ink-400 mt-1">—</p>
                </div>
            </div>
        </section>

        <!-- Modules & quick actions -->
        <section>
            <h2 class="text-xs font-semibold text-ink-500 uppercase tracking-wider mb-3">Modules</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @if(Route::has('students.index'))
                <div class="module-card bg-white rounded-lg border border-ink-200/80 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-ink-100 text-ink-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-ink-900">Students</h3>
                                <p class="text-sm text-ink-500 mt-0.5">Records, enrollments, and guardians</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-ink-100">
                        <a href="{{ route('students.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-ink-700 bg-ink-100 hover:bg-ink-200 rounded-md transition-colors">
                            View all
                        </a>
                        <a href="{{ route('students.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-white bg-accent-500 hover:bg-accent-600 rounded-md transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Add student
                        </a>
                    </div>
                </div>
                @endif

                <div class="module-card bg-white rounded-lg border border-ink-200/60 border-dashed p-5 flex flex-col justify-center min-h-[120px]">
                    <div class="flex items-center gap-3 text-ink-400">
                        <div class="w-10 h-10 rounded-lg bg-ink-100/80 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-ink-400">More modules</p>
                            <p class="text-sm text-ink-400/80">Classes, attendance, finance — coming soon</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick tip (compact) -->
        <p class="mt-8 text-xs text-ink-400">
            Use <strong class="text-ink-500">Students</strong> to manage records. Log out from the top right when finished.
        </p>
    </main>
</body>
</html>
