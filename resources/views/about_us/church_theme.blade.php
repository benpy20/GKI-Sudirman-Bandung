@extends('components.layout')

@section('title')
    Tema Gereja - GKI Sudirman
@endsection

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-bold mb-2">Tema Gereja</h2>
    <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
</div>
<div class="w-full mx-auto space-y-4">
    @foreach($abouts as $about)
        @if($about->name === 'Tema Utama')
            <div class="bg-white rounded-2xl border border-black/5 overflow-hidden card-shadow"
                x-data="{ open: true }">
                <button @click="open = !open" class="cursor-pointer w-full flex items-center justify-between p-5 text-left transition-colors">
                    <span class="text-lg sm:text-xl font-bold">
                        Tema Utama GKI Sudirman
                    </span>
                    <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" class="p-5 text-church-dark/70 text-sm sm:text-base leading-relaxed border-t border-black/5">
                    {!! nl2br($about->description) !!}
                </div>
            </div>
        @endif
        @if($about->name === 'Tema GKI Sinwil Jabar')
            <div class="bg-white rounded-2xl border border-black/5 overflow-hidden card-shadow"
                x-data="{ open: true }">
                <button @click="open = !open" class="cursor-pointer w-full flex items-center justify-between p-5 text-left transition-colors">
                    <span class="text-lg sm:text-xl font-bold">
                        Tema GKI Sinode Wilayah Jawa Barat
                    </span>
                    <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" class="p-5 text-church-dark/70 text-sm sm:text-base leading-relaxed border-t border-black/5">
                    {!! nl2br($about->description) !!}
                </div>
            </div>
        @endif
    @endforeach
</div>
@endsection