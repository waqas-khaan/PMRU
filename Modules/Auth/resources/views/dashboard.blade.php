<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | School System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="hidden md:flex md:flex-col w-64 bg-white shadow-lg min-h-screen">
            <div class="px-6 py-6 border-b">
                <h1 class="text-xl font-bold text-blue-700">School System</h1>
                <p class="text-xs text-gray-500 mt-1">User Dashboard</p>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1 text-sm">
                <div class="text-gray-500 uppercase tracking-wide text-xs mb-2">Overview</div>
                <a href="#" class="flex items-center px-3 py-2 rounded-lg bg-blue-50 text-blue-700 font-medium">
                    <span class="material-icons text-sm mr-2">dashboard</span>
                    Dashboard
                </a>

                <div class="text-gray-500 uppercase tracking-wide text-xs mt-4 mb-2">Shortcuts</div>
                <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    Classes
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    Students
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    Exams & Results
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    Fees & Finance
                </a>
            </nav>

            <div class="px-4 py-4 border-t text-xs text-gray-500">
                Logged in as
                <div class="font-semibold text-gray-800 truncate">
                    {{ auth()->user()->name }}
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="flex-1">
            {{-- Top bar --}}
            <header class="flex items-center justify-between bg-white px-4 md:px-8 py-4 shadow">
                <div>
                    <h2 class="text-lg md:text-2xl font-bold text-gray-800">Welcome back, {{ auth()->user()->name }} </h2>
                    <p class="text-xs md:text-sm text-gray-500">
                        Roles:
                        <span class="font-medium text-gray-700">
                            {{ implode(', ', auth()->user()->roles->pluck('name')->toArray()) ?: 'No role assigned' }}
                        </span>
                    </p>
                </div>

                <div class="flex items-center space-x-3">
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-1"
                        >
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- Page content --}}
            <section class="px-4 md:px-8 py-6 md:py-8 space-y-6">
                {{-- Stats cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Today</p>
                        <p class="text-2xl font-bold text-gray-800">Good day!</p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ now()->format('d M Y') }}
                        </p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Your role</p>
                        <p class="text-lg font-semibold text-gray-800">
                            {{ auth()->user()->roles->pluck('name')->first() ?? 'User' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Access is based on your assigned role.
                        </p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Notifications</p>
                        <p class="text-2xl font-bold text-gray-800">0</p>
                        <p class="text-xs text-gray-400 mt-1">No new alerts.</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Quick tip</p>
                        <p class="text-xs text-gray-600">
                            Use this dashboard as the central place to access all school modules.
                        </p>
                    </div>
                </div>

                {{-- Two-column layout --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    {{-- Left: quick actions --}}
                    <div class="lg:col-span-2 space-y-4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-gray-800">Quick actions</h3>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs">
                                <button class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium py-3 rounded-lg">
                                    View classes
                                </button>
                                <button class="w-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-medium py-3 rounded-lg">
                                    Manage students
                                </button>
                                <button class="w-full bg-orange-50 hover:bg-orange-100 text-orange-700 font-medium py-3 rounded-lg">
                                    Exams & results
                                </button>
                                <button class="w-full bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium py-3 rounded-lg">
                                    Fees & payments
                                </button>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-gray-800">Recent activity</h3>
                                <span class="text-xs text-gray-400">Demo data</span>
                            </div>
                            <ul class="space-y-3 text-xs">
                                <li class="flex items-start justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">You logged in</p>
                                        <p class="text-gray-500">Welcome to the school system dashboard.</p>
                                    </div>
                                    <span class="text-gray-400 text-[11px]">Just now</span>
                                </li>
                                <li class="flex items-start justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Role-based access</p>
                                        <p class="text-gray-500">Pages and actions will respect your assigned roles.</p>
                                    </div>
                                    <span class="text-gray-400 text-[11px]">Info</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Right: profile summary --}}
                    <div class="space-y-4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                            <h3 class="text-sm font-semibold text-gray-800 mb-3">Profile summary</h3>
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="h-10 w-10 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold">
                                    {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            <dl class="space-y-2 text-xs">
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Roles</dt>
                                    <dd class="font-medium text-gray-800 text-right">
                                        {{ implode(', ', auth()->user()->roles->pluck('name')->toArray()) ?: 'No role assigned' }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Member since</dt>
                                    <dd class="font-medium text-gray-800">
                                        {{ auth()->user()->created_at?->format('d M Y') ?? '—' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-xs text-blue-900">
                            <h4 class="font-semibold mb-1">Next steps</h4>
                            <p>
                                Connect this dashboard with students, academics, and finance modules
                                to give each role quick access to what they need.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>