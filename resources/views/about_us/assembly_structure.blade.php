@extends('components.layout')

@section('title')
    GKI Sudirman - Struktur Kemajelisan
@endsection

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-bold mb-2">Struktur Kemajelisan</h2>
    <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
</div>

@foreach($abouts as $about)
    @if($about->name === 'Struktur Kemajelisan')
        <div class="mb-14">
            <div class="bg-white rounded-2xl border border-black/5 card-shadow p-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h3 class="text-2xl font-bold text-church-dark mb-3">
                        Struktur Kemajelisan GKI Sudirman Bandung
                    </h3>
                    <p class="text-church-dark/70 leading-relaxed mb-6">
                        Untuk melihat susunan lengkap Majelis Jemaat GKI Sudirman Bandung, silakan tekan tautan berikut.
                    </p>
                    <a href="{{ $about->description }}"
                        target="_blank"
                        class="inline-flex items-center gap-3 px-6 py-3 rounded-xl bg-church-gold text-white font-semibold hover:scale-105 transition-all duration-300 shadow-md">
                        <i class="fas fa-external-link-alt"></i>
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    @endif
@endforeach

<div class="mb-10">
    <h3 class="text-xl font-bold mb-4">Pendeta Jemaat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full mx-auto">
        @foreach($members as $member)
            @if ($member->status == '1' || $member->status == '2' || $member->status == '3')
                <div class="bg-white p-6 rounded-2xl border border-black/5 card-shadow flex flex-col items-center text-center gap-4">
                    @if($member->image_url)
                        <img src="{{ asset('storage/' . $member->image_url) }}" alt="{{ $member->name }}" class="w-24 h-24 rounded-full object-cover">
                    @else
                        <div class="w-24 h-24 bg-church-gold/10 rounded-full flex items-center justify-center text-church-gold text-2xl">
                            <i class="fa fa-user text-4xl"></i>
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold sm:text-xl text-base mb-1">{{ $member->name }}</h4>
                        <p class="text-sm opacity-70">{{ $member->memberStatus }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<div>
    <h3 class="text-xl font-bold mb-4">Majelis Jemaat</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full mx-auto">
        @foreach($members as $member)
            @if ($member->status == '4' || $member->status == '5')
                <div class="bg-white p-6 rounded-2xl border border-black/5 card-shadow flex flex-col items-center text-center gap-4">
                    @if($member->image_url)
                        <img src="{{ asset('storage/' . $member->image_url) }}" alt="{{ $member->name }}" class="w-24 h-24 rounded-full object-cover">
                    @else
                        <div class="w-24 h-24 bg-church-gold/10 rounded-full flex items-center justify-center text-church-gold text-2xl">
                            <i class="fa fa-user text-4xl"></i>
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold sm:text-xl text-base mb-1">{{ $member->name }}</h4>
                        <p class="text-sm opacity-70">{{ $member->memberStatus }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
