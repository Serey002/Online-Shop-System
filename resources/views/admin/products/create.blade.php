@extends('admin.layouts.app')

@section('title', 'Add Product')
@section('page-title', 'Create Catalog Entry')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200 bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-800">New Product Form</h3>
        <p class="text-sm text-gray-500">Input descriptions, setup pricing bounds, and upload item snapshots.</p>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
            </div>

            <div>
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Assign Category Matrix *</label>
                <select name="category_id" id="category_id" required 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
                    <option value="" disabled selected>Choose a category...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price ($ USD) *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 font-medium text-sm pointer-events-none">$</span>
                    <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price') }}" required
                        class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
                </div>
            </div>

            <div>
                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Initial Stock Vault Limit *</label>
                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', 0) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Product Image File</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 file:cursor-pointer cursor-pointer border border-gray-300 rounded-xl p-1">
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Product Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 flex items-center justify-end gap-3">
            <a href="{{ route('products.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-md transition">
                Save Product
            </button>
        </div>
    </form>
</div>
@endsection