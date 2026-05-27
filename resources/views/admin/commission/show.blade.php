@extends('components.admin.layout')

@section('page_title', 'Kelola Komisi')

@section('title', 'Admin - Komisi')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <a href="{{ route('admin.commission.index') }}" class="text-sm font-medium text-gray-500 hover:text-church-gold mb-3 inline-flex items-center transition-colors">
            <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </div>
            Kembali
        </a>
        <h2 class="text-3xl font-bold text-church-dark mt-1">Detail Komisi</h2>
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden relative">
            <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-br from-church-gold to-yellow-600"></div>
            <div class="px-6 pt-12 pb-6 relative z-10 flex flex-col items-center">
                <div class="w-24 h-24 bg-white rounded-full border-4 border-white shadow-lg flex items-center justify-center text-4xl text-church-gold mb-4 relative z-10 z-20">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="text-xl font-bold text-church-dark mb-4 text-center">Komisi {{ $commission->name }}</h3>
                <div class="w-full bg-gray-50 rounded-xl p-4 border border-gray-100 mb-6">
                    <div class="flex items-start gap-3 mb-4">
                        <div>
                            <p class="text-sm text-gray-500 font-bold">Jadwal Persekutuan</p>
                            <p class="text-sm font-bold text-church-dark mt-0.5">Setiap {{ $commission->day }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 mb-4">
                        <div>
                            <p class="text-sm text-gray-500 font-bold">Waktu</p>
                            <p class="text-sm font-bold text-church-dark mt-0.5">{{ substr($commission->time_start, 0, 5) }} - {{ substr($commission->time_end, 0, 5) }} WIB</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div>
                            <p class="text-sm text-gray-500 font-bold">Lokasi</p>
                            <p class="text-sm font-bold text-church-dark mt-0.5">{{ $commission->room }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center w-full mt-6 pt-4 border-t border-gray-100">
                    <div class="grid grid-cols-3 gap-6 text-center w-full">
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-1">Total Jemaat</p>
                            <p class="text-lg font-bold text-church-dark">
                                {{ $members->count() }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-1">Aktif</p>
                            <p class="text-lg font-bold text-green-600">
                                {{ $members->where('is_active', 1)->count() }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-1">Non-Aktif</p>
                            <p class="text-lg font-bold text-red-500">
                                {{ $members->where('is_active', 0)->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col">
            <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-church-dark text-base flex items-center gap-2">
                    Anggota Komisi
                </h3>
            </div>
            <div class="p-4 space-y-3 relative">
                @forelse ($members as $member)
                <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-xl transition-colors border border-transparent hover:border-gray-100 {{ $member->is_active == 0 ? 'opacity-50' : '' }}">
                    <div class="h-10 w-10 rounded-full overflow-hidden flex items-center justify-center bg-church-gold">
                        @if($member->image_url)
                            <img src="{{ asset('storage/' . $member->image_url) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user text-church-dark"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-church-dark text-sm">{{ $member->name }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $member->memberStatus }} • {{ $member->birth_date_formatted }}</div>
                    </div>
                    <div>
                        <a href="{{ route('admin.member.show', $member->id) }}" class="px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-100">Lihat Profil</a>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-6">Belum ada anggota jemaat yang terdaftar di komisi ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
