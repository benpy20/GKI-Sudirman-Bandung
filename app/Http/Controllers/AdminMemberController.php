<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Member;
use App\Models\Region;
use App\Models\Steward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Member::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('membership')) {
            $query->where('membership', $request->membership);
        }

        if ($request->filled('status_group')) {
            if ($request->status_group == 'hambaTuhan') {
                $query->whereIn('status', [1, 2, 3]);
            } elseif ($request->status_group == 'majelis') {
                $query->whereIn('status', [4, 5]);
            } elseif ($request->status_group == 'jemaat') {
                $query->where('status', 6);
            }
        }

        $members = $query->latest('id')->paginate(10)->withQueryString();

        $memberStatus = [
            1 => 'Koordinator Hamba Tuhan',
            2 => 'Pendeta',
            3 => 'Penginjil',
            4 => 'Penatua',
            5 => 'Diaken',
            6 => 'Jemaat Biasa',
        ];

        $memberMembership = [
            1 => 'Baptis Anak',
            2 => 'Sidi/Baptis Dewasa',
            3 => 'Atestasi Keluar',
            4 => 'Meninggal Dunia',
            5 => 'Simpatisan'
        ];

        foreach ($members as $member) {
            $member->memberStatus = $memberStatus[$member->status];
            $member->memberMembership = $memberMembership[$member->membership];
        }

        return view('admin.member.index', compact('members', 'memberMembership'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();

        $commissions = Commission::where('name', '!=', 'Umum')->get();

        $stewards = Steward::with('commission')->get()->groupBy(function ($steward) {
            return $steward->commission ? $steward->commission->name : 'Bidang Umum';
        });

        return view('admin.member.create', compact('regions', 'commissions', 'stewards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'users_id' => auth()->id(),
            'regions_id' => $request->regions_id ?: null,
            'commissions_id' => $request->commissions_id ?: null,
        ]);

        $request->validate([
            'name' => 'required|string|max:200',
            'address' => 'required|string|max:200',
            'gender' => 'required|in:1,2',
            'status' => 'required|in:1,2,3,4,5,6',
            'phone_number' => 'nullable|string|max:20',
            'birth_date' => 'required|date',
            'join_date' => 'required|date',
            'membership' => 'required|in:1,2,3,4',
            'is_active' => 'required|in:0,1',
            'is_region_leader' => 'required|in:0,1',
            'users_id' => 'required|exists:users,id',
            'regions_id' => 'nullable|exists:regions,id|required_if:is_region_leader,1',
            'commissions_id' => 'nullable|exists:commissions,id',
            'stewards' => 'nullable|array',
            'stewards.*' => 'exists:stewards,id',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
        ], [
            'name.required' => 'Nama anggota jemaat wajib diisi.',
            'name.string' => 'Nama anggota jemaat harus berupa teks.',
            'name.max' => 'Nama anggota jemaat tidak boleh lebih dari 200 karakter.',
            'address.required' => 'Alamat anggota jemaat wajib diisi.',
            'address.string' => 'Alamat anggota jemaat harus berupa teks.',
            'address.max' => 'Alamat anggota jemaat tidak boleh lebih dari 200 karakter.',
            'gender.required' => 'Jenis kelamin anggota jemaat wajib dipilih.',
            'gender.in' => 'Jenis kelamin anggota jemaat tidak valid.',
            'status.required' => 'Status anggota jemaat wajib dipilih.',
            'status.in' => 'Status anggota jemaat tidak valid.',
            'phone_number.string' => 'Nomor telepon anggota jemaat harus berupa teks.',
            'phone_number.max' => 'Nomor telepon anggota jemaat tidak boleh lebih dari 20 karakter.',
            'birth_date.required' => 'Tanggal lahir anggota jemaat wajib diisi.',
            'birth_date.date' => 'Tanggal lahir anggota jemaat harus berupa tanggal yang valid.',
            'join_date.required' => 'Tanggal bergabung anggota jemaat wajib diisi.',
            'join_date.date' => 'Tanggal bergabung anggota jemaat harus berupa tanggal yang valid.',
            'membership.required' => 'Jenis keanggotaan anggota jemaat wajib dipilih.',
            'membership.in' => 'Jenis keanggotaan anggota jemaat tidak valid.',
            'is_active.required' => 'Status keaktifan anggota jemaat wajib dipilih.',
            'is_active.in' => 'Status keaktifan anggota jemaat tidak valid.',
            'is_region_leader.required' => 'Status kepemimpinan rayon anggota jemaat wajib dipilih.',
            'is_region_leader.in' => 'Status kepemimpinan rayon anggota jemaat tidak valid.',
            'users_id.required' => 'ID pengguna wajib diisi.',
            'users_id.exists' => 'ID pengguna tidak valid.',
            'regions_id.exists' => 'ID rayon tidak valid.',
            'regions_id.required_if' => 'Ketua rayon harus memiliki rayon.',
            'commissions_id.exists' => 'ID komisi tidak valid.',
            'stewards.array' => 'Daftar bidang pelayanan tidak valid.',
            'stewards.*.exists' => 'Bidang pelayanan tidak valid.',
            'image_url.image' => 'File yang diunggah harus berupa gambar.',
            'image_url.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'image_url.max' => 'Ukuran gambar tidak boleh lebih dari 8MB.',
        ]);

        $member = Member::create([
            'name' => $request->name,
            'address' => $request->address,
            'gender' => $request->gender,
            'status' => $request->status,
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'join_date' => $request->join_date,
            'membership' => $request->membership,
            'is_active' => $request->is_active,
            'is_region_leader' => $request->is_region_leader,
            'users_id' => $request->users_id,
            'regions_id' => $request->regions_id,
            'commissions_id' => $request->commissions_id,
        ]);

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $extension = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('members', $filename, 'public');
            $member->update(
                ['image_url' => $path]
            );
        }

        $member->stewards()->sync($request->stewards ?? []);

        return redirect()->route('admin.member.index')->with('success', 'Data anggota jemaat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Carbon::setLocale('id');

        $member = Member::with(['stewards.commission'])->findOrFail($id);

        $memberStatus = [
            1 => 'Koordinator Hamba Tuhan',
            2 => 'Pendeta',
            3 => 'Penginjil',
            4 => 'Penatua',
            5 => 'Diaken',
            6 => 'Jemaat Biasa',
        ];

        $memberMembership = [
            1 => 'Baptis Anak',
            2 => 'Sidi/Baptis Dewasa',
            3 => 'Atestasi Keluar',
            4 => 'Meninggal Dunia',
            5 => 'Simpatisan'
        ];

        $memberGender = [
            1 => 'Laki-laki',
            2 => 'Perempuan',
        ];

        $member->memberStatus = $memberStatus[$member->status];
        $member->memberMembership = $memberMembership[$member->membership];
        $member->memberGender = $memberGender[$member->gender];

        $member->birth_date_formatted = Carbon::parse($member->birth_date, 'Asia/Jakarta')->translatedFormat('j F Y');
        $member->join_date_formatted = Carbon::parse($member->join_date, 'Asia/Jakarta')->translatedFormat('j F Y');
        $member->member_new_id = 'J' . Carbon::parse($member->join_date, 'Asia/Jakarta')->format('Ymd') . $member->id;

        $stewardsGrouped = $member->stewards->groupBy(function ($steward) {
            return $steward->commission?->name ?? 'Bidang Umum';
        });
        
        return view('admin.member.show', compact('member', 'stewardsGrouped'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = Member::with('stewards')->findOrFail($id);

        $regions = Region::all();

        $commissions = Commission::where('name', '!=', 'Umum')->get();

        $stewards = Steward::with('commission')->get()->groupBy(function ($steward) {
            return $steward->commission ? $steward->commission->name : 'Bidang Umum';
        });

        $memberStewardIds = $member->stewards->pluck('id')->toArray();

        return view('admin.member.edit', compact('member', 'regions', 'commissions', 'stewards', 'memberStewardIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge([
            'users_id' => auth()->id(),
            'regions_id' => $request->regions_id ?: null,
            'commissions_id' => $request->commissions_id ?: null,
        ]);

        $request->validate([
            'name' => 'required|string|max:200',
            'address' => 'required|string|max:200',
            'gender' => 'required|in:1,2',
            'status' => 'required|in:1,2,3,4,5,6',
            'phone_number' => 'nullable|string|max:20',
            'birth_date' => 'required|date',
            'join_date' => 'required|date',
            'membership' => 'required|in:1,2,3,4',
            'is_active' => 'required|in:0,1',
            'is_region_leader' => 'required|in:0,1',
            'users_id' => 'required|exists:users,id',
            'regions_id' => 'nullable|exists:regions,id|required_if:is_region_leader,1',
            'commissions_id' => 'nullable|exists:commissions,id',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
        ], [
            'name.required' => 'Nama anggota jemaat wajib diisi.',
            'name.string' => 'Nama anggota jemaat harus berupa teks.',
            'name.max' => 'Nama anggota jemaat tidak boleh lebih dari 200 karakter.',
            'address.required' => 'Alamat anggota jemaat wajib diisi.',
            'address.string' => 'Alamat anggota jemaat harus berupa teks.',
            'address.max' => 'Alamat anggota jemaat tidak boleh lebih dari 200 karakter.',
            'gender.required' => 'Jenis kelamin anggota jemaat wajib dipilih.',
            'gender.in' => 'Jenis kelamin anggota jemaat tidak valid.',
            'status.required' => 'Status anggota jemaat wajib dipilih.',
            'status.in' => 'Status anggota jemaat tidak valid.',
            'phone_number.string' => 'Nomor telepon anggota jemaat harus berupa teks.',
            'phone_number.max' => 'Nomor telepon anggota jemaat tidak boleh lebih dari 20 karakter.',
            'birth_date.required' => 'Tanggal lahir anggota jemaat wajib diisi.',
            'birth_date.date' => 'Tanggal lahir anggota jemaat harus berupa tanggal yang valid.',
            'join_date.required' => 'Tanggal bergabung anggota jemaat wajib diisi.',
            'join_date.date' => 'Tanggal bergabung anggota jemaat harus berupa tanggal yang valid.',
            'membership.required' => 'Jenis keanggotaan anggota jemaat wajib dipilih.',
            'membership.in' => 'Jenis keanggotaan anggota jemaat tidak valid.',
            'is_active.required' => 'Status keaktifan anggota jemaat wajib dipilih.',
            'is_active.in' => 'Status keaktifan anggota jemaat tidak valid.',
            'is_region_leader.required' => 'Status kepemimpinan rayon anggota jemaat wajib dipilih.',
            'is_region_leader.in' => 'Status kepemimpinan rayon anggota jemaat tidak valid.',
            'users_id.required' => 'ID pengguna wajib diisi.',
            'users_id.exists' => 'ID pengguna tidak valid.',
            'regions_id.exists' => 'ID rayon tidak valid.',
            'regions_id.required_if' => 'Ketua rayon harus memiliki rayon.',
            'commissions_id.exists' => 'ID komisi tidak valid.',
            'image_url.image' => 'File yang diunggah harus berupa gambar.',
            'image_url.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'image_url.max' => 'Ukuran gambar tidak boleh lebih dari 8MB.',
        ]);

        $member = Member::findOrFail($id);

        $member->update([
            'name' => $request->name,
            'address' => $request->address,
            'gender' => $request->gender,
            'status' => $request->status,
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'join_date' => $request->join_date,
            'membership' => $request->membership,
            'is_active' => $request->is_active,
            'is_region_leader' => $request->is_region_leader,
            'users_id' => $request->users_id,
            'regions_id' => $request->regions_id,
            'commissions_id' => $request->commissions_id,
        ]);

        if ($request->hasFile('image_url')) {
            if ($member->image_url) {
                Storage::disk('public')->delete($member->image_url);
            }

            $file = $request->file('image_url');
            $extension = $file->getClientOriginalExtension();
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('members', $filename, 'public');
            $member->update(
                ['image_url' => $path]
            );
        } elseif ($request->input('remove_image')) {
            if ($member->image_url) {
                Storage::disk('public')->delete($member->image_url);
                $member->update(['image_url' => null]);
            }
        }

        $member->stewards()->sync($request->stewards ?? []);

        return redirect()->route('admin.member.index')->with('success', 'Data anggota jemaat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);

        if ($member->image_url) {
            Storage::disk('public')->delete($member->image_url);
        }

        $member->delete();

        return redirect()->route('admin.member.index')->with('success', 'Data anggota jemaat berhasil dihapus!');
    }
}
