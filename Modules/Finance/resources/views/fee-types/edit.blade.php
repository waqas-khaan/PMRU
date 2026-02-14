@extends('layouts.app')

@section('title', 'Edit Fee Type | ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Edit Fee Type</h1>
        <a href="{{ route('finance.fee-types.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium">← Back to list</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-ink-200/80 p-6">
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-100 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('finance.fee-types.update', $feeType) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-ink-700 mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $feeType->name) }}" required class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
            </div>
            <div>
                <label for="code" class="block text-sm font-medium text-ink-700 mb-1">Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', $feeType->code) }}" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-ink-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="2" class="w-full px-3 py-2 border border-ink-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500">{{ old('description', $feeType->description) }}</textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600">Update</button>
                <a href="{{ route('finance.fee-types.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink-600 bg-ink-100 rounded-lg hover:bg-ink-200">Cancel</a>
            </div>
        </form>
    </div>
@endsection
