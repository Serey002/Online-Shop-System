<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Authentication - Foodai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F4F5F7; }
    </style>
</head>
<body class="antialiased text-gray-700 bg-[#F4F5F7] flex items-center justify-center min-h-screen relative overflow-hidden">

    <div class="absolute w-96 h-96 bg-orange-500/5 rounded-full blur-3xl -top-20 -left-20 pointer-events-none"></div>
    <div class="absolute w-96 h-96 bg-amber-500/5 rounded-full blur-3xl -bottom-20 -right-20 pointer-events-none"></div>

    <div class="w-full max-w-4xl bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden relative z-10 mx-4 grid grid-cols-1 md:grid-cols-2">
        
        <div class="relative hidden md:block bg-gray-900 overflow-hidden min-h-[500px]">
            <img src="https://i.pinimg.com/736x/d1/00/0f/d1000f29f9e648eed9d07a1b2780e965.jpg" 
                 alt="Foodai Authentication Banner" 
                 class="w-full h-full object-cover opacity-90 transition transform hover:scale-105 duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex flex-col justify-end p-8 text-white">
                <span class="text-xs font-bold tracking-widest uppercase text-orange-400 mb-1">Premium Platform Matrix</span>
                <h3 class="text-2xl font-black tracking-tight leading-tight">Effortless Admin Management Control</h3>
                <p class="text-xs text-gray-300 mt-1 font-medium">Control and orchestrate your food store operational ecosystem from a secure system hub.</p>
            </div>
        </div>

        <div class="p-8 sm:p-12 flex flex-col justify-center bg-white">
            
            <div class="text-center md:text-left mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-orange-600 rounded-2xl text-white text-lg shadow-sm shadow-orange-600/30 mb-4">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Control Center Sign-In</h2>
                <p class="text-gray-400 text-sm mt-0.5">Please authenticate your administrative secure session</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-xl flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 text-base"></i>
                    <div class="text-xs text-rose-800 font-semibold space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ url('/admin/login') }}" method="POST" class="space-y-5">
                @csrf 

                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" id="email" 
                            class="w-full pl-10 pr-4 py-2.5 bg-[#F4F5F7] border border-transparent rounded-xl text-gray-800 placeholder-gray-400 text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:bg-white focus:border-gray-200 transition font-semibold"
                            placeholder="admin@gmail.com" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Security Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fa-solid fa-key text-sm"></i>
                        </span>
                        <input type="password" name="password" id="password" 
                            class="w-full pl-10 pr-4 py-2.5 bg-[#F4F5F7] border border-transparent rounded-xl text-gray-800 placeholder-gray-400 text-xs focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:bg-white focus:border-gray-200 transition font-semibold"
                            placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full py-3 px-4 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl shadow-sm hover:shadow transition tracking-wide mt-2 flex items-center justify-center gap-2 text-xs">
                    Verify Credentials <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

        </div>
    </div>

</body>
</html>