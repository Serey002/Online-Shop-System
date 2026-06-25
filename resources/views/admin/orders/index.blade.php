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
            {{ $orders->count() }} Live Records
        </span>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="relative lg:col-span-2">
        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
        </span>
        <input type="text" placeholder="Search by customer name or order ID..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-medium">
    </div>
    
    <div>
        <select class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-semibold text-gray-500">
            <option>All Methods (Delivery/Pickup)</option>
            <option>Delivery Service</option>
            <option>Dine-in / Pickup</option>
        </select>
    </div>

    <div>
        <select class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 transition font-semibold text-gray-500">
            <option>All Order Statuses</option>
            <option>Pending Kitchen Preparation</option>
            <option>Out For Delivery</option>
            <option>Completed Orders</option>
            <option>Cancelled Tickets</option>
        </select>
    </div>

    <button class="bg-white border border-gray-200 text-gray-600 font-bold text-xs py-2.5 rounded-xl transition hover:bg-gray-50 flex items-center justify-center gap-2">
        <i class="fa-solid fa-sliders text-gray-400 text-xs"></i> Advanced Filter
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
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Action Controls</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs text-gray-600 font-semibold">
                
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50/40 transition group">
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
                    <td class="px-6 py-5">
                        @if(($order->status ?? 'pending') === 'completed' || ($order->status ?? '') === 'served')
                            <span class="text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">Served & Done</span>
                        @elseif(($order->status ?? '') === 'cancelled')
                            <span class="text-rose-600 bg-rose-50 border border-rose-100 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">Cancelled</span>
                        @elseif(($order->status ?? '') === 'shipping' || ($order->status ?? '') === 'courier')
                            <span class="text-blue-600 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">With Courier</span>
                        @else
                            <span class="text-amber-600 bg-amber-50 border border-amber-100 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">Preparing</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex items-center justify-end gap-2 text-sm">
                            <button title="Print Kitchen Receipt" class="text-gray-400 hover:text-gray-900 transition p-1.5 bg-gray-50 hover:bg-gray-100 rounded-lg">
                                <i class="fa-solid fa-print"></i>
                            </button>
                            <button title="Update Progress Status" class="text-gray-400 hover:text-orange-600 transition p-1.5 bg-gray-50 hover:bg-gray-100 rounded-lg">
                                <i class="fa-regular fa-circle-check"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center text-gray-400 font-medium">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="fa-solid fa-inbox text-2xl text-gray-300"></i>
                            <span>No dynamic store transactions or orders found in database records.</span>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
@endsection