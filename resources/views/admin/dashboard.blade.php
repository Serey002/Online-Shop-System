@extends('admin.layouts.app')

@section('title', 'Control Hub Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Overview Dashboard</h2>
    <p class="text-sm text-gray-400 mt-0.5">Welcome back, administrator! Here is what is happening with your food store today.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <span class="block text-xs font-semibold text-gray-400 mb-1">Total Orders</span>
                <span class="block text-3xl font-black text-gray-900 tracking-tight">
                    {{ $totalOrdersCount ?? 0 }}
                </span>
            </div>
            <span class="text-gray-400"><i class="fa-regular fa-square-check text-lg"></i></span>
        </div>
        <div class="text-[11px] font-medium text-gray-400">
            Lifetime orders recorded
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <span class="block text-xs font-semibold text-gray-400 mb-1">Menu Items</span>
                <span class="block text-3xl font-black text-gray-900 tracking-tight">
                    {{ App\Models\Product::count() }}
                </span>
            </div>
            <span class="text-gray-400"><i class="fa-solid fa-bowl-rice text-lg"></i></span>
        </div>
        <div class="text-[11px] font-medium text-gray-400">
            Active in store catalog
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <span class="block text-xs font-semibold text-gray-400 mb-1">Month Total</span>
                <span class="block text-3xl font-black text-gray-900 tracking-tight">
                    ${{ number_format($monthlyRevenue ?? 0.00, 2) }}
                </span>
            </div>
            <span class="text-gray-400 text-lg font-medium">$</span>
        </div>
        <div class="text-[11px] font-medium text-gray-400">
            Current month earnings
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div>
                <span class="block text-xs font-semibold text-gray-400 mb-1">Active Users</span>
                <span class="block text-3xl font-black text-gray-900 tracking-tight">
                    {{ App\Models\User::where('is_admin', false)->count() }}
                </span>
            </div>
            <span class="text-gray-400"><i class="fa-regular fa-user text-lg"></i></span>
        </div>
        <div class="text-[11px] font-medium text-gray-400">
            Registered customer base
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm lg:col-span-2">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-sm font-bold text-gray-900">Monthly Performance Overview</h3>
            <span class="text-xs font-bold text-gray-400">Live Analytics</span>
        </div>
        
        <div class="h-48 flex items-end justify-between gap-4 pt-4 relative">
            @if(isset($monthlyData) && count($monthlyData) > 0)
                @foreach($monthlyData as $month => $value)
                <div class="flex-1 flex flex-col items-center gap-2 z-10 h-full justify-end">
                    <div class="w-full bg-blue-500 rounded-t-md shadow-sm transition-all" style="height: {{ $value['percentage'] ?? 50 }}%;"></div>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">{{ $month }}</span>
                </div>
                @endforeach
            @else
                <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-400 font-medium">
                    No sales cycle data available for this timeline.
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
        <div>
            <span class="block text-xs font-semibold text-gray-400 mb-1">Total System Accounts</span>
            <span class="block text-3xl font-black text-gray-900 tracking-tight mb-2">
                {{ App\Models\User::count() }}
            </span>
            <p class="text-xs text-gray-400 font-medium">Includes both store managers and regular consumers profile classes.</p>
        </div>

        <div class="border-t border-gray-100 pt-4 mt-4 space-y-2 text-xs font-bold text-gray-600">
            <div class="flex justify-between items-center">
                <span class="text-gray-400">Administrators:</span>
                <span class="text-gray-900 font-black">{{ App\Models\User::where('is_admin', true)->count() }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-400">Regular Customers:</span>
                <span class="text-gray-900 font-black">{{ App\Models\User::where('is_admin', false)->count() }}</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-xs font-bold text-gray-400 block mb-1">Gross Store Valuation</span>
            <span class="text-2xl font-black text-gray-900 block">
                ${{ number_format($grossValuation ?? 0.00, 2) }}
            </span>
            <span class="text-[10px] text-gray-400 block mt-1">Aggregated lifetime invoices</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden lg:col-span-2 flex flex-col justify-between">
        <div class="p-6 pb-2 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900">Recent Customer Orders</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 font-bold text-[10px] uppercase tracking-wider bg-gray-50/40 border-b border-gray-50">
                        <th class="px-6 py-3">Customer Profile</th>
                        <th class="px-6 py-3">Email Address</th>
                        <th class="px-6 py-3">Placed Date</th>
                        <th class="px-6 py-3 text-right">Order Value</th>
                    </tr>
                </thead>
                <tbody class="text-[11px] font-semibold text-gray-600 divide-y divide-gray-50">
                    @forelse($recentOrders ?? [] as $order)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-3 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-[9px] uppercase">
                                {{ strtoupper(substr($order->user->name ?? 'CS', 0, 2)) }}
                            </div>
                            <span class="text-gray-900 font-bold">{{ $order->user->name ?? 'Guest User' }}</span>
                        </td>
                        <td class="px-6 py-3 text-gray-500 font-medium">
                            {{ $order->user->email ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-3 text-gray-400 font-medium">
                            {{ $order->created_at ? $order->created_at->format('d.m.Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-3 text-right text-orange-600 font-black">
                            ${{ number_format($order->total_price ?? 0.00, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 font-medium">
                            <div class="flex flex-col items-center justify-center gap-1.5 py-4">
                                <i class="fa-solid fa-basket-shopping text-gray-300 text-lg"></i>
                                <span>No real customer checkout orders found in your database yet.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection