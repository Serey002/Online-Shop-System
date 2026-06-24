@extends('admin.layouts.app')

@section('title', 'System Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white shadow-md mb-8">
    <h2 class="text-2xl font-bold mb-1">Welcome back, Manager!</h2>
    <p class="text-indigo-100 text-sm">Your store database connections and routing layers are performing smoothly.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-sm font-semibold text-gray-400 block uppercase tracking-wider">Catalog Groups</span>
            <span class="text-3xl font-bold text-gray-800 mt-1 block">Active</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 text-xl shadow-inner">
            <i class="fa-solid fa-layer-group"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-sm font-semibold text-gray-400 block uppercase tracking-wider">Total Inventory</span>
            <span class="text-3xl font-bold text-gray-800 mt-1 block">Loaded</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-xl shadow-inner">
            <i class="fa-solid fa-box"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-sm font-semibold text-gray-400 block uppercase tracking-wider">Customer Purchases</span>
            <span class="text-3xl font-bold text-gray-800 mt-1 block">Monitored</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl shadow-inner">
            <i class="fa-solid fa-receipt"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-sm font-semibold text-gray-400 block uppercase tracking-wider">Store Traffic</span>
            <span class="text-3xl font-bold text-gray-800 mt-1 block">Secured</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 text-xl shadow-inner">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>
</div>
@endsection