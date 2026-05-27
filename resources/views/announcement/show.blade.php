@extends('components.layout')

@section('title')
    GKI Sudirman - Detail Warta
@endsection

@section('content')
<div class="w-full mx-auto">
    <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-church-dark/50 font-bold mb-8">
        <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        Kembali
    </a>
    <div class="bg-white rounded-2xl card-shadow border border-church-gold/30 overflow-hidden">
        @if ($announcement->image_url)
            <div x-data="{ open: false }" class="relative group">
                <img src="{{ asset('storage/' . $announcement->image_url) }}" @click="open = true" class="w-full h-[400px] object-cover cursor-zoom-in">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center pointer-events-none">
                    <span class="text-white text-sm font-semibold tracking-wide">
                        Lihat Detail Gambar
                    </span>
                </div>
                <div x-show="open" x-transition @click="open = false" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50" x-cloak>
                    <button @click="open = false" class="absolute top-6 right-6 text-white text-2xl hover:scale-110 transition cursor-pointer">
                        ✕
                    </button>
                    <img src="{{ asset('storage/' . $announcement->image_url) }}" class="max-w-[90%] max-h-[90%] object-contain">
                </div>
            </div>
        @endif
        <div class="bg-white p-6 rounded-2xl card-shadow border border-church-gold/30">
            <h1 class="text-lg sm:text-xl font-bold mb-1 leading-tight">{{ $announcement->title }}</h1>
            <div class="text-church-dark/80 text-sm sm:text-base leading-relaxed py-4">
                {!! nl2br(e($announcement->content)) !!}
            </div>
        </div>
    </div>
</div>
@endsection
