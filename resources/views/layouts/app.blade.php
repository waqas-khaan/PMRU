<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
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
    <style>body { font-family: 'Inter', system-ui, sans-serif; }</style>
    @stack('styles')
</head>
<body class="bg-ink-50 min-h-screen text-ink-800 antialiased flex">
    {{-- Sidebar: shown on all pages (desktop) --}}
    <aside class="hidden lg:flex lg:flex-col lg:w-56 lg:fixed lg:inset-y-0 lg:z-30 bg-white border-r border-ink-200/90">
        <div class="flex items-center gap-2.5 px-4 h-14 border-b border-ink-200/80 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-ink-800 flex items-center justify-center text-white text-sm font-semibold shrink-0">P</div>
                <span class="font-semibold text-ink-900 text-sm truncate" title="PMRU">PMRU</span>
            </a>
        </div>
        <nav class="flex-1 px-3 py-4 space-y-0.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'text-ink-900 bg-ink-100' : 'text-ink-600 hover:text-ink-900 hover:bg-ink-100' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>
            @if(Route::has('students.index'))
            <a href="{{ route('students.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('students.index') || request()->routeIs('students.edit') || request()->routeIs('students.show') ? 'text-ink-900 bg-ink-100' : 'text-ink-600 hover:text-ink-900 hover:bg-ink-100' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Students
            </a>
            @if(Route::has('students.create'))
            <a href="{{ route('students.create') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('students.create') ? 'text-ink-900 bg-ink-100' : 'text-ink-600 hover:text-ink-900 hover:bg-ink-100' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add student
            </a>
            @endif
            @endif
        </nav>
        <div class="p-3 border-t border-ink-200/80 shrink-0">
            @auth
            <p class="px-3 py-1.5 text-xs font-medium text-ink-500 truncate" title="{{ auth()->user()->name ?? auth()->user()->email }}">{{ auth()->user()->name ?? auth()->user()->email }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 mt-1 text-sm font-medium text-ink-600 hover:text-ink-900 hover:bg-ink-100 rounded-md transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Log out
                </button>
            </form>
            @else
            <a href="{{ url('/') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-accent-600 hover:text-accent-700 hover:bg-ink-100 rounded-md transition-colors">← Home</a>
            @endauth
        </div>
    </aside>

    {{-- Top bar (mobile/tablet when sidebar hidden) --}}
    <header class="lg:hidden bg-white border-b border-ink-200/90 sticky top-0 z-20 w-full">
        <div class="px-4 sm:px-6 h-14 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-ink-800 flex items-center justify-center text-white text-sm font-semibold">P</div>
                <span class="font-semibold text-ink-900 text-sm">PMRU</span>
            </a>
            <nav class="flex items-center gap-1">
                <a href="{{ route('dashboard') }}" class="px-3 py-1.5 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'text-ink-900 bg-ink-100' : 'text-ink-600 hover:bg-ink-100' }}">Dashboard</a>
                @if(Route::has('students.index'))
                <a href="{{ route('students.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-md {{ request()->routeIs('students.index') || request()->routeIs('students.edit') || request()->routeIs('students.show') ? 'text-ink-900 bg-ink-100' : 'text-ink-600 hover:bg-ink-100' }}">Students</a>
                @endif
            </nav>
            @auth
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-ink-600 hover:text-ink-900 hover:bg-ink-100 rounded-md">Log out</button>
            </form>
            @else
            <a href="{{ url('/') }}" class="text-sm font-medium text-accent-600 hover:text-accent-700">← Home</a>
            @endauth
        </div>
    </header>

    <main class="flex-1 min-w-0 lg:pl-56">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8">
            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>
</html>
