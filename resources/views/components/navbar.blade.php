<nav class="fixed top-0 left-0 right-0 bg-white/90 backdrop-blur-md z-50 border-b border-black/5" x-data="{ mobileMenuOpen: false, activeDropdown: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <a href="{{ route('home.index') }}" class="flex items-center gap-3 cursor-pointer">
                <img src="{{ asset('logo.png') }}" alt="GKI Sudirman" class="w-10 h-10 rounded-full">
                <div class="flex flex-col">
                    <span class="text-2xl font-bold leading-tight text-church-dark">GKI Sudirman</span>
                    {{-- <span class="text-[10px] uppercase tracking-widest opacity-60 text-church-dark">Tuhan Mencipta, Manusia Ikut Serta</span> --}}
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-6">
                <!-- Home -->
                <a href="{{ route('home.index') }}" class="flex items-center gap-1 text-base font-medium transition-colors py-2 cursor-pointer {{ Route::is('home.index') ? 'text-church-gold' : 'text-church-dark/60 hover:text-church-dark' }}">
                    Beranda
                </a>

                <!-- Jadwal Ibadah -->
                <a href="{{ route('sunday_services.index') }}" class="flex items-center gap-1 text-base font-medium transition-colors py-2 cursor-pointer {{ Route::is('sunday_services.index') ? 'text-church-gold' : 'text-church-dark/60 hover:text-church-dark' }}">
                    Jadwal Kebaktian Minggu
                </a>

                <!-- Warta -->
                <a href="{{ route('announcement.index') }}" class="flex items-center gap-1 text-base font-medium transition-colors py-2 cursor-pointer {{ Route::is('announcement.index') ? 'text-church-gold' : 'text-church-dark/60 hover:text-church-dark' }}">
                    Warta Jemaat
                </a>

                <!-- Renungan Harian -->
                <a href="{{ route('devotion.index') }}" class="flex items-center gap-1 text-base font-medium transition-colors py-2 cursor-pointer {{ Route::is('devotion.index') ? 'text-church-gold' : 'text-church-dark/60 hover:text-church-dark' }}">
                    Renungan Harian
                </a>

                <!-- Tentang Kami -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="flex items-center gap-1 text-base font-medium transition-colors py-2 cursor-pointer {{ Route::is('about_us.*') ? 'text-church-gold' : 'text-church-dark/60 hover:text-church-dark' }}">
                        Tentang Kami
                        <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition.opacity class="absolute top-full left-0 mt-1 w-56 bg-white rounded-2xl shadow-xl border border-black/5 p-2" x-cloak>
                        <a href="{{ route('about_us.vision_mission') }}" class="block w-full text-left px-4 py-2.5 rounded-xl text-base transition-colors hover:bg-church-warm/50 {{ Route::is('about_us.vision_mission') ? 'text-church-gold' : 'text-church-dark/70' }}">Visi Misi</a>
                        {{-- <a href="{{ route('tentang.keanggotaan') }}" class="block w-full text-left px-4 py-2.5 rounded-xl text-base transition-colors hover:bg-church-warm/50 text-church-dark/70">Keanggotaan</a>
                        <a href="{{ route('tentang.baptis_nikah') }}" class="block w-full text-left px-4 py-2.5 rounded-xl text-base transition-colors hover:bg-church-warm/50 text-church-dark/70">Baptis & Nikah</a> --}}
                        <a href="{{ route('about_us.assembly_structure') }}" class="block w-full text-left px-4 py-2.5 rounded-xl text-base transition-colors hover:bg-church-warm/50 {{ Route::is('about_us.assembly_structure') ? 'text-church-gold' : 'text-church-dark/70' }}">Struktur Kemajelisan</a>
                        <a href="{{ route('about_us.region') }}" class="block w-full text-left px-4 py-2.5 rounded-xl text-base transition-colors hover:bg-church-warm/50 {{ Route::is('about_us.region') ? 'text-church-gold' : 'text-church-dark/70' }}">Rayon</a>
                        <a href="{{ route('about_us.church_theme') }}" class="block w-full text-left px-4 py-2.5 rounded-xl text-base transition-colors hover:bg-church-warm/50 {{ Route::is('about_us.church_theme') ? 'text-church-gold' : 'text-church-dark/70' }}">Tema Gereja</a>
                    </div>
                </div>

                <!-- Hubungi Kami -->
                <a href="{{ route('contact_us.index') }}" class="flex items-center gap-1 text-base font-medium transition-colors py-2 cursor-pointer {{ Route::is('contact_us.index') ? 'text-church-gold' : 'text-church-dark/60 hover:text-church-dark' }}">
                    Hubungi Kami
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="lg:hidden p-2" @click="mobileMenuOpen = !mobileMenuOpen">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" class="lg:hidden bg-white border-b border-black/5" x-transition x-cloak>
        <div class="px-4 py-6 flex flex-col gap-2">
            <!-- Home -->
            <a href="{{ route('home.index') }}" class="w-full flex items-center justify-between p-3 rounded-xl text-base font-medium {{ Route::is('home.index') ? 'bg-church-gold/10 text-church-gold' : 'text-church-dark/60' }}">
                Home
            </a>

            <!-- Kebaktian Minggu -->
            <a href="{{ route('sunday_services.index') }}" class="w-full flex items-center justify-between p-3 rounded-xl text-base font-medium {{ Route::is('sunday_services.index') ? 'bg-church-gold/10 text-church-gold' : 'text-church-dark/60' }}">
                Jadwal Kebaktian Minggu
            </a>

            <!-- Warta -->
            <a href="{{ route('announcement.index') }}" class="w-full flex items-center justify-between p-3 rounded-xl text-base font-medium {{ Route::is('announcement.index') ? 'bg-church-gold/10 text-church-gold' : 'text-church-dark/60' }}">
                Warta Jemaat
            </a>

            <!-- Renungan Harian -->
            <a href="{{ route('devotion.index') }}" class="w-full flex items-center justify-between p-3 rounded-xl text-base font-medium {{ Route::is('devotion.index') ? 'bg-church-gold/10 text-church-gold' : 'text-church-dark/60' }}">
                Renungan Harian
            </a>

            <!-- Tentang Kami -->
            <div>
                <button @click="activeDropdown = activeDropdown === 'tentang' ? null : 'tentang'" class="w-full flex items-center justify-between p-3 rounded-xl text-base font-medium {{ Route::is('about_us.*') ? 'bg-church-gold/10 text-church-gold' : 'text-church-dark/60' }}">
                    Tentang Kami
                    <svg class="w-4 h-4 transition-transform" :class="activeDropdown === 'tentang' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="activeDropdown === 'tentang'" class="ml-6 mt-1 flex flex-col gap-1 border-l-2 border-church-gold/20 pl-4" x-cloak>
                    <a href="{{ route('about_us.vision_mission') }}" class="block w-full text-left py-2 text-sm {{ Route::is('about_us.vision_mission') ? 'text-church-gold' : 'text-church-dark/50' }}">Visi Misi</a>
                    {{-- <a href="{{ route('tentang.keanggotaan') }}" class="block w-full text-left py-2 text-sm text-church-dark/50">Keanggotaan</a>
                    <a href="{{ route('tentang.baptis_nikah') }}" class="block w-full text-left py-2 text-sm text-church-dark/50">Baptis & Nikah</a> --}}
                    <a href="{{ route('about_us.assembly_structure') }}" class="block w-full text-left py-2 text-sm {{ Route::is('about_us.assembly_structure') ? 'text-church-gold' : 'text-church-dark/50' }}">Struktur Kemajelisan</a>
                    <a href="{{ route('about_us.region') }}" class="block w-full text-left py-2 text-sm {{ Route::is('about_us.region') ? 'text-church-gold' : 'text-church-dark/50' }}">Rayon</a>
                    <a href="{{ route('about_us.church_theme') }}" class="block w-full text-left py-2 text-sm {{ Route::is('about_us.church_theme') ? 'text-church-gold' : 'text-church-dark/50' }}">Tema Gereja</a>
                </div>
            </div>

            <!-- Hubungi Kami -->
            <a href="{{ route('contact_us.index') }}" class="w-full flex items-center justify-between p-3 rounded-xl text-base font-medium {{ Route::is('contact_us.index') ? 'bg-church-gold/10 text-church-gold' : 'text-church-dark/60' }}">
                Hubungi Kami
            </a>
        </div>
    </div>
</nav>