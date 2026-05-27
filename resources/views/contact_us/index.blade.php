@extends('components.layout')

@section('title')
    GKI Sudirman
@endsection

@section('content')
    <div class="mb-10">
        <h2 class="text-3xl font-bold mb-2">Hubungi Kami</h2>
        <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl p-8 card-shadow border border-black/5">
            <div class="mb-8">
                <h3 class="text-lg sm:text-xl font-bold mb-2">Informasi Kontak</h3>
            </div>
            <div class="space-y-6">
                @foreach($abouts as $about)
                    @if ($about->name === 'Alamat')
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 flex items-center justify-center bg-church-gold/10 rounded-2xl text-church-gold shrink-0">
                                <i class="fa-solid fa-location-dot text-xl"></i>
                            </div>
                            <div class="space-y-1">
                                <h4 class="font-bold text-sm sm:text-base">{{ $about->name }}</h4>
                                <p class="text-sm sm:text-base text-church-dark/60">{{ $about->description }}</p>
                            </div>
                        </div>
                    @elseif($about->name === 'Email')
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 flex items-center justify-center bg-church-gold/10 rounded-2xl text-church-gold shrink-0">
                                <i class="fa-solid fa-envelope text-xl"></i>
                            </div>
                            <div class="space-y-1">
                                <h4 class="font-bold text-sm sm:text-base">{{ $about->name }}</h4>
                                <p class="text-sm sm:text-base text-church-dark/60">{{ $about->description }}</p>
                            </div>
                        </div>
                    @elseif($about->name === 'Nomor Telepon / WhatsApp')
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 flex items-center justify-center bg-church-gold/10 rounded-2xl text-church-gold shrink-0">
                                <i class="fa-solid fa-phone text-xl"></i>
                            </div>
                            <div class="space-y-1">
                                <h4 class="font-bold text-sm sm:text-base">{{ $about->name }}</h4>
                                <p class="text-sm sm:text-base text-church-dark/60">{{ $about->description }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="pt-8 mt-8 border-t border-black/10">
                <h3 class="text-lg sm:text-xl font-bold mb-5">Sosial Media</h3>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($abouts as $about)
                        @if($about->name === 'YouTube')
                            <div class="flex justify-center">
                                <div class="w-full max-w-[110px] flex flex-col items-center text-center py-4 rounded-2xl">
                                    <a href="{{ $about->description }}" target="_blank" class="w-12 h-12 flex items-center justify-center bg-church-gold/10 rounded-xl text-church-gold mb-2">
                                        <i class="fa-brands fa-youtube text-xl"></i>
                                    </a>
                                    <a href="{{ $about->description }}" target="_blank" class="font-semibold text-sm sm:text-base">
                                        {{ $about->name }}
                                    </a>
                                </div>
                            </div>
                        @elseif($about->name === 'Instagram')
                            <div class="flex justify-center">
                                <div class="w-full max-w-[110px] flex flex-col items-center text-center py-4 rounded-2xl">
                                    <a href="{{ $about->description }}" target="_blank" class="w-12 h-12 flex items-center justify-center bg-church-gold/10 rounded-xl text-church-gold mb-2">
                                        <i class="fa-brands fa-instagram text-xl"></i>
                                    </a>
                                    <a href="{{ $about->description }}" target="_blank" class="font-semibold text-sm sm:text-base">
                                        {{ $about->name }}
                                    </a>
                                </div>
                            </div>
                        @elseif($about->name === 'Media Sosial Lainnya')
                            <div class="flex justify-center">
                                <div class="w-full max-w-[110px] flex flex-col items-center text-center py-4 rounded-2xl">
                                    <a href="{{ $about->description }}" target="_blank" class="w-12 h-12 flex items-center justify-center bg-church-gold/10 rounded-xl text-church-gold mb-2">
                                        <i class="fa-solid fa-ellipsis text-xl"></i>
                                    </a>
                                    <a href="{{ $about->description }}" target="_blank" class="font-semibold text-sm sm:text-base">
                                        Lainnya
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="pt-8 mt-8 border-t border-black/10">
                <h3 class="text-lg sm:text-xl font-bold mb-4">Informasi Penting Lainnya</h3>
                @foreach($abouts as $about)
                    @if($about->name === 'Informasi Penting')
                        <div class="bg-church-gold/5 rounded-xl px-4 py-4">
                            <p class="text-sm sm:text-base text-church-dark/80 leading-relaxed">
                                {!! nl2br(e($about->description)) !!}
                            </p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @foreach($abouts as $about)
            @if($about->name === 'Google Maps')
                <div class="bg-white rounded-2xl p-3 card-shadow border border-black/5 overflow-hidden">
                    <iframe src="{{ $about->description }}" width="100%" height="100%" class="min-h-[500px] rounded-2xl" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            @endif
        @endforeach
    </div>
@endsection