@extends('admin.layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-gray-900 tracking-tight">System Settings</h2>
    <p class="text-sm text-gray-400 mt-0.5">Customize your supervisor profile dashboard parameters and contact vectors.</p>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden max-w-4xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Avatar Profile Picture</span>
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-orange-100 border border-orange-200 text-orange-600 overflow-hidden flex items-center justify-center font-black text-xl uppercase flex-shrink-0 shadow-sm">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Current Admin profile" class="w-full h-full object-cover" id="avatarPreview">
                    @else
                        <div id="avatarFallback" class="w-full h-full flex items-center justify-center bg-orange-50">
                            {{ strtoupper(substr($user->name ?? 'AD', 0, 2)) }}
                        </div>
                    @endif
                </div>
                
                <div class="flex-1 space-y-1.5">
                    <input type="file" name="image" id="avatarFileInput" class="hidden" accept="image/*">
                    <button type="button" onclick="document.getElementById('avatarFileInput').click()" class="bg-white border border-gray-200 text-gray-700 font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm hover:bg-gray-50 transition tracking-wide inline-flex items-center gap-2">
                        <i class="fa-solid fa-cloud-arrow-up text-gray-400"></i> Choose custom photo
                    </button>
                    <p class="text-[11px] text-gray-400 font-medium">Supported formats: JPG, PNG, WEBP. Maximum file size standard limit: 2MB.</p>
                    @error('image') <span class="text-rose-500 font-bold text-[11px] block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <hr class="border-gray-100">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-500">Administrator Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl text-xs font-semibold text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:bg-white transition">
                @error('name') <span class="text-rose-500 font-bold text-[11px] block">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-500">Secure Direct Telephone Contact</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-000" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl text-xs font-semibold text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:bg-white transition">
                @error('phone') <span class="text-rose-500 font-bold text-[11px] block">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="text-xs font-bold text-gray-500">System Credentials Address Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl text-xs font-semibold text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:bg-white transition">
                @error('email') <span class="text-rose-500 font-bold text-[11px] block">{{ $message }}</span> @enderror
            </div>
        </div>

        <hr class="border-gray-100">

        <div>
            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Change Password</span>
            <p class="text-[11px] text-gray-400 font-medium mb-4">Leave blank if you don't want to change your password.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-500">Current Password</label>
                    <input type="password" name="current_password" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl text-xs font-semibold text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:bg-white transition" placeholder="Enter current password">
                    @error('current_password') <span class="text-rose-500 font-bold text-[11px] block">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-500">New Password</label>
                    <input type="password" name="new_password" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl text-xs font-semibold text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:bg-white transition" placeholder="Enter new password">
                    @error('new_password') <span class="text-rose-500 font-bold text-[11px] block">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-500">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl text-xs font-semibold text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:bg-white transition" placeholder="Confirm new password">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-end">
            <button type="submit" class="bg-orange-600 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-sm hover:bg-orange-700 transition tracking-wide flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-xs"></i> Persist Account Data
            </button>
        </div>
    </form>
</div>

<script>
    // Live Image Input Previewer script
    document.getElementById('avatarFileInput').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                let img = document.getElementById('avatarPreview');
                if (!img) {
                    // Replace fallback placeholder cleanly
                    const fallback = document.getElementById('avatarFallback');
                    if (fallback) fallback.remove();
                    
                    img = document.createElement('img');
                    img.id = 'avatarPreview';
                    img.className = 'w-full h-full object-cover';
                    event.target.closest('form').querySelector('.w-20').appendChild(img);
                }
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection