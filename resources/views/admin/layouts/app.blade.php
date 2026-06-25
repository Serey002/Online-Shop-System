<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Foodai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F4F5F7; }
    </style>
</head>
<body class="antialiased text-gray-700 bg-[#F4F5F7]">

    <div class="flex h-screen w-full max-w-full overflow-hidden">
        
        <div class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex-col hidden md:flex">
            <div class="p-6 h-20 flex items-center gap-2 border-b border-gray-100">
                <div class="w-8 h-8 rounded-xl bg-orange-600 flex items-center justify-center text-white shadow-sm shadow-orange-600/30">
                    <i class="fa-solid fa-bag-shopping text-sm"></i>
                </div>
                <span class="text-xl font-bold tracking-tight text-gray-900">Food<span class="text-orange-600">ai</span></span>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto text-sm font-medium text-gray-500">
                <span class="block px-4 py-2 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Menu</span>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-orange-50 text-orange-600 font-semibold' : 'hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="flex items-center gap-3"><i class="fa-solid fa-table-columns w-5"></i> Dashboard</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-orange-50 text-orange-600 font-semibold' : 'hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="flex items-center gap-3"><i class="fa-solid fa-receipt w-5"></i> Order</span>
                    <span class="bg-orange-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">
                        {{ \App\Models\Order::where('status', 'pending')->count() }}
                    </span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-orange-50 text-orange-600 font-semibold' : 'hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="flex items-center gap-3"><i class="fa-solid fa-user-group w-5"></i> Customers</span>
                </a>

                <span class="block px-4 py-2 pt-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tools</span>

                <a href="{{ route('products.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('products.*') ? 'bg-orange-50 text-orange-600 font-semibold' : 'hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="flex items-center gap-3"><i class="fa-solid fa-box w-5"></i> Product</span>
                </a>

                <a href="{{ route('categories.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('categories.*') ? 'bg-orange-50 text-orange-600 font-semibold' : 'hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="flex items-center gap-3"><i class="fa-solid fa-layer-group w-5"></i> Categories</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-gray-500 hover:text-rose-600 rounded-xl transition">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Sign Out Session
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <header class="bg-white border-b border-gray-200 h-20 flex-shrink-0 flex items-center justify-between px-8 z-20 sticky top-0 w-full">
                <div class="relative w-80 flex-shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </span>
                    <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2.5 bg-[#F4F5F7] rounded-xl text-sm border-0 focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition">
                </div>

                <div class="flex items-center gap-4 flex-shrink-0">
                    <button class="w-10 h-10 rounded-full bg-gray-50 border border-gray-200 text-gray-500 hover:bg-gray-100 transition relative flex items-center justify-center">
                        <i class="fa-regular fa-bell"></i>
                        <span class="absolute top-2.5 right-2.5 w-2 h-2 rounded-full bg-emerald-500"></span>
                    </button>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-black text-xs uppercase border border-orange-200 flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <span class="block text-sm font-bold text-gray-900 leading-tight">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <span class="block text-[11px] font-medium text-gray-400">{{ Auth::user()->email ?? 'admin@gmail.com' }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 w-full">
                <div class="max-w-[1400px] mx-auto">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm text-sm font-medium">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

    </div>

</body>
</html>