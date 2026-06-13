@php
    $user = auth()->user();
    $user->role_formatted = ($user->role == 1) ? 'Super Admin' : 'Admin';
@endphp

<header class="h-16 bg-white/80 backdrop-blur-md shadow-sm flex items-center justify-between px-4 lg:px-8 z-10 border-b border-gray-200/60 sticky top-0">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-church-gold focus:outline-none p-1.5 rounded-lg hover:bg-church-warm/50 transition-colors">
            <i class="fas fa-bars text-lg"></i>
        </button>
        <div class="hidden md:block">
            <h2 class="text-xl font-bold text-church-dark">@yield('page_title', 'Admin Panel')</h2>
        </div>
    </div>
    
    <div class="flex items-center space-x-4">
        
        <div class="relative" x-data="{ profileOpen: false }">
            <div @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-2.5 cursor-pointer hover:opacity-80 transition-opacity">
                <div class="hidden md:block text-right">
                    <p class="text-[13px] font-bold text-church-dark leading-tight">{{ $user->name }}</p>
                    <p class="text-[11px] text-church-gold font-medium">Status: {{ $user->role_formatted }}</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-church-gold flex items-center justify-center text-church-dark">
                    <i class="fas fa-user"></i>
                </div>
                <i class="fas fa-chevron-down text-[10px] text-gray-400 ml-0.5"></i>
            </div>

            <!-- Dropdown Menu -->
            <div x-show="profileOpen" 
                x-transition:enter="transition ease-out duration-100" 
                x-transition:enter-start="transform opacity-0 scale-95" 
                x-transition:enter-end="transform opacity-100 scale-100" 
                x-transition:leave="transition ease-in duration-75" 
                x-transition:leave-start="transform opacity-100 scale-100" 
                x-transition:leave-end="transform opacity-0 scale-95" 
                class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] border border-gray-200 py-2 z-50 text-sm hover:bg-red-50" style="display: none;">
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="cursor-pointer w-full text-left px-4 py-2 text-red-600 font-bold transition-colors">
                        <i class="fas fa-sign-out-alt w-5 text-center mr-1 text-red-400"></i> Logout Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>