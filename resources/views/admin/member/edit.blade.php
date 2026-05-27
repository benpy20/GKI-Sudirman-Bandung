@extends('components.admin.layout')

@section('page_title', 'Kelola Keanggotaan Jemaat')

@section('title', 'Admin - Keanggotaan Jemaat')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.member.index') }}" class="text-sm font-medium text-gray-500 hover:text-church-gold mb-3 inline-flex items-center transition-colors">
        <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2 shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </div>
        Kembali
    </a>
    <h2 class="text-3xl font-bold text-church-dark mt-1">Sunting Data Anggota Jemaat</h2>
</div>
<form action="{{ route('admin.member.update', $member->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="space-y-8 pb-24">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50">
                <h3 class="text-lg font-bold text-church-dark flex items-center gap-2">
                    Data Anggota Jemaat
                </h3>
            </div>
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full px-5 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all focus:bg-white text-church-dark font-medium">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $member->birth_date) }}" class="w-full px-5 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all focus:bg-white text-church-dark font-medium">
                        @error('birth_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3 h-[46px]">
                            <label class="flex items-center justify-center gap-2 px-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:bg-church-gold/10 has-[:checked]:border-church-gold has-[:checked]:text-yellow-800 font-medium">
                                <input type="radio" name="gender" value="1" {{ old('gender', $member->gender) == 1 ? 'checked' : '' }} class="text-church-gold focus:ring-church-gold">Laki-laki
                            </label>
                            <label class="flex items-center justify-center gap-2 px-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:bg-church-gold/10 has-[:checked]:border-church-gold has-[:checked]:text-yellow-800 font-medium">
                                <input type="radio" name="gender" value="2" {{ old('gender', $member->gender) == 2 ? 'checked' : '' }} class="text-church-gold focus:ring-church-gold">Perempuan
                            </label>
                        </div>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon (Opsional) </label>
                        <input type="tel" name="phone_number" value="{{ old('phone_number', $member->phone_number) }}" class="w-full px-5 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all focus:bg-white text-church-dark font-medium">
                        @error('phone_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Bergabung <span class="text-red-500">*</span></label>
                        <input type="date" name="join_date" value="{{ old('join_date', $member->join_date) }}" class="w-full px-5 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all focus:bg-white text-church-dark font-medium">
                        @error('join_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="3" class="w-full px-5 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all focus:bg-white text-church-dark resize-none font-medium">{{ old('address', $member->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Foto Profil (Opsional)</label>
                        @if($member->image_url)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $member->image_url) }}" alt="{{ $member->name }}" class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                                <label class="flex items-center gap-2 mt-3 cursor-pointer">
                                    <input type="checkbox" name="remove_image" value="1" class="text-red-500 rounded border-gray-300 focus:ring-red-500">
                                    <span class="text-sm text-red-500 font-medium hover:text-red-600 transition-colors">Hapus foto saat ini</span>
                                </label>
                            </div>
                        @endif
                        <input type="file" name="image_url" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full px-5 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all focus:bg-white text-church-dark font-medium file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-church-gold/10 file:text-church-gold hover:file:bg-church-gold/20">
                        <p class="text-xs text-gray-500 mt-2">Format yang didukung: JPG, JPEG, PNG, WEBP (maksimal 8MB)</p>
                        @error('image_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full">
                <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-church-dark flex items-center gap-2">
                        Pengaturan Status Keanggotaan
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Aktif <span class="text-red-500">*</span></label>
                        <select name="is_active" class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all text-church-dark appearance-none font-medium">
                            <option value="1" {{ old('is_active', $member->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $member->is_active) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Jemaat <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all text-church-dark appearance-none font-medium">
                            <option value="" disabled {{ old('status', $member->status) ? '' : 'selected' }}>Pilih Status</option>
                            <option value="1" {{ old('status', $member->status) == 1 ? 'selected' : '' }}>Koordinator Hamba Tuhan</option>
                            <option value="2" {{ old('status', $member->status) == 2 ? 'selected' : '' }}>Pendeta</option>
                            <option value="3" {{ old('status', $member->status) == 3 ? 'selected' : '' }}>Penginjil</option>
                            <option value="4" {{ old('status', $member->status) == 4 ? 'selected' : '' }}>Penatua</option>
                            <option value="5" {{ old('status', $member->status) == 5 ? 'selected' : '' }}>Diaken</option>
                            <option value="6" {{ old('status', $member->status) == 6 ? 'selected' : '' }}>Jemaat Biasa</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Keanggotaan <span class="text-red-500">*</span></label>
                        <select name="membership" required class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all text-church-dark appearance-none font-medium">
                            <option value="" disabled {{ old('membership', $member->membership) ? '' : 'selected' }}>Pilih Jenis Keanggotaan</option>
                            <option value="1" {{ old('membership', $member->membership) == 1 ? 'selected' : '' }}>Baptis Anak</option>
                            <option value="2" {{ old('membership', $member->membership) == 2 ? 'selected' : '' }}>Sidi/Baptis Dewasa</option>
                            <option value="3" {{ old('membership', $member->membership) == 3 ? 'selected' : '' }}>Atestasi Keluar</option>
                            <option value="4" {{ old('membership', $member->membership) == 4 ? 'selected' : '' }}>Meninggal</option>
                            <option value="5" {{ old('membership', $member->membership) == 5 ? 'selected' : '' }}>Simpatisan</option>
                        </select>
                        @error('membership')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full">
                <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-church-dark flex items-center gap-2">
                        Pengaturan Rayon
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Rayon</label>
                        @if ($regions->isEmpty())
                            <p class="text-sm text-gray-500 italic">Belum ada data rayon. Silakan tambahkan data rayon terlebih dahulu.</p>
                        @else
                        <select name="regions_id" class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all text-church-dark appearance-none font-medium">
                            <option value="" {{ old('regions_id', $member->regions_id) ? '' : 'selected' }}>
                                Pilih Rayon
                            </option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}" {{ old('regions_id', $member->regions_id) == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                        @endif
                        @error('regions_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="is_region_leader" value="0">
                    <label class="flex items-center gap-3 p-4 bg-yellow-50/50 border border-yellow-100 rounded-xl cursor-pointer hover:bg-yellow-50 transition-colors group mt-[18px]">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_region_leader" value="1" class="w-5 h-5 text-church-gold rounded border-gray-300 focus:ring-church-gold" {{ old('is_region_leader', $member->is_region_leader) ? 'checked' : '' }}>
                        </div>
                        <span class="text-sm font-bold text-yellow-800">Jemaat merupakan ketua rayon</span>
                    </label>
                    <div class="mt-[18px]">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Komisi</label>
                        @if ($commissions->isEmpty())
                            <p class="text-sm text-gray-500 italic">Belum ada data komisi. Silakan tambahkan data komisi terlebih dahulu.</p>
                        @else
                        <select id="commissionSelect" name="commissions_id" class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-church-gold focus:border-church-gold outline-none transition-all text-church-dark appearance-none font-medium">
                            <option value="" {{ old('commissions_id', $member->commissions_id) ? '' : 'selected' }}>
                                Pilih Komisi
                            </option>
                            @foreach ($commissions as $commission)
                                <option value="{{ $commission->id }}" {{ old('commissions_id', $member->commissions_id) == $commission->id ? 'selected' : '' }}>Komisi {{ $commission->name }}</option>
                            @endforeach
                        </select>
                        @endif
                        @error('commissions_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-church-dark flex items-center gap-2">
                        Bidang Pelayanan
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    @foreach($stewards as $category => $stewardsInCategory)
                        <div class="bg-gray-50/50 p-5 rounded-2xl border border-gray-100" data-category>
                            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <div class="w-1.5 h-4 bg-church-gold rounded-full"></div>
                                {{ $category }}
                            </h4>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach($stewardsInCategory as $steward)
                                    <label class="cursor-pointer group steward-item" data-commission="{{ $steward->commissions_id ? $steward->commissions_id : 'general' }}">
                                        <input type="checkbox" name="stewards[]" value="{{ $steward->id }}" class="peer hidden" {{ in_array($steward->id, old('stewards', $memberStewardIds)) ? 'checked' : '' }}>
                                        <div class="px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 bg-white transition-all 
                                            peer-checked:border-church-gold peer-checked:bg-church-gold/10 peer-checked:text-yellow-800 
                                            group-hover:border-church-gold/50 group-hover:bg-church-gold/5 select-none shadow-sm flex items-center gap-2">
                                            {{ $steward->field }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="fixed bottom-0 left-0 md:left-64 right-0 p-4 lg:p-6 bg-white/90 backdrop-blur-md border-t border-gray-200/60 z-30 flex justify-end gap-3 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] transition-all">
        <a href="{{ route('admin.member.index') }}" class="px-5 lg:px-6 py-2.5 lg:py-3 bg-white border border-gray-300 rounded-xl text-gray-700 font-bold hover:bg-gray-50 transition-colors text-sm lg:text-base">
            Batalkan
        </a>
        <button type="submit" class="cursor-pointer px-6 lg:px-8 py-2.5 lg:py-3 bg-gradient-to-r from-church-gold to-yellow-600 rounded-xl text-church-dark font-bold hover:from-yellow-500 hover:to-yellow-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm lg:text-base flex items-center gap-2">
            <i class="fas fa-save"></i>Perbarui Anggota Jemaat
        </button>
    </div>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const commissionSelect = document.getElementById('commissionSelect');
        if (!commissionSelect) return;

        const stewardItems = document.querySelectorAll('.steward-item');

        function filterStewards() {
            const selected = commissionSelect.value;

            stewardItems.forEach(item => {
                const commissionId = item.dataset.commission;

                if (!selected) {
                    item.style.display = commissionId === 'general' ? 'inline-block' : 'none';
                } else {
                    item.style.display =
                        commissionId === 'general' || commissionId == selected
                            ? 'inline-block'
                            : 'none';
                }
            });

            document.querySelectorAll('[data-category]').forEach(cat => {
                const visibleItems = cat.querySelectorAll('.steward-item:not([style*="display: none"])');
                cat.style.display = visibleItems.length ? 'block' : 'none';
            });
        }

        commissionSelect.addEventListener('change', filterStewards);
        filterStewards();
    });
</script>
@endsection
