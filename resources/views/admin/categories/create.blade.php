@extends('admin.layouts.app')

@section('title', 'Create Category')
@section('page-title', 'Add New Category')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200 bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-800">New Category Structure</h3>
        <p class="text-sm text-gray-500">Define classification titles and clean URL path slug strings for your products.</p>
    </div>

    <form action="{{ route('categories.store') }}" method="POST" class="p-6 space-y-6">
        @csrf

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3">
                <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 text-lg"></i>
                <ul class="text-sm text-rose-700 font-medium list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-5">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Category Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g., Electronic Devices"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
            </div>

            <div>
                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">URL Route Slug *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 font-mono text-xs pointer-events-none">/categories/</span>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required placeholder="electronic-devices"
                        class="w-full pl-24 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm font-mono">
                </div>
                <p class="text-xs text-gray-400 mt-1.5 pl-1">
                    <i class="fa-solid fa-info-circle"></i> Use lowercase letters, numbers, and hyphens only (no spaces).
                </p>
            </div>
        </div>

        <div class="pt-5 border-t border-gray-200 flex items-center justify-end gap-3">
            <a href="{{ route('categories.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-md transition">
                Create Category
            </button>
        </div>
    </form>
</div>

<script>
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    nameInput.addEventListener('input', function() {
        if (!slugInput.dataset.edited) {
            slugInput.value = nameInput.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Clear invalid chars
                .replace(/\s+/g, '-')         // Convert spaces to hyphens
                .replace(/-+/g, '-');         // Deduplicate multiple hyphens
        }
    });

    slugInput.addEventListener('input', function() {
        slugInput.dataset.edited = true;
    });
</script>
@endsection