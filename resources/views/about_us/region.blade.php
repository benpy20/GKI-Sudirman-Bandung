@extends('components.layout')

@section('title')
    GKI Sudirman - Rayon
@endsection

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-bold mb-2">Rayon</h2>
    <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
</div>

<div class="mb-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full mx-auto">
        @foreach($regions as $region)
            <div class="bg-white p-6 rounded-2xl border border-black/5 card-shadow flex flex-col items-center text-center gap-4">
                <div>
                    <h4 class="font-bold text-lg sm:text-xl mb-1">{{ $region->name }}</h4>
                    <p class="text-sm sm:text-base opacity-70">{{ $region->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
