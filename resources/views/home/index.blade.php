@extends('components.layout')

@section('title')
    GKI Sudirman
@endsection

@section('content')
<section class="relative h-[75vh] sm:h-[60vh] lg:h-[75vh] min-h-[450px] w-full max-w-7xl mx-auto rounded-3xl overflow-hidden mb-16 group shadow-2xl">
    <img src="{{ asset('banner-gki-sudirman.png') }}" alt="GKI Sudirman" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-linear-to-r from-black/90 via-black/70 to-black/60 sm:via-black/50 sm:to-transparent group-hover:from-black/95"></div>
    <div class="absolute inset-0 flex flex-col justify-center p-6 sm:p-10 md:p-16 text-white">
        <div class="relative z-10 max-w-3xl">
            <h1 class="text-4xl sm:text-6xl font-bold mb-4 leading-tight drop-shadow-lg">
                Selamat Datang di <br class="hidden sm:block"> 
                <span class="text-church-gold drop-shadow-md">GKI Sudirman</span>
            </h1>
            @foreach ($abouts as $about)
                @if ($about->name === 'Tema Utama')
                    <div class="mb-8 max-w-2xl">
                        <p class="text-white/80 text-base sm:text-lg italic leading-relaxed border-l-2 border-church-gold/60 pl-4">
                            {{ $about->description }}
                        </p>
                    </div>
                @endif
            @endforeach
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <a href="{{ route('sunday_services.index') }}" 
                    class="w-full sm:w-auto text-base bg-church-gold hover:brightness-110 text-white px-8 py-3.5 rounded-full font-bold shadow-lg shadow-church-gold/30 hover:shadow-church-gold/60 text-center">
                    Jadwal Kebaktian
                </a>
                <a href="{{ route('contact_us.index') }}"
                    class="w-full sm:w-auto text-base bg-white/10  hover:bg-white/20 backdrop-blur-md border border-white/20 hover:border-white/40 px-8 py-3.5 rounded-full font-bold text-center">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <div class="lg:col-span-2 space-y-16">
        <section>
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Renungan Hari Ini</h2>
                    <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
                </div>
                <a href="{{ route('devotion.index') }}" class="hidden sm:block text-sm sm:text-base font-bold text-church-gold">Lihat Semua Renungan &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse ($devotions as $devotion)
                    <a href="{{ route('devotion.show', $devotion->id) }}"
                    class="bg-white rounded-2xl border border-black/5 p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-church-gold/10 text-church-gold">
                                {{ $devotion->formatted_date }}
                            </span>
                            <span class="px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-black/5 text-church-dark/70">
                                {{ $devotion->devotionCategory }}
                            </span>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-church-dark mb-1 leading-snug group-hover:text-church-gold transition-colors line-clamp-2">
                            {{ $devotion->title }}
                        </h3>
                        <p class="text-sm sm:text-base font-semibold text-church-dark/70 mb-4">
                            Bacaan: {{ $devotion->bible_verse }}
                        </p>
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-black/5">
                            <span class="text-xs sm:text-sm text-church-dark/40 italic">
                                Oleh: {{ $devotion->author }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-3xl p-10 md:p-12 card-shadow border border-black/5 text-center">
                            <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center bg-church-gold/10 rounded-full text-church-gold text-2xl">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                Belum ada renungan untuk hari ini
                            </h3>
                            <p class="text-church-dark/60 text-sm max-w-md mx-auto">
                                Renungan untuk hari ini belum tersedia. <br>Silakan cek kembali nanti.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
            <!-- Tombol hidden utk tampilan mobile -->
            <a href="{{ route('devotion.index') }}" class="block sm:hidden text-center mt-6 text-sm sm:text-base font-bold text-church-gold">Lihat Semua Renungan &rarr;</a>
        </section>
        <section>
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Warta Jemaat</h2>
                    <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
                </div>
                <a href="{{ route('announcement.index') }}" class="hidden sm:block text-sm sm:text-base font-bold text-church-gold">Lihat Semua Warta &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse ($announcements as $announcement)
                    <a href="{{ route('announcement.show', $announcement->id) }}"
                    class="bg-white rounded-2xl border border-black/5 p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-black/5 text-church-dark/70">
                                {{ $announcement->announcementCategory }}
                            </span>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-church-dark mb-1 leading-snug group-hover:text-church-gold transition-colors line-clamp-2">
                            {{ $announcement->title }}
                        </h3>
                        <p class="text-sm sm:text-base text-church-dark/60 leading-relaxed line-clamp-2">
                            {{ $announcement->content }}
                        </p>
                    </a>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-3xl p-10 md:p-12 card-shadow border border-black/5 text-center">
                            <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center bg-church-gold/10 rounded-full text-church-gold text-2xl">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                Belum ada warta jemaat untuk hari ini
                            </h3>
                            <p class="text-church-dark/60 text-sm max-w-md mx-auto">
                                Warta jemaat untuk hari ini belum tersedia. <br>Silakan cek kembali nanti.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
            <!-- Tombol hidden utk tampilan mobile -->
            <a href="{{ route('announcement.index') }}" class="block sm:hidden text-center mt-6 text-sm sm:text-base font-bold text-church-gold">Lihat Semua Warta &rarr;</a>
        </section>
        <section>
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Kebaktian Minggu</h2>
                    <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
                </div>
                <a href="{{ route('sunday_services.index') }}" class="hidden sm:block text-sm sm:text-base font-bold text-church-gold">Lihat Jadwal Kebaktian &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($worships as $worship)
                    <div class="bg-white rounded-2xl border border-black/5 p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300 group">
                        <div class="aspect-video bg-black relative overflow-hidden rounded-xl mb-4">
                            @if($worship->video_url)
                                <iframe id="youtubeFrame{{ $worship->id }}" class="w-full h-full absolute top-0 left-0"
                                    frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                </iframe>
                                <div id="fallback{{ $worship->id }}"
                                    class="absolute inset-0 flex items-center justify-center text-white text-sm bg-black/80 opacity-0 transition pointer-events-none">
                                    Video tidak tersedia atau link tidak valid
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-black/90 to-black/70 text-white">
                                    <span class="text-sm font-semibold">
                                        Video tidak tersedia
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col flex-grow">
                            <div class="mb-3">
                                <span class="px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-church-gold/10 text-church-gold">
                                    {{ $worship->date_formatted }}
                                </span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-church-dark mb-2 leading-snug group-hover:text-church-gold transition-colors line-clamp-2">
                                {{ $worship->title }}
                            </h3>
                            <p class="text-sm text-church-dark/60">
                                {{ $worship->preachers?->name ?? '-' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-3xl p-10 md:p-12 card-shadow border border-black/5 text-center">
                            <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center bg-church-gold/10 rounded-full text-church-gold text-2xl">
                                <i class="fas fa-church"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                Belum ada video kebaktian terbaru
                            </h3>
                            <p class="text-church-dark/60 text-sm max-w-md mx-auto">
                                Video kebaktian terbaru belum tersedia. <br>Silakan cek kembali nanti.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
            <!-- Tombol hidden utk tampilan mobile -->
            <a href="{{ route('sunday_services.index') }}" class="block sm:hidden text-center mt-6 text-sm sm:text-base font-bold text-church-gold">Lihat Jadwal Kebaktian &rarr;</a>
        </section>
    </div>
    <div class="space-y-12">
        <section>
            <div class="mb-6 flex flex-col items-start">
                <h3 class="text-2xl font-bold mb-2 flex items-center gap-3">
                    Kegiatan Mingguan
                </h3>
                <div class="w-16 h-1 bg-church-gold rounded-full"></div>
            </div>
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-black/5">
                <ol class="border-l-2 border-church-gold/20 ml-3 space-y-8">  
                    @forelse ($commissions as $day => $items)
                        <li class="relative pl-6">            
                            <span class="absolute w-4 h-4 bg-church-gold rounded-full -left-[9px] ring-4 ring-white top-1"></span>
                            <h4 class="font-bold text-church-dark text-base sm:text-lg mb-4">
                                {{ $day }}
                            </h4>
                            <div class="space-y-4">
                                @foreach ($items as $item)
                                    <div>
                                        <h5 class="font-bold text-church-dark/80 text-sm sm:text-base">
                                            @if($item->name === "Umum")
                                                Ibadah {{ $item->name }}
                                            @else
                                                Persekutuan {{ $item ->name }}
                                            @endif
                                        </h5>
                                        <p class="text-sm sm:text-base text-church-dark/60 mt-0.5">
                                            Waktu: Pk. {{ $item->time_start_formatted }} - {{ $item->time_end_formatted }} WIB
                                        </p>
                                        @if($item->room)
                                            <p class="text-sm sm:text-base text-church-dark/60 mt-0.5">
                                                Tempat: {{ $item->room }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </li>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-sm text-church-dark/60 italic">Belum ada kegiatan mingguan.</p>
                        </div>
                    @endforelse
                </ol>
            </div>
        </section>
        <section>
            <div class="mb-6 flex flex-col items-start">
                <h3 class="text-2xl font-bold mb-2 flex items-center gap-3">
                    Ulang Tahun Jemaat
                </h3>
                <div class="w-12 h-1 bg-church-gold/50 rounded-full"></div>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-black/5 space-y-4">
                @if($members->isNotEmpty())
                <div class="flex items-center gap-3 mb-4">
                    <h4 class="font-bold text-sm sm:text-base">
                        Daftar jemaat yang berulang tahun minggu lalu dan minggu ini
                    </h4>
                </div>
                @endif
                @forelse ($members as $member)
                    <div class="flex items-center justify-between border-b border-black/5 pb-3">
                        <span class="text-sm sm:text-base text-church-dark">{{ $member->name }}</span>
                        <span class="text-sm sm:text-base text-church-dark/50 bg-black/5 px-2 py-1 rounded-md">{{ $member->birth_date_formatted }}</span>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-sm text-church-dark/60 italic">Tidak ada anggota yang berulang tahun pada minggu lalu dan minggu ini.</p>
                    </div>
                @endforelse
                @if($members->isNotEmpty())
                    <div class="pt-2 text-center">
                        <p class="text-sm text-church-dark/50 italic">Seluruh majelis dan jemaat mengucapkan selamat ulang tahun. Kiranya Tuhan memberkati saudara/saudari sekalian.</p>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>

<script>
function getYoutubeId(url) {
    const regex = /(?:youtube\.com\/(?:watch\?v=|live\/|embed\/)|youtu\.be\/)([^&\n?#]+)/;
    const match = url.match(regex);
    return match ? match[1] : null;
}

document.addEventListener("DOMContentLoaded", function () {

    @foreach($worships as $worship)

        (function() {
            const url = @json($worship->video_url);
            const videoId = getYoutubeId(url);

            const iframe = document.getElementById("youtubeFrame{{ $worship->id }}");
            const fallback = document.getElementById("fallback{{ $worship->id }}");

            if (!videoId) {
                fallback.classList.remove("opacity-0");
                return;
            }

            iframe.src = `https://www.youtube.com/embed/${videoId}`;

            let loaded = false;

            iframe.onload = function () {
                loaded = true;
            };

            setTimeout(() => {
                if (!loaded) {
                    fallback.classList.remove("opacity-0");
                }
            }, 3000);

        })();

    @endforeach

});
</script>
@endsection