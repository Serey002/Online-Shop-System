@extends('admin.layouts.app')

@section('title', 'Customers Directory')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Customers Directory</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage user credentials, tracking habits, and lifetime customer order valuation cycles.</p>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="relative lg:col-span-2">
        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
        </span>
        <input type="text" id="customerSearchInput" placeholder="Search customer records..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-medium">
    </div>
    
    <div>
        <select id="tierFilterSelect" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-semibold text-gray-500">
            <option value="all">All Tiers (VIP / Normal)</option>
            <option value="vip">VIP Gold Member</option>
            <option value="regular">Regular Consumer</option>
        </select>
    </div>

    <div>
        <select id="sortOrderSelect" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-semibold text-gray-500">
            <option value="newest">Sort by: Newest Joined</option>
            <option value="highest_spent">Sort by: Highest Spent</option>
        </select>
    </div>

    <button id="resetFiltersButton" class="bg-white border border-gray-200 text-gray-600 font-bold text-xs py-2.5 rounded-xl transition hover:bg-gray-50 flex items-center justify-center gap-2">
        <i class="fa-solid fa-sliders text-gray-400 text-xs"></i> Reset
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
                    <th class="px-6 py-4">Customer Info</th>
                    <th class="px-6 py-4">Contact Details</th>
                    <th class="px-6 py-4">Registration Date</th>
                    <th class="px-6 py-4">Lifetime Orders Count</th>
                    <th class="px-6 py-4">Total Value Spent</th>
                    <th class="px-6 py-4">Status Class</th>
                </tr>
            </thead>
            <tbody id="customersTableBody" class="divide-y divide-gray-100 text-xs text-gray-600 font-semibold">
                
                @forelse($users as $user)
                <tr class="customer-row hover:bg-gray-50/40 transition group"
                    data-name="{{ strtolower($user->name) }}"
                    data-email="{{ strtolower($user->email) }}"
                    data-id="{{ $user->id }}"
                    data-spent="{{ $user->total_spent ?? 0.00 }}"
                    data-date="{{ $user->created_at ? $user->created_at->timestamp : 0 }}">
                    
                    <td class="px-6 py-5 text-center">
                        <input type="checkbox" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500/20">
                    </td>
                    <td class="px-6 py-5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 border border-orange-200 font-bold flex items-center justify-center uppercase tracking-wider text-xs">
                            {{ strtoupper(substr($user->name ?? 'CS', 0, 2)) }}
                        </div>
                        <div>
                            <span class="text-gray-900 font-bold block text-sm group-hover:text-orange-600 transition">
                                {{ $user->name }}
                            </span>
                            <span class="text-gray-400 font-medium text-[11px] block mt-0.5">ID: #CS-{{ $user->id }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-gray-900 block font-medium">{{ $user->email }}</span>
                        <span class="text-gray-400 font-medium text-[11px] block mt-0.5">
                            {{ $user->phone ?? 'No Phone Number' }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-gray-500 font-medium">
                        {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                    </td>
                    <td class="px-6 py-5 text-gray-900 font-bold text-center">
                        {{ $user->orders_count ?? 0 }} Orders
                    </td>
                    <td class="px-6 py-5 text-orange-600 font-black text-sm">
                        ${{ number_format($user->total_spent ?? 0.00, 2) }}
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">
                            Active User
                        </span>
                    </td>
                </tr>
                @empty
                <tr id="emptyRowPlaceholder">
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-medium">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="fa-solid fa-user-slash text-xl text-gray-300"></i>
                            <span>No registered real customers found in database.</span>
                        </div>
                    </td>
                </tr>
                @endforelse

                <tr id="noMatchRowPlaceholder" class="hidden">
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-medium bg-slate-50/40">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-lg text-gray-300"></i>
                            <span>No records found matching your active filter criteria.</span>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('customerSearchInput');
    const tierSelect = document.getElementById('tierFilterSelect');
    const sortSelect = document.getElementById('sortOrderSelect');
    const resetBtn = document.getElementById('resetFiltersButton');
    
    const tableBody = document.getElementById('customersTableBody');
    const noMatchRow = document.getElementById('noMatchRowPlaceholder');

    function applyFiltersAndSort() {
        const query = searchInput.value.trim().toLowerCase();
        const selectedTier = tierSelect.value;
        const selectedSort = sortSelect.value;
        
        // Convert to array for sorting/filtering manipulation updates
        const rowsArray = Array.from(tableBody.querySelectorAll('.customer-row'));
        let visibleCount = 0;

        rowsArray.forEach(row => {
            const name = row.getAttribute('data-name');
            const email = row.getAttribute('data-email');
            const id = row.getAttribute('data-id');
            const totalSpent = parseFloat(row.getAttribute('data-spent'));

            // 1. Text Query Matching evaluation logic rules
            const matchesText = name.includes(query) || email.includes(query) || id.includes(query);

            // 2. Mock Tier Calculation Rule (Matches your UI design context logic)
            let matchesTier = true;
            if (selectedTier === 'vip') {
                matchesTier = (totalSpent >= 100.00); // Automatically marks users spending over $100 as VIP
            } else if (selectedTier === 'regular') {
                matchesTier = (totalSpent < 100.00);
            }

            // Combine visibility validation states
            if (matchesText && matchesTier) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });

        // 3. Document Node Sorting Manipulation Engine
        rowsArray.sort((a, b) => {
            if (selectedSort === 'highest_spent') {
                return parseFloat(b.getAttribute('data-spent')) - parseFloat(a.getAttribute('data-spent'));
            } else {
                // Fallback Default: Order by registration unix timestamps descending (Newest Joined)
                return parseInt(b.getAttribute('data-date')) - parseInt(a.getAttribute('data-date'));
            }
        });

        // Re-append sorted elements inside the node tree without re-rendering loops
        rowsArray.forEach(row => tableBody.appendChild(row));

        // Display empty status cards fallback conditional rendering
        if (visibleCount === 0 && rowsArray.length > 0) {
            noMatchRow.classList.remove('hidden');
            tableBody.appendChild(noMatchRow);
        } else {
            noMatchRow.classList.add('hidden');
        }
    }

    // Attach control listeners hooks
    searchInput.addEventListener('input', applyFiltersAndSort);
    tierSelect.addEventListener('change', applyFiltersAndSort);
    sortSelect.addEventListener('change', applyFiltersAndSort);

    resetBtn.addEventListener('click', function() {
        searchInput.value = '';
        tierSelect.value = 'all';
        sortSelect.value = 'newest';
        applyFiltersAndSort();
    });
});
</script>
@endsection