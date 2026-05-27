@extends('components.admin.layout')

@section('page_title', 'Kelola Pelayanan')

@section('title', 'Admin - Pelayanan')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <a href="{{ route('admin.steward.index') }}" class="text-sm font-medium text-gray-500 hover:text-church-gold mb-3 inline-flex items-center transition-colors">
            <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </div>
            Kembali
        </a>
        <h2 class="text-3xl font-bold text-church-dark mt-1">Detail Pelayanan</h2>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="md:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-center">
            <div class="h-20 bg-gradient-to-r from-church-gold to-yellow-600"></div>
            <div class="relative px-6 pb-6 -mt-10">
                <div class="w-20 h-20 rounded-2xl bg-white p-1.5 mx-auto shadow-md mb-4 flex items-center justify-center border border-gray-100">
                    <div class="w-full h-full rounded-xl bg-gradient-to-br from-church-gold to-yellow-600 flex items-center justify-center text-2xl text-church-dark">
                        <i class="fas fa-pray"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-church-dark">{{ $steward->field }}</h3>
                <p class="text-sm font-medium text-gray-500 mt-2">{{ $steward->commission?->name ? 'Komisi ' . $steward->commission->name : 'Bidang Umum' }}</p>
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
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-base font-bold text-church-dark">Anggota Pelayanan</h3>
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
                <p class="text-sm text-gray-500 text-center py-6">Belum ada anggota jemaat yang terdaftar di pelayanan ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
