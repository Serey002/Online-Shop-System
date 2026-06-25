@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Modify Catalog Item')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200 bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-800">Edit Product Profile</h3>
        <p class="text-sm text-gray-500">Update naming descriptions, fix price margins, or change product images.</p>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
            </div>

            <div>
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Category Matrix *</label>
                <select name="category_id" id="category_id" required 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price ($ USD) *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 font-medium text-sm pointer-events-none">$</span>
                    <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required
                        class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
                </div>
            </div>

            <div>
                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Stock Vault Limit *</label>
                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $product->stock) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Replace Product Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 file:cursor-pointer cursor-pointer border border-gray-300 rounded-xl p-1">
            </div>

            <div class="md:col-span-2 flex flex-col gap-2">
                <span class="block text-sm font-semibold text-gray-700">Active Live Image Asset Preview</span>
                <div class="w-28 h-28 border rounded-2xl bg-gray-50 overflow-hidden shadow-inner flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Current Product Preview" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400 text-xs text-center p-2">No product image uploaded</span>
                    @endif
                </div>
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Product Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 flex items-center justify-end gap-3">
            <a href="{{ route('products.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition">
                Cancel Changes
            </a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-md transition">
                Apply Updates
            </button>
        </div>
    </form>
</div>
@endsection