@php
    use App\Models\About;
    $abouts = About::get();
@endphp

<footer class="bg-church-dark text-white py-16 px-4 mt-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('logo.png') }}" alt="GKI Sudirman" class="w-10 h-10 rounded-full">
                <span class="text-lg sm:text-xl font-bold">GKI Sudirman</span>
            </div>
            <p class="text-white/40 text-sm sm:text-base leading-relaxed">{{ $abouts->where('name', 'Visi')->first()?->description ?? '-' }}</p>
        </div>
        <div>
            <h4 class="font-bold text-lg sm:text-xl mb-4 text-church-gold">Tautan Cepat</h4>
            <ul class="space-y-3 text-sm sm:text-base *:text-white/50">
                <li><a href="{{ route('home.index') }}" class="hover:text-church-gold transition-colors">Beranda</a></li>
                <li><a href="{{ route('sunday_services.index') }}" class="hover:text-church-gold transition-colors">Jadwal Kebaktian Minggu</a></li>
                <li><a href="{{ route('announcement.index') }}" class="hover:text-church-gold transition-colors">Warta</a></li>
                <li><a href="{{ route('devotion.index') }}" class="hover:text-church-gold transition-colors">Renungan Harian</a></li>
                <li><a href="{{ route('contact_us.index') }}" class="hover:text-church-gold transition-colors">Hubungi Kami</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-lg sm:text-xl mb-2 text-church-gold">Alamat</h4>
            <p class="text-sm sm:text-base text-white/50 mb-6">{{ $abouts->where('name', 'Alamat')->first()?->description ?? '-' }}</p>
            <h4 class="font-bold text-lg sm:text-xl mb-2 text-church-gold">Nomor Telepon/WhatsApp</h4>
            <p class="text-sm sm:text-base text-white/50 mb-6">{{ $abouts->where('name', 'Nomor Telepon / WhatsApp')->first()?->description ?? '-' }}</p>
            <h4 class="font-bold text-lg sm:text-xl mb-2 text-church-gold">Email</h4>
            <p class="text-sm sm:text-base text-white/50 mb-6">{{ $abouts->where('name', 'Email')->first()?->description ?? '-' }}</p>
        </div>
    </div>
    <div class="max-w-7xl mx-auto mt-20 pt-8 border-t border-white/10 text-center text-xs sm:text-sm uppercase tracking-widest text-white/20">
        &copy; 2026 GKI Sudirman Bandung
    </div>
</footer>