@extends('admin.layouts.app')

@section('title', 'Add New Category')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Create Category</h2>
    <p class="text-sm text-gray-400 mt-0.5">Define a primary food classification tier.</p>
</div>

<div class="max-w-2xl bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <form action="{{ route('categories.store') }}" method="POST" class="p-6 space-y-6">
        @csrf

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl">
                <ul class="text-xs text-rose-600 font-semibold list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-5">
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Category Title *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g., Seafood"
                    class="w-full px-4 py-3 bg-[#F4F5F7] border-0 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition font-semibold text-gray-800 placeholder-gray-400">
            </div>

            <div>
                <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">URL Slug Route Reference *</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required placeholder="seafood"
                    class="w-full px-4 py-3 bg-[#F4F5F7] border-0 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition font-mono font-semibold text-gray-600 placeholder-gray-400">
            </div>
        </div>

        <div class="pt-5 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('categories.index') }}" class="px-5 py-3 bg-gray-100 text-gray-600 font-bold text-xs rounded-xl hover:bg-gray-200 transition uppercase tracking-wider">Cancel</a>
            <button type="submit" class="px-5 py-3 bg-orange-600 text-white font-bold text-xs rounded-xl shadow-sm hover:bg-orange-700 transition uppercase tracking-wider">Save Category</button>
        </div>
    </form>
</div>

<script>
    const nameIn = document.getElementById('name');
    const slugIn = document.getElementById('slug');
    nameIn.addEventListener('input', () => {
        slugIn.value = nameIn.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
    });
</script>
@endsection