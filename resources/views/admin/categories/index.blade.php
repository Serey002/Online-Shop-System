@extends('admin.layouts.app')

@section('title', 'Manage Categories')
@section('page-title', 'Category Matrix')

@section('content')
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between bg-gray-50/50">
        <div>
            <h3 class="text-lg font-bold text-gray-800">All Product Categories</h3>
            <p class="text-sm text-gray-500">Create, adjust, or delete organizational groups for items.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white font-medium text-sm px-4 py-2.5 rounded-xl shadow-sm hover:bg-indigo-700 transition">
            <i class="fa-solid fa-plus"></i> Add New Category
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 font-semibold text-xs uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4">Database ID</th>
                    <th class="px-6 py-4">Category Name</th>
                    <th class="px-6 py-4">URL Slug Sequence</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700 font-medium">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 font-mono text-gray-400">#{{ $category->id }}</td>
                        <td class="px-6 py-4 text-gray-900 font-semibold">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-500"><span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-md border text-xs font-mono">{{ $category->slug }}</span></td>
                        <td class="px-6 py-4 text-right flex items-center justify-end gap-3">
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold transition flex items-center gap-1">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this category? All attached products will be removed too!');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-900 font-semibold transition flex items-center gap-1">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                            <i class="fa-solid fa-folder-open text-4xl block mb-3 text-gray-300"></i>
                            No category data has been loaded into your database yet. Run seeders or create one!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection