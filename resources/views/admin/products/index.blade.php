@extends('admin.layouts.app')

@section('title', 'Products Matrix')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Products</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage and organize your food store menu items.</p>
    </div>
    <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-orange-600 text-white font-bold text-sm px-5 py-3 rounded-xl shadow-sm hover:bg-orange-700 transition tracking-wide">
        <i class="fa-solid fa-plus text-xs"></i> Add new product
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"><i class="fa-solid fa-magnifying-glass text-xs"></i></span>
        <input type="text" id="productSearchInput" placeholder="Search product info..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-medium">
    </div>
    
    <div>
        <select id="categoryFilterSelect" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-semibold text-gray-500">
            <option value="all">All Collection</option>
            @if(isset($categories))
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            @elseif(isset($products))
                @foreach($products->pluck('category')->unique('id')->filter() as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div>
        <select class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-semibold text-gray-500">
            <option>All Prices</option>
            <option>$0 - $25</option>
            <option>$25 - $50</option>
            <option>$50 - $100</option>
        </select>
    </div>

    <div>
        <select class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-semibold text-gray-500">
            <option>All Status</option>
            <option>Active</option>
            <option>No Active</option>
        </select>
    </div>

    <button class="bg-white border border-gray-200 text-gray-600 font-bold text-xs py-2.5 rounded-xl transition hover:bg-gray-50 flex items-center justify-center gap-2">
        <i class="fa-solid fa-sliders text-gray-400 text-xs"></i> Filter
    </button>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-400 font-bold text-[11px] uppercase tracking-wider border-b border-gray-100 bg-gray-50/50">
                    <th class="w-12 px-6 py-4 text-center">
                        <input type="checkbox" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500/20">
                    </th>
                    <th class="px-6 py-4">Product info</th>
                    <th class="px-6 py-4">Price</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Stock Progress</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody id="productsTableBody" class="divide-y divide-gray-100 text-xs text-gray-600 font-semibold">
                @forelse($products as $product)
                    <tr class="product-row hover:bg-gray-50/40 transition group" 
                        data-category="{{ $product->category_id ?? ($product->category->id ?? '') }}"
                        data-name="{{ strtolower($product->name) }}">
                        
                        <td class="px-6 py-5 text-center">
                            <input type="checkbox" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500/20">
                        </td>

                        <td class="px-6 py-5 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 border border-gray-100 flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                        <i class="fa-solid fa-bowl-food text-base"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <span class="text-gray-900 font-bold block text-sm group-hover:text-orange-600 transition">{{ $product->name }}</span>
                                <span class="text-gray-400 font-medium text-[11px] block mt-0.5">ID: {{ $product->id }}MT</span>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-gray-900 font-bold text-sm">
                            ${{ number_format($product->price, 2) }}
                        </td>

                        <td class="px-6 py-5">
                            @if($product->stock > 0)
                                <span class="text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">Active</span>
                            @else
                                <span class="text-gray-400 bg-gray-100 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">No Active</span>
                            @endif
                        </td>

                        <td class="px-6 py-5 w-64">
                            <div class="flex items-center justify-between text-[11px] font-bold text-gray-500 mb-1.5">
                                <span>{{ $product->stock }} items</span>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $product->stock > 20 ? 'bg-emerald-500' : ($product->stock > 0 ? 'bg-amber-400' : 'bg-gray-300') }}" 
                                     style="width: {{ min(($product->stock / 50) * 100, 100) }}%"></div>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-3 text-sm">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-gray-400 hover:text-gray-900 transition p-1"><i class="fa-regular fa-pen-to-square"></i></a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-gray-400 hover:text-rose-600 transition p-1"><i class="fa-regular fa-trash-can"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="emptyStateRow">
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400 font-medium">
                            <i class="fa-solid fa-cookie-bite text-4xl block mb-3 text-gray-200"></i>
                            No products loaded. Run your product seed database pipeline.
                        </td>
                    </tr>
                @endforelse
                
                <tr id="noMatchRow" class="hidden">
                    <td colspan="6" class="px-6 py-16 text-center text-gray-400 font-medium">
                        <i class="fa-solid fa-magnifying-glass text-3xl block mb-3 text-gray-200"></i>
                        No menu products match the selected filtration parameters.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryFilter = document.getElementById('categoryFilterSelect');
        const searchInput = document.getElementById('productSearchInput');
        const rows = document.querySelectorAll('.product-row');
        const noMatchRow = document.getElementById('noMatchRow');

        function filterProducts() {
            const selectedCategory = categoryFilter.value;
            const searchQuery = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(row => {
                const rowCategory = row.getAttribute('data-category');
                const rowName = row.getAttribute('data-name');

                const matchesCategory = (selectedCategory === 'all' || rowCategory === selectedCategory);
                const matchesSearch = rowName.includes(searchQuery);

                if (matchesCategory && matchesSearch) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });

            if (visibleCount === 0 && rows.length > 0) {
                noMatchRow.classList.remove('hidden');
            } else {
                noMatchRow.classList.add('hidden');
            }
        }

        categoryFilter.addEventListener('change', filterProducts);
        searchInput.addEventListener('input', filterProducts);
    });
</script>
@endsection