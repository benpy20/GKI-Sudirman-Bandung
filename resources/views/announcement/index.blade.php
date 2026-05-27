@extends('components.layout')

@section('title')
    GKI Sudirman - Warta Jemaat
@endsection

@section('content')
<div class="w-full mx-auto">
    <div class="mb-10">
        <h2 class="text-3xl font-bold mb-2">
            Warta Jemaat
        </h2>
        <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
    </div>

    <div class="bg-white rounded-2xl p-5 card-shadow border border-black/5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($announcements as $announcement)
                @if ($announcement->show_category)
                    <div class="col-span-full mt-6 first:mt-0">
                        @if (!$loop->first)
                            <div class="w-full h-px bg-church-gold/30 mb-6"></div>
                        @endif
                        <div class="flex items-center gap-4 mb-2">
                            <h3 class="text-lg sm:text-xl font-bold text-church-dark">
                                Bidang {{ $announcement->category_name }}
                            </h3>
                        </div>
                    </div>
                @endif
                
                <div class="bg-white rounded-2xl overflow-hidden border border-church-gold/30 flex flex-col h-full">
                    <div class="relative overflow-hidden h-48 bg-church-warm/10 flex-shrink-0">
                        @if($announcement->image_url)
                            <img src="{{ asset('storage/' . $announcement->image_url) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-church-warm/40 to-church-gold/40"></div>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col flex-grow bg-church-warm/5 group-hover:bg-white transition-colors">
                        <h3 class="text-sm sm:text-base font-bold mb-3 text-church-dark group-hover:text-church-gold transition-colors">{{ $announcement->title }}</h3>
                        <p class="text-sm sm:text-base text-church-dark/60 mb-6 flex-grow leading-relaxed line-clamp-2">
                            {!! nl2br($announcement->content) !!}
                        </p>
                        <a href="{{ route('announcement.show', $announcement->id) }}" class="inline-flex items-center justify-between w-full py-3 px-4 bg-white border border-church-gold/30 text-church-gold rounded-xl  text-sm sm:text-base font-bold mt-auto hover:bg-church-gold hover:text-white transition-all group-hover:shadow-md">
                            Baca Selengkapnya
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-2xl p-10 md:p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center bg-church-gold/10 rounded-full text-church-gold text-2xl">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">
                            Belum ada warta jemaat
                        </h3>
                        <p class="text-church-dark/60 text-sm max-w-md mx-auto">
                            Warta jemaat yang sedang berlangsung belum tersedia. <br>Silakan cek kembali nanti.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection