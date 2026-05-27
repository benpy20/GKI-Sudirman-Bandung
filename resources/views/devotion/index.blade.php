@extends('components.layout')

@section('title')
    GKI Sudirman | Renungan Harian
@endsection

@section('content')
<div>
    <div class="mb-10">
        <h2 class="text-3xl font-bold mb-2">
            Renungan Harian
        </h2>
        <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
    </div>
    <div class="flex flex-wrap gap-3 mb-10">
        @foreach($devotionCategories as $category)
            <a href="{{ route('devotion.index', ['category' => $category['value']]) }}" class="px-5 py-2 text-sm sm:text-base rounded-full bg-white border border-black/5
            {{ $selectedCategory == $category['value'] ? 'text-church-gold border-church-gold/30' : 'text-church-dark/60' }}">
                {{ $category['label'] }}
            </a>
        @endforeach
    </div>
    @if($featuredDevotion)
        <div class="bg-white rounded-2xl p-4 sm:p-6 card-shadow border border-church-gold/30">
            <div class="mb-4 flex items-center justify-between">
                <span class="text-church-gold font-bold text-sm uppercase mr-4">Renungan Hari Ini</span>
                <span class="px-4 py-1 text-xs sm:text-sm rounded-full bg-church-gold/10 text-church-gold font-semibold">
                    {{ $featuredDevotion->category_name }}
                </span>
            </div>
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="text-xs sm:text-sm font-bold opacity-50">
                    {{ $featuredDevotion->formatted_date }}
                </span>
            </div>
            <h2 class="text-lg sm:text-xl font-bold mb-1 leading-tight">
                {{ $featuredDevotion->title }}
            </h2>
            <p class="text-sm sm:text-base font-semibold text-church-dark/70 mb-3">
                Bacaan: {{ $featuredDevotion->bible_verse }}
            </p>
            <p class="text-church-dark/60 text-sm sm:text-base leading-relaxed line-clamp-2 mb-6">
                {{ $featuredDevotion->content }}
            </p>
            <div class="flex items-center justify-between flex-wrap gap-4">
                <span class="text-xs sm:text-sm italic opacity-50">
                    Oleh: {{ $featuredDevotion->author }}
                </span>
                <a href="{{ route('devotion.show', $featuredDevotion->id) }}" class="inline-flex items-center gap-2 text-sm sm:text-base text-church-gold font-semibold">
                    Baca Renungan
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl p-10 md:p-12 card-shadow border border-black/5 text-center">
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
    @endif
    <div class="space-y-5 mt-10">
        @forelse($groupedDevotions as $month => $items)
            <div class="bg-white rounded-2xl border border-black/5 overflow-hidden card-shadow" x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between p-6 text-left hover:bg-church-warm/20 transition-colors cursor-pointer">
                    <div>
                        <h3 class="text-base font-bold">
                            Renungan {{ $month }}
                        </h3>
                    </div>
                    <i class="fa-solid fa-chevron-down transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-transition class="border-t border-black/5">
                    @foreach($items as $devotion)
                        <a href="{{ route('devotion.show', $devotion->id) }}" class="flex items-center justify-between gap-4 p-5 hover:bg-church-warm/20 transition-colors border-b border-black/5 last:border-0">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                    <span class="text-xs opacity-50">
                                        {{ $devotion->formatted_date }}
                                    </span>
                                </div>
                                <h4 class="font-bold truncate mb-1">
                                    {{ $devotion->title }}
                                </h4>
                                @if($devotion->bible_verse)
                                    <p class="text-xs font-semibold text-church-dark/70 truncate mb-1">
                                        {{ $devotion->bible_verse }}
                                    </p>
                                @endif
                            </div>
                            <i class="fa-solid fa-arrow-right text-church-gold shrink-0"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-6 text-center card-shadow border border-black/5">
                <h3 class="text-base font-bold mb-2">
                    Belum ada riwayat renungan
                </h3>
                <p class="text-church-dark/50 text-sm">
                    Data riwayat renungan harian belum tersedia
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection