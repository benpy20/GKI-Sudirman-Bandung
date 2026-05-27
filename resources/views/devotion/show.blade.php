@extends('components.layout')

@section('title')
    GKI Sudirman | Renungan Harian
@endsection

@section('content')
<div class="w-full">
    <a href="{{ route('devotion.index') }}" class="inline-flex items-center gap-2 text-church-dark/50 font-bold mb-8">
        <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        Kembali
    </a>
    <div class="bg-white p-6 rounded-2xl card-shadow border border-church-gold/30">
        <span class="text-xs sm:text-sm text-church-dark/50 font-bold mb-4 block">{{ $devotion->date }}</span>
        <h1 class="text-lg sm:text-xl font-bold mb-1 leading-tight">{{ $devotion->title }}</h1>
        <p class="text-sm sm:text-base text-church-dark/70 font-semibold mb-4">
            Bacaan: {{ $devotion->bible_verse }}
        </p>
        <div class="text-xs sm:text-sm flex items-center gap-2 opacity-50 italic pb-6 border-b border-black/5 mt-2">
            <span>Oleh: {{ $devotion->author }}</span>
        </div>
        <div class="text-church-dark/80 text-sm sm:text-base leading-relaxed py-4">
            {{ $devotion->content }}
        </div>
    </div>
</div>
@endsection
