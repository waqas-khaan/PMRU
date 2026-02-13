
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students | School System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Students Module</h1>
                <p class="text-sm text-gray-500 mt-1">Manage and view students.</p>
            </div>
            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                ← Back to home
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Student list</h2>
                <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Add student
                </a>
            </div>
            @if($students->isEmpty())
                <p class="text-sm text-gray-500">No students yet. Use "Add student" to create one.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-700">Name</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-700">Email</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-700">Class</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-700">Phone</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $student)
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-800">{{ $student->name }}</td>
                                    <td class="px-4 py-2 text-gray-600">{{ $student->email ?? '—' }}</td>
                                    <td class="px-4 py-2 text-gray-600">{{ $student->class ? $student->class . ($student->section ? ' ' . $student->section : '') : '—' }}</td>
                                    <td class="px-4 py-2 text-gray-600">{{ $student->phone ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

<x-students::layouts.master>
    <h1>Hello World</h1>

    <p>Module: {!! config('students.name') !!}</p>
</x-students::layouts.master>

