@extends('admin.layouts.app')

@section('title', 'Manage Products')
@section('page-title', 'Product Catalog')

@section('content')
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50/50">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Master Inventory</h3>
            <p class="text-sm text-gray-500">View, monitor, and handle your retail store goods.</p>
        </div>
        <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white font-medium text-sm px-4 py-2.5 rounded-xl shadow-sm hover:bg-indigo-700 transition self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i> Add New Product
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 font-semibold text-xs uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4">Item Details</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Price</th>
                    <th class="px-6 py-4">Stock Levels</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700 font-medium">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 border border-gray-200">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-50">
                                        <i class="fa-solid fa-image text-lg"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <span class="text-gray-900 font-bold block text-base">{{ $product->name }}</span>
                                <span class="text-gray-400 font-mono text-xs block mt-0.5">ID: #{{ $product->id }}</span>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <span class="bg-indigo-50 text-indigo-700 border border-indigo-100 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $product->category->name ?? 'Unassigned' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-gray-900 font-bold text-base">
                            ${{ number_format($product->price, 2) }}
                        </td>

                        <td class="px-6 py-4">
                            @if($product->stock > 10)
                                <span class="text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $product->stock }} Available
                                </span>
                            @elseif($product->stock > 0)
                                <span class="text-amber-700 bg-amber-50 border border-amber-100 px-2.5 py-1 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Low Stock ({{ $product->stock }})
                                </span>
                            @else
                                <span class="text-rose-700 bg-rose-50 border border-rose-100 px-2.5 py-1 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Sold Out
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold transition flex items-center gap-1">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i> Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Permanently remove this item from inventory?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-900 font-semibold transition flex items-center gap-1">
                                        <i class="fa-solid fa-trash text-xs"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                            <i class="fa-solid fa-box-open text-5xl block mb-4 text-gray-300"></i>
                            Your product inventory registry is empty.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection