@extends('admin.layouts.app')

@section('title', 'Food Categories')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Categories</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage classification structures for your food menu items.</p>
    </div>
    <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 bg-orange-600 text-white font-bold text-sm px-5 py-3 rounded-xl shadow-sm hover:bg-orange-700 transition tracking-wide">
        <i class="fa-solid fa-plus text-xs"></i> Add new category
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-400 font-bold text-[11px] uppercase tracking-wider border-b border-gray-100 bg-gray-50/50">
                    <th class="px-6 py-4">Category Name</th>
                    <th class="px-6 py-4">URL Route Slug</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs text-gray-600 font-semibold">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50/40 transition group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center border border-orange-100">
                                    <i class="fa-solid fa-utensils"></i>
                                </div>
                                <span class="text-gray-900 font-bold text-sm group-hover:text-orange-600 transition">{{ $category->name }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-5 font-mono text-gray-400">
                            /categories/{{ $category->slug }}
                        </td>

                        <td class="px-6 py-5">
                            <span class="text-orange-600 bg-orange-50 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">Active Collection</span>
                        </td>

                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-3 text-sm">
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-gray-400 hover:text-gray-900 transition p-1">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this food category structure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-gray-400 hover:text-rose-600 transition p-1">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-gray-400 font-medium">
                            <i class="fa-solid fa-layer-group text-4xl block mb-3 text-gray-200"></i>
                            No categories found in registry database.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection