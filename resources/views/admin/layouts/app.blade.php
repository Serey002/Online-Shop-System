<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - ShopSystem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <div class="w-64 bg-slate-900 text-slate-300 flex flex-col hidden md:flex">
            <div class="p-5 text-xl font-bold text-white tracking-wider border-b border-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-gauge-high text-indigo-400"></i> CONTROL CENTER
            </div>
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : '' }}">
                    <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('categories.*') ? 'bg-indigo-600 text-white' : '' }}">
                    <i class="fa-solid fa-layer-group w-5"></i> Categories
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('products.*') ? 'bg-indigo-600 text-white' : '' }}">
                    <i class="fa-solid fa-box-open w-5"></i> Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white' : '' }}">
                    <i class="fa-solid fa-shopping-cart w-5"></i> Customer Orders
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white' : '' }}">
                    <i class="fa-solid fa-users w-5"></i> Registered Users
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="w-100 flex items-center gap-3 px-4 py-2 text-sm font-medium text-red-400 hover:bg-red-500/10 rounded-lg w-full transition">
                        <i class="fa-solid fa-right-from-bracket w-5"></i> Exit Admin Session
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 z-10">
                <h1 class="text-lg font-semibold text-gray-800">@yield('page-title')</h1>
                <div class="flex items-center gap-3 text-sm text-gray-600 font-medium bg-gray-100 px-4 py-2 rounded-full">
                    <i class="fa-solid fa-circle-user text-indigo-600 text-lg"></i> {{ Auth::user()->name ?? 'System Admin' }}
                </div>
            </header>

            <main class="p-6 max-w-7xl w-full mx-auto">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-check text-lg text-emerald-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>