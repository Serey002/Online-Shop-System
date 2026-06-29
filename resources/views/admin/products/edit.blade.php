@extends('admin.layouts.app')

@section('title', 'Modify Product Details')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Edit Product</h2>
    <p class="text-sm text-gray-400 mt-0.5">Update item info for item entry registry record #{{ $product->id }}MT.</p>
</div>

<div class="max-w-3xl bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl">
                <ul class="text-xs text-rose-600 font-semibold list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Item Display Title *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                    class="w-full px-4 py-3 bg-[#F4F5F7] border-0 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition font-semibold text-gray-800">
            </div>

            <div>
                <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Food Category Matrix *</label>
                <select name="category_id" id="category_id" required 
                    class="w-full px-4 py-3 bg-[#F4F5F7] border-0 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition font-semibold text-gray-600">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="price" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Price ($ USD Margin) *</label>
                <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required
                    class="w-full px-4 py-3 bg-[#F4F5F7] border-0 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition font-semibold text-gray-800">
            </div>

            <div>
                <label for="stock" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Stock Inventory Units *</label>
                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $product->stock) }}" required
                    class="w-full px-4 py-3 bg-[#F4F5F7] border-0 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition font-semibold text-gray-800">
            </div>

            <div>
                <label for="image_url" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Product Image Link URL</label>
                <input type="url" name="image_url" id="image_url" placeholder="https://example.com/food-image.jpg" value="{{ old('image_url', filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : '') }}"
                    class="w-full px-4 py-3 bg-[#F4F5F7] border-0 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition font-semibold text-gray-800">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Or Upload File Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 border-0 bg-[#F4F5F7] p-2 rounded-xl cursor-pointer">
            </div>

            <div class="md:col-span-2 flex flex-col gap-2">
                <span class="block text-xs font-bold uppercase tracking-wider text-gray-400">Current Image Snapshot Preview</span>
                <div class="w-24 h-24 rounded-2xl bg-gray-50 overflow-hidden border border-gray-100 shadow-inner flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image) }}" alt="Preview" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-300 text-[10px] uppercase font-bold">No Image</span>
                    @endif
                </div>
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Product Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 bg-[#F4F5F7] border-0 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition font-semibold text-gray-800">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <div class="pt-5 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('products.index') }}" class="px-5 py-3 bg-gray-100 text-gray-600 font-bold text-xs rounded-xl hover:bg-gray-200 transition uppercase tracking-wider">Cancel Changes</a>
            <button type="submit" class="px-5 py-3 bg-orange-600 text-white font-bold text-xs rounded-xl shadow-sm hover:bg-orange-700 transition uppercase tracking-wider">Apply updates</button>
        </div>
    </form>
</div>
@endsection