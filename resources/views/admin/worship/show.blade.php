@extends('components.admin.layout')

@section('page_title', 'Kelola Jadwal Kebaktian')

@section('title', 'Admin - Jadwal Kebaktian')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <a href="{{ route('admin.worship.index') }}" class="text-sm font-medium text-gray-500 hover:text-church-gold mb-3 inline-flex items-center transition-colors">
            <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </div>
            Kembali
        </a>
        <h2 class="text-3xl font-bold text-church-dark mt-1">Detail Jadwal Kebaktian</h2>
        <div class="flex flex-wrap items-center gap-3 mt-3">
            <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-white border border-gray-200 shadow-sm text-gray-700">
                <i class="far fa-calendar-alt text-gray-400 mr-2"></i>{{ $worship->date_formatted }}
            </div>
            <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-white border border-gray-200 shadow-sm text-gray-700">
                <i class="far fa-clock text-church-gold mr-2"></i> {{ $worship->category_label }} ({{ $worship->time_formatted }})
            </div>
            @if ($worship->liturgical_calendars)
                @php
                    $colors = [
                        'Ungu' => ['bg-purple-50 text-purple-700 border-purple-100', 'bg-purple-600'],
                        'Hijau' => ['bg-green-50 text-green-700 border-green-100', 'bg-green-600'],
                        'Merah' => ['bg-red-50 text-red-700 border-red-100', 'bg-red-600'],
                        'Putih' => ['bg-gray-50 text-gray-700 border-gray-200', 'bg-gray-200'],
                        'Hitam' => ['bg-gray-500 text-white border-gray-800', 'bg-black'],
                    ];
                    [$colorClass, $dot] = $colors[$worship->liturgical_calendars->color] ?? ['bg-gray-50 text-gray-700 border-gray-200', 'bg-gray-400'];
                @endphp
                <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold {{ $colorClass }} border shadow-sm">
                    <div class="w-2 h-2 rounded-full {{ $dot }} mr-2"></div>
                    {{ $worship->liturgical_calendars->name }}
                </div>
            @endif
        </div>
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
            <div class="px-6 py-5 border-b border-gray-50 bg-church-warm/20">
                <h3 class="text-base font-bold text-church-dark flex items-center gap-2">
                    Informasi Kebaktian
                </h3>
            </div>
            <div class="p-6 md:p-8">
                <p class="text-sm font-bold text-gray-400 mb-1">Judul Khotbah</p>
                <h3 class="text-base font-bold text-church-dark leading-tight mb-6">
                    {{ $worship->title }}
                </h3>
                <div class="space-y-5">
                    <div class="flex gap-4">
                        <div>
                            <p class="text-sm font-bold text-gray-400 mb-1">Bacaan Alkitab</p>
                            <p class="text-sm font-bold text-gray-800">{{ $worship->bible_verse }}</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <p class="text-sm font-bold text-gray-400 mb-1">Pengkhotbah</p>
                            <p class="text-sm font-bold text-gray-800">{{ $worship->preachers->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $worship->preachers->base }}</p>
                        </div>
                    </div>
                    @if ($worship->description)
                        <div class="pt-5 border-t border-gray-100 mt-2">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Deskripsi Singkat</p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $worship->description }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if($worship->video_url)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="aspect-video bg-black relative overflow-hidden">
                    <iframe id="youtubeFrame" class="w-full h-full absolute top-0 left-0" 
                        frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>
                    </iframe>
                    <div id="videoFallback" class="absolute inset-0 flex items-center justify-center text-white text-sm bg-black/80 opacity-0 transition pointer-events-none">
                        Video tidak tersedia atau link tidak valid
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tautan Video/Live Streaming Youtube</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" readonly value="{{ $worship->video_url }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-500 font-mono outline-none">
                        <button onclick="copyLink(this)" type="button" class="cursor-pointer relative w-9 h-9 shrink-0 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors border border-gray-200">
                            <i class="far fa-copy"></i>
                            <span class="copy-bubble absolute -top-8 left-1/2 -translate-x-1/2 scale-90 opacity-0 bg-gray-800 text-white text-[10px] px-2 py-1 rounded transition-all duration-200 pointer-events-none">
                                Berhasil disalin!
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 bg-church-warm/20">
                <h3 class="text-base font-bold text-church-dark flex items-center gap-2">
                    Penatalayan Kebaktian
                </h3>
            </div>
            <div class="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-[700px] w-full text-left border-collapse">
                        <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($sunday_services as $steward_name => $members)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 w-1/3 align-top">
                                    <span class="font-bold text-gray-600 uppercase tracking-wide text-xs">
                                        {{ $steward_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-4">
                                        @foreach($members as $service)
                                            <div class="flex items-center justify-between gap-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-10 w-10 rounded-full bg-church-gold flex items-center justify-center">
                                                        <i class="fas fa-user text-church-dark" ></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-church-dark">
                                                            {{ $service->members->name }}
                                                        </div>
                                                        <div class="text-xs text-gray-400 mt-0.5">
                                                            {{ $service->members->memberStatus }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="{{ route('admin.member.show', $service->members->id) }}" class="px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-100">Lihat Profil</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center px-2 py-6 text-gray-400 text-sm">
                                    Belum ada penatalayan yang ditugaskan untuk jadwal kebaktian ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Untuk mengambil key video Youtube, dan copy link-->
<script>
    const youtubeUrl = "{{ $worship->video_url }}";
    function getYoutubeId(url) {
        const regex = /(?:youtube\.com\/(?:watch\?v=|live\/|embed\/)|youtu\.be\/)([^&\n?#]+)/;
        const match = url.match(regex);
        return match ? match[1] : null;
    }
    function initYoutube() {
        const videoId = getYoutubeId(youtubeUrl);
        const fallback = document.getElementById("videoFallback");
        if (!videoId) {
            fallback.classList.remove("opacity-0");
            return;
        }
        const iframe = document.getElementById("youtubeFrame");
        const embedUrl = `https://www.youtube.com/embed/${videoId}`;
        let loaded = false;
        // kalo iframe berhasil load
        iframe.onload = function () {
            loaded = true;
        };
        iframe.src = embedUrl;
        // cek setelah 3 detik
        setTimeout(() => {
            if (!loaded) {
                fallback.classList.remove("opacity-0");
            }
        }, 3000);
    }
    initYoutube();
    function copyLink(button) {
        navigator.clipboard.writeText(youtubeUrl)
        .then(() => {
            const bubble = button.querySelector(".copy-bubble");
            bubble.classList.remove("opacity-0", "scale-90");
            bubble.classList.add("opacity-100", "scale-100");
            setTimeout(() => {
                bubble.classList.remove("opacity-100", "scale-100");
                bubble.classList.add("opacity-0", "scale-90");
            }, 1500);
        })
        .catch(() => {
            console.error("Gagal menyalin link");
        });
    }
</script>
@endsection
