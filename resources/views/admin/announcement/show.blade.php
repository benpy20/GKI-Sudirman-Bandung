@extends('components.admin.layout')

@section('page_title', 'Kelola Warta Jemaat')

@section('title', 'Admin - Warta Jemaat')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <a href="{{ route('admin.announcement.index') }}" class="text-sm font-medium text-gray-500 hover:text-church-gold mb-3 inline-flex items-center transition-colors">
            <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </div>
            Kembali
        </a>
        <h2 class="text-3xl font-bold text-church-dark mt-1">Detail Warta Jemaat</h2>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="md:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <h3 class="font-bold text-church-dark flex items-center gap-2">
                    Waktu Tayang
                </h3>
                <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold
                    @if($announcement->status === 'active')
                        bg-green-50 text-green-700 border-green-100
                    @elseif($announcement->status === 'upcoming')
                        bg-blue-50 text-blue-700 border-blue-100
                    @else
                        bg-red-50 text-red-700 border-red-100
                    @endif
                    shadow-sm
                ">
                    <span class="w-2 h-2 rounded-full mr-2
                        @if($announcement->status === 'active')
                            bg-green-500
                        @elseif($announcement->status === 'upcoming')
                            bg-blue-500
                        @else
                            bg-red-500
                        @endif
                    "></span>

                    @if($announcement->status === 'active')
                        Sedang Berjalan
                    @elseif($announcement->status === 'upcoming')
                        Mendatang
                    @else
                        Telah Berakhir
                    @endif
                </div>
            </div>
            <div class="p-6">
                <div class="flex flex-col gap-4">
                    <div class="flex items-start gap-3">
                        <div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Tanggal Mulai</div>
                            <div class="font-bold text-church-dark text-base">{{ $announcement->date_start }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Tanggal Berakhir</div>
                            <div class="font-bold text-church-dark text-base">{{ $announcement->date_end }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50">
                <h3 class="font-bold text-church-dark flex items-center gap-2">
                    Keterangan
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <span class="text-sm text-gray-500 block">Kategori / Bidang</span>
                    <span class="font-bold text-church-dark">{{ $announcement->announcementCategory }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Terakhir Diubah</span>
                    <span class="font-bold text-church-dark">{{ $announcement->updated_at_local }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-1">
                @if($announcement->image_url)
                    <img src="{{ asset('storage/' . $announcement->image_url) }}" 
                        alt="{{ $announcement->title }}"
                        onclick="openImageModal()"
                        class="w-full h-48 md:h-64 rounded-xl object-cover cursor-pointer hover:opacity-90 transition-opacity duration-200">
                @else
                    <div class="w-full h-48 md:h-64 rounded-xl bg-gray-100 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                        <i class="fas fa-image text-4xl mb-2 opacity-50"></i>
                        <span class="text-sm font-medium">Tidak ada gambar</span>
                    </div>
                @endif
            </div>
            <div class="p-6 md:p-8">
                <h1 class="text-xl font-bold text-church-dark mb-2">{{ $announcement->title }}</h1>
                <div class="prose prose-sm md:prose-base prose-gray max-w-none prose-p:leading-relaxed prose-headings:font-serif">
                    {!! nl2br(e($announcement->content)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@if($announcement->image_url)
    <div id="imageModal" 
        class="fixed inset-0 z-[100] hidden bg-black/90 backdrop-blur-sm flex items-center justify-center p-4 transition-all"
        onclick="closeImageModal(event)">
        
        <button type="button" 
                onclick="closeImageModal(event, true)" 
                class="cursor-pointer absolute top-4 right-4 md:top-6 md:right-6 text-white hover:text-church-gold transition-colors focus:outline-none p-2">
            <i class="fas fa-times text-3xl"></i>
        </button>

        <img src="{{ asset('storage/' . $announcement->image_url) }}" 
            alt="{{ $announcement->title }}"
            class="max-w-full max-h-[90vh] rounded-lg shadow-2xl object-contain cursor-default"
            id="modalImageContent">
    </div>
@endif
<script>
    function openImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('hidden'); // Mencegah body discroll waktu modalnya terbuka
        document.body.style.overflow = 'hidden'; 
    }

    function closeImageModal(event, forceClose = false) {
        const modal = document.getElementById('imageModal');
        const imageContent = document.getElementById('modalImageContent');
        
        // Tutup modal kalo user menekan tombol silang atao mengklik area di luar gambar
        if (forceClose || event.target !== imageContent) {
            modal.classList.add('hidden');
            // Kembalikan fungsi scroll di body
            document.body.style.overflow = 'auto'; 
        }
    }
</script>

@endsection
