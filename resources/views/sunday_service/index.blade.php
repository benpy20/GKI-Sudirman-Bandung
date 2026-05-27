@extends('components.layout')

@section('title')
    GKI Sudirman - Jadwal Kebaktian
@endsection

@section('content')
<div class="w-full mx-auto">
    <div class="mb-10">
        <h2 class="text-3xl font-bold mb-2">
            Jadwal Kebaktian
        </h2>
        <div class="w-16 h-1 bg-church-gold mt-3 rounded-full"></div>
    </div>
    @forelse($categories as $category)
        @php
            $week1 = $category['data']['week1'] ?? null;
            $week2 = $category['data']['week2'] ?? null;

            $services1 = $getAllServices($week1);
            $services2 = $getAllServices($week2);

            $allFields = $services1->keys()->merge($services2->keys())->unique();
        @endphp
        <div class="mb-12">
            <div class="bg-white rounded-2xl card-shadow border border-black/5 overflow-hidden">
                <div class="p-5 border-b border-black/5 bg-church-warm/10 flex items-center justify-between">
                    <h3 class="font-bold text-church-dark text-lg sm:text-xl">
                        {{ $category['label'] }}
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse min-w-[700px] text-left">
                        <thead>
                            <tr class="bg-church-warm/20 border-b border-black/5">
                                <th class="px-5 py-3 w-1/3 font-bold text-church-dark text-sm sm:text-base">Tanggal</th>
                                <th class="px-5 py-3 w-1/3 text-center font-bold text-church-dark text-sm sm:text-base border-l border-black/5">
                                    {{ $formatDate($week1?->date) }}
                                </th>
                                <th class="px-5 py-3 w-1/3 text-center font-bold text-church-dark text-sm sm:text-base border-l border-black/5">
                                    {{ $formatDate($week2?->date) }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black/5 text-church-dark/80">
                            <tr class="hover:bg-church-warm/10 transition-colors">
                                <td class="px-5 py-3 font-bold text-church-dark text-sm sm:text-base">Tema Khotbah</td>
                                <td class="px-5 py-3 text-center font-semibold text-church-dark border-l border-black/5 text-sm sm:text-base">
                                    {{ $week1?->title ?? '-' }}
                                </td>
                                <td class="px-5 py-3 text-center font-semibold text-church-dark border-l border-black/5 text-sm sm:text-base">
                                    {{ $week2?->title ?? '-' }}
                                </td>
                            </tr>
                            <tr class="hover:bg-church-warm/10 transition-colors">
                                <td class="px-5 py-3 font-bold text-church-dark text-sm sm:text-base">Nats Alkitab</td>
                                <td class="px-5 py-3 text-center font-semibold text-church-dark border-l border-black/5 text-sm sm:text-base">
                                    {{ $week1?->bible_verse ?? '-' }}
                                </td>
                                <td class="px-5 py-3 text-center font-semibold text-church-dark border-l border-black/5 text-sm sm:text-base">
                                    {{ $week2?->bible_verse ?? '-' }}
                                </td>
                            </tr>
                            @if($week1?->liturgical_calendars || $week2?->liturgical_calendars)
                                <tr class="hover:bg-church-warm/10 transition-colors">
                                    <td class="px-5 py-3 font-bold text-church-dark text-sm sm:text-base">Nats Alkitab</td>
                                    <td class="px-5 py-3 text-center font-semibold text-church-dark border-l border-black/5 text-sm sm:text-base">
                                        {{ $week1?->liturgical_calendars?->name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3 text-center font-semibold text-church-dark border-l border-black/5 text-sm sm:text-base">
                                        {{ $week2?->liturgical_calendars?->name ?? '-' }}
                                    </td>
                                </tr>
                                <tr class="hover:bg-church-warm/10 transition-colors">
                                    <td class="px-5 py-3 font-bold text-church-dark text-sm sm:text-base">Warna</td>
                                    <td class="px-5 py-3 text-center font-semibold text-church-dark border-l border-black/5 text-sm sm:text-base">
                                        {{ $week1?->liturgical_calendars?->color ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3 text-center font-semibold text-church-dark border-l border-black/5 text-sm sm:text-base">
                                        {{ $week2?->liturgical_calendars?->color ?? '-' }}
                                    </td>
                                </tr>
                            @endif
                            <tr class="hover:bg-church-warm/10 transition-colors">
                                <td class="px-5 py-3 font-bold text-church-dark text-sm sm:text-base">Pelayan Firman</td>
                                <td class="px-5 py-3 text-center border-l border-black/5 text-sm sm:text-base">
                                    {{ $week1?->preachers?->name ?? '-' }}
                                </td>
                                <td class="px-5 py-3 text-center border-l border-black/5 text-sm sm:text-base">
                                    {{ $week2?->preachers?->name ?? '-' }}
                                </td>
                            </tr>
                            <tr class="hover:bg-church-warm/10 transition-colors">
                                <td class="px-5 py-3 font-bold text-church-dark text-sm sm:text-base">Basis Jemaat</td>
                                <td class="px-5 py-3 text-center border-l border-black/5 text-sm sm:text-base">
                                    {{ $week1?->preachers?->base ?? '-' }}
                                </td>
                                <td class="px-5 py-3 text-center border-l border-black/5 text-sm sm:text-base">
                                    {{ $week2?->preachers?->base ?? '-' }}
                                </td>
                            </tr>
                            @foreach($allFields as $field)
                                <tr class="hover:bg-church-warm/10 transition-colors">
                                    <td class="px-5 py-3 font-bold text-church-dark text-sm sm:text-base">
                                        {{ $field }}
                                    </td>
                                    <td class="px-5 py-3 text-center border-l border-black/5 leading-relaxed text-sm sm:text-base">
                                        {!! nl2br(e($services1[$field]['names'] ?? '-')) !!}
                                    </td>
                                    <td class="px-5 py-3 text-center border-l border-black/5 leading-relaxed text-sm sm:text-base">
                                        {!! nl2br(e($services2[$field]['names'] ?? '-')) !!}
                                    </td>
                                </tr>
                            @endforeach
                            @if($week1?->video_url || $week2?->video_url)
                                <tr class="hover:bg-church-warm/10 transition-colors">
                                    <td class="px-5 py-3 font-bold text-church-dark text-sm sm:text-base">
                                        Video Youtube
                                    </td>
                                    <td class="px-5 py-3 text-center border-l border-black/5 leading-relaxed text-sm sm:text-base">
                                        <a href="{{ $week1?->video_url }}" target="_blank" class="italic hover:underline">
                                            {{ $week1?->video_url ?? '-' }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-3 text-center border-l border-black/5 leading-relaxed text-sm sm:text-base">
                                        <a href="{{ $week2?->video_url }}" target="_blank" class="italic hover:underline">
                                            {{ $week2?->video_url ?? '-' }}
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            @if($week1?->description || $week2?->description)
                            <tr class="hover:bg-church-warm/10 transition-colors">
                                <td class="px-5 py-3 font-bold text-church-dark text-sm sm:text-base">
                                    Keterangan
                                </td>
                                <td class="px-5 py-3 text-center border-l border-black/5 leading-relaxed text-sm sm:text-base">
                                    {!! nl2br(e($week1?->description ?? '-')) !!}
                                </td>
                                <td class="px-5 py-3 text-center border-l border-black/5 leading-relaxed text-sm sm:text-base">
                                    {!! nl2br(e($week2?->description ?? '-')) !!}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl p-10 md:p-12 card-shadow border border-black/5 text-center">
            <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center bg-church-gold/10 rounded-full text-church-gold text-2xl">
                <i class="fas fa-church"></i>
            </div>
            <h3 class="text-xl font-bold mb-3">
                Belum ada jadwal kebaktian
            </h3>
            <p class="text-church-dark/60 text-sm max-w-md mx-auto">
                Jadwal kebaktian untuk minggu yang akan datang belum tersedia. <br>Silakan cek kembali nanti.
            </p>
        </div>
    @endforelse
</div>
@endsection