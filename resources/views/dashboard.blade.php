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
        <aside class="hidden md:flex md:flex-col w-64 bg-white shadow-lg min-h-screen">
            <div class="px-6 py-6 border-b">
                <h1 class="text-xl font-bold text-blue-700">School System</h1>
                <p class="text-xs text-gray-500 mt-1">Dashboard</p>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1 text-sm">
                <div class="text-gray-500 uppercase tracking-wide text-xs mb-2">Overview</div>
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded-lg bg-blue-50 text-blue-700 font-medium">
                    <span class="mr-2">📊</span>
                    Dashboard
                </a>

                <div class="text-gray-500 uppercase tracking-wide text-xs mt-4 mb-2">Modules</div>
                <a href="{{ route('students.index') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    <span class="mr-2">👥</span>
                    Students
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    Classes
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    Exams & Results
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    Fees & Finance
                </a>
            </nav>

            <div class="px-4 py-4 border-t text-xs text-gray-500">
                <a href="{{ url('/') }}" class="text-blue-600 hover:underline">← Back to home</a>
            </div>
        </aside>

        <main class="flex-1">
            <header class="flex items-center justify-between bg-white px-4 md:px-8 py-4 shadow">
                <div>
                    <h2 class="text-lg md:text-2xl font-bold text-gray-800">Dashboard</h2>
                    <p class="text-xs md:text-sm text-gray-500">
                        Access school modules from the sidebar.
                    </p>
                </div>
                <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-1">
                        Logout
                    </button>
                </form>
            </header>

            <section class="px-4 md:px-8 py-6 md:py-8 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('students.index') }}" class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:border-blue-200 hover:shadow-md transition-all block">
                        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Module</p>
                        <p class="text-lg font-bold text-gray-800">Students</p>
                        <p class="text-xs text-gray-400 mt-1">Manage and add students</p>
                    </a>
                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Today</p>
                        <p class="text-2xl font-bold text-gray-800">Good day!</p>
                        <p class="text-xs text-gray-400 mt-1">{{ now()->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Quick tip</p>
                        <p class="text-xs text-gray-600">
                            Use the sidebar to open the Students module and other sections.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <h3 class="text-sm font-semibold text-gray-800 mb-3">Quick actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs">
                        <a href="{{ route('students.index') }}" class="w-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-medium py-3 rounded-lg text-center">
                            Manage students
                        </a>
                        <a href="{{ route('students.create') }}" class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium py-3 rounded-lg text-center">
                            Add student
                        </a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
