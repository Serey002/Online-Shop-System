@extends('admin.layouts.app')

@section('title', 'Orders Management')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Orders Queue</h2>
        <p class="text-sm text-gray-400 mt-0.5">Track, audit, and process incoming food store transactions.</p>
    </div>
    <div class="flex items-center gap-2 text-xs font-bold text-gray-500">
        <span class="bg-orange-100 text-orange-600 px-3 py-1.5 rounded-xl">
            <span id="liveRecordsCount">{{ $orders->count() }}</span> Live Records
        </span>
    </div>
</div>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="relative lg:col-span-2">
        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
        </span>
        <input type="text" id="orderSearchInput" placeholder="Search by customer name or order ID..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-medium">
    </div>
    
    <div>
        <select id="methodFilterSelect" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-semibold text-gray-500">
            <option value="all">All Methods (Delivery/Pickup)</option>
            <option value="delivery service">Delivery Service</option>
            <option value="dine in">Dine-in / Pickup</option>
        </select>
    </div>

    <div>
        <select id="statusFilterSelect" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-semibold text-gray-500">
            <option value="all">All Order Statuses</option>
            <option value="preparing">Preparing</option>
            <option value="with courier">With Courier</option>
            <option value="served & done">Served & Done</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <button id="resetFiltersButton" class="bg-white border border-gray-200 text-gray-600 font-bold text-xs py-2.5 rounded-xl transition hover:bg-gray-50 flex items-center justify-center gap-2">
        <i class="fa-solid fa-sliders text-gray-400 text-xs"></i> Reset Filter
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
                    <th class="px-6 py-4">Order ID & Date</th>
                    <th class="px-6 py-4">Customer Details</th>
                    <th class="px-6 py-4">Ordered Items Breakdown</th>
                    <th class="px-6 py-4">Total Bill</th>
                    <th class="px-6 py-4">Status Update</th>
                    <th class="px-6 py-4 text-right">Action Controls</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody" class="divide-y divide-gray-100 text-xs text-gray-600 font-semibold">
                
                @forelse($orders as $order)
                @php 
                    $cleanStatus = strtolower($order->status ?? 'preparing');
                    if ($cleanStatus === 'completed' || $cleanStatus === 'served') {
                        $cleanStatus = 'served & done';
                    }
                    if ($cleanStatus === 'shipping' || $cleanStatus === 'courier') {
                        $cleanStatus = 'with courier';
                    }
                @endphp
                <tr class="order-row hover:bg-gray-50/40 transition group"
                    data-id="{{ strtolower($order->id) }}"
                    data-customer="{{ strtolower($order->user->name ?? '') }}"
                    data-method="{{ strtolower($order->notes ?? '') }}"
                    data-status-label="{{ $cleanStatus }}">
                    
                    <td class="px-6 py-5 text-center">
                        <input type="checkbox" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500/20">
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-gray-900 font-bold block text-sm group-hover:text-orange-600 transition">
                            #OD-{{ $order->id }}-{{ strtoupper(substr($order->status ?? 'FB', 0, 2)) }}
                        </span>
                        <span class="text-gray-400 font-medium text-[11px] block mt-0.5">
                            {{ $order->created_at ? $order->created_at->format('M d, Y \a\t g:i A') : 'N/A' }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-5 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full overflow-hidden bg-orange-100 border border-orange-200 text-orange-600 flex items-center justify-center font-bold text-[10px] uppercase flex-shrink-0">
                            @if($order->user && $order->user->image)
                                <img src="{{ asset('storage/' . $order->user->image) }}" alt="Customer Avatar" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($order->user->name ?? 'CS', 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <span class="text-gray-900 font-bold block">
                                {{ $order->user->name ?? 'Guest Customer' }}
                            </span>
                            <span class="text-gray-400 font-medium text-[11px] block mt-0.5">
                                {{ $order->user->phone ?? 'No Phone Contact' }}
                            </span>
                        </div>
                    </td>

                    <td class="px-6 py-5 max-w-xs">
                        <p class="text-gray-700 truncate font-medium">
                            {{ $order->items_summary ?? 'Standard Kitchen Meal Selection' }}
                        </p>
                        @if(!empty($order->notes))
                        <span class="text-gray-400 font-medium text-[10px] block mt-1">
                            Note: {{ $order->notes }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-gray-900 font-bold text-sm">
                        ${{ number_format($order->total_price ?? 0.00, 2) }}
                    </td>
                    
                    <td class="px-6 py-5 status-cell">
                        <form action="{{ route('admin.orders.status.update', $order->id) }}" method="POST" id="status-form-{{ $order->id }}">
                            @csrf
                            @method('PATCH')
                            <select 
                                name="status" 
                                onchange="document.getElementById('status-form-{{ $order->id }}').submit();"
                                class="text-[10px] font-bold uppercase tracking-wider rounded-lg px-2.5 py-1.5 border cursor-pointer focus:outline-none focus:ring-1 focus:ring-orange-500/40 transition
                                {{ $cleanStatus === 'preparing' ? 'text-amber-600 bg-amber-50 border-amber-200' : '' }}
                                {{ $cleanStatus === 'with courier' ? 'text-blue-600 bg-blue-50 border-blue-200' : '' }}
                                {{ $cleanStatus === 'served & done' ? 'text-emerald-600 bg-emerald-50 border-emerald-200' : '' }}
                                {{ $cleanStatus === 'cancelled' ? 'text-rose-600 bg-rose-50 border-rose-200' : '' }}"
                            >
                                <option value="preparing" {{ $cleanStatus === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                <option value="with courier" {{ $cleanStatus === 'with courier' ? 'selected' : '' }}>With Courier</option>
                                <option value="served & done" {{ $cleanStatus === 'served & done' ? 'selected' : '' }}>Served & Done</option>
                                <option value="cancelled" {{ $cleanStatus === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    
                    <td class="px-6 py-5 text-right">
                        <div class="flex items-center justify-end gap-2 text-sm">
                            <button title="Print Kitchen Receipt" class="text-gray-400 hover:text-gray-900 transition p-1.5 bg-gray-50 hover:bg-gray-100 rounded-lg">
                                <i class="fa-solid fa-print"></i>
                            </button>
                            <button title="View Details" class="text-gray-400 hover:text-orange-600 transition p-1.5 bg-gray-50 hover:bg-gray-100 rounded-lg">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="emptyRowPlaceholder">
                    <td colspan="7" class="px-6 py-16 text-center text-gray-400 font-medium">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="fa-solid fa-inbox text-2xl text-gray-300"></i>
                            <span>No dynamic store transactions or orders found in database records.</span>
                        </div>
                    </td>
                </tr>
                @endforelse

                <tr id="noMatchRowPlaceholder" class="hidden">
                    <td colspan="7" class="px-6 py-16 text-center text-gray-400 font-medium bg-slate-50/50">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-xl text-gray-300"></i>
                            <span>No matching queue entries match your selected filter criteria.</span>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('orderSearchInput');
    const methodSelect = document.getElementById('methodFilterSelect');
    const statusSelect = document.getElementById('statusFilterSelect');
    const resetBtn = document.getElementById('resetFiltersButton');
    
    const rows = document.querySelectorAll('.order-row');
    const noMatchRow = document.getElementById('noMatchRowPlaceholder');
    const liveCountBadge = document.getElementById('liveRecordsCount');

    function executeFilterEngine() {
        const query = searchInput.value.trim().toLowerCase();
        const selectedMethod = methodSelect.value;
        const selectedStatus = statusSelect.value;
        
        let activeCounter = 0;

        rows.forEach(row => {
            const orderId = row.getAttribute('data-id');
            const customerName = row.getAttribute('data-customer');
            const methodNotes = row.getAttribute('data-method');
            const statusLabel = row.getAttribute('data-status-label');

            // 1. Text Query Filter Rule
            const matchesText = orderId.includes(query) || customerName.includes(query);

            // 2. Delivery Method Check Rule 
            let matchesMethod = false;
            if (selectedMethod === 'all') {
                matchesMethod = true;
            } else if (selectedMethod === 'dine in') {
                matchesMethod = methodNotes.includes('dine in') || methodNotes.includes('table') || methodNotes.includes('cash');
            } else if (selectedMethod === 'delivery service') {
                matchesMethod = methodNotes.includes('phnom penh') || methodNotes.includes('cambodia') || (!methodNotes.includes('dine in') && !methodNotes.includes('table'));
            }

            // 3. Queue Order Status Check Rule
            const matchesStatus = (selectedStatus === 'all' || statusLabel === selectedStatus);

            // Trigger grid display visibility rules
            if (matchesText && matchesMethod && matchesStatus) {
                row.classList.remove('hidden');
                activeCounter++;
            } else {
                row.classList.add('hidden');
            }
        });

        // Toggle No Results table row placeholder fallback banner element
        if (activeCounter === 0 && rows.length > 0) {
            noMatchRow.classList.remove('hidden');
        } else {
            noMatchRow.classList.add('hidden');
        }

        // Dynamically update the live counts counter badge matching screen records
        if (liveCountBadge) {
            liveCountBadge.textContent = activeCounter;
        }
    }

    // Bind interaction event listeners
    searchInput.addEventListener('input', executeFilterEngine);
    methodSelect.addEventListener('change', executeFilterEngine);
    statusSelect.addEventListener('change', executeFilterEngine);

    resetBtn.addEventListener('click', function() {
        searchInput.value = '';
        methodSelect.value = 'all';
        statusSelect.value = 'all';
        executeFilterEngine();
    });

    // Execute filter automatically on load to apply initial stats
    executeFilterEngine();
});
</script>
@endsection