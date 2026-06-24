@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Modify Category Group')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200 bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-800">Edit Category Attributes</h3>
        <p class="text-sm text-gray-500">Update descriptive naming attributes or change routing structure values.</p>
    </div>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

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
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
            </div>

            <div>
                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">URL Route Slug *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 font-mono text-xs pointer-events-none">/categories/</span>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" required
                        class="w-full pl-24 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm font-mono">
                </div>
            </div>
        </div>

        <div class="pt-5 border-t border-gray-200 flex items-center justify-end gap-3">
            <a href="{{ route('categories.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition">
                Cancel Changes
            </a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-md transition">
                Apply Updates
            </button>
        </div>
    </form>
</div>
@endsection