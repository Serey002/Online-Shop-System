<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Authentication - ShopSystem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 font-sans antialiased flex items-center justify-center min-h-screen relative overflow-hidden">

    <div class="absolute w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl -top-20 -left-20 pointer-events-none"></div>
    <div class="absolute w-96 h-96 bg-purple-600/20 rounded-full blur-3xl -bottom-20 -right-20 pointer-events-none"></div>

    <div class="w-full max-w-md p-8 bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl relative z-10 mx-4">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-indigo-600 rounded-2xl text-white text-2xl shadow-lg shadow-indigo-600/30 mb-4">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Control Center Sign-In</h2>
            <p class="text-slate-400 text-sm mt-1">Please authenticate your administrative secure session</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl flex items-start gap-3">
                <i class="fa-solid fa-circle-exclamation text-rose-400 mt-0.5 text-lg"></i>
                <div class="text-xs text-rose-300 font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ url('/admin/login') }}" method="POST" class="space-y-5">
            @csrf 

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" 
                        class="w-full pl-10 pr-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-indigo-500 transition font-medium"
                        placeholder="admin@shop.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Security Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                        <i class="fa-solid fa-key"></i>
                    </span>
                    <input type="password" name="password" id="password" 
                        class="w-full pl-10 pr-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-indigo-500 transition font-medium"
                        placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" 
                class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl shadow-lg shadow-indigo-600/20 transition duration-200 text-sm tracking-wide mt-2 flex items-center justify-center gap-2">
                Verify Credentials <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </form>

    </div>

</body>
</html>