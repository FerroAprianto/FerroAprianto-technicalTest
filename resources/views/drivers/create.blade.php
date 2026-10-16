@extends('layouts.app')
@section('title', 'Tambah Driver')
@section('page-title', 'Tambah Driver Baru')
@section('page-subtitle', 'Masukkan data identitas pengemudi armada dan nomor surat izin mengemudi.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <a href="{{ route('drivers.index') }}">Driver</a>
    <span class="separator">></span>
    <span class="current">Tambah</span>
@endsection

@section('content')
<div class="content-card" style="max-width: 720px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 20px 28px; border-bottom: 1px solid #f1f5f9; font-size: 15px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-user-plus" style="color: #10b981;"></i> Formulir Driver Baru
    </div>

    <form method="POST" action="{{ route('drivers.store') }}" style="padding: 28px;">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label class="form-label">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Nama lengkap driver" value="{{ old('name') }}" required>
                @error('name')<div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="form-label">ID Karyawan <span style="color: #ef4444;">*</span></label>
                <input type="text" name="employee_id" class="form-control" placeholder="Contoh: EMP-009" value="{{ old('employee_id') }}" required>
                @error('employee_id')<div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label class="form-label">Tipe Lisensi / SIM <span style="color: #ef4444;">*</span></label>
                <select name="license_type" class="form-select" required>
                    <option value="A" {{ old('license_type') == 'A' ? 'selected' : '' }}>SIM A (Mobil Pribadi)</option>
                    <option value="B1" {{ old('license_type') == 'B1' ? 'selected' : '' }}>SIM B1 (Truk Ringan / Bus Sedang)</option>
                    <option value="B2" {{ old('license_type') == 'B2' ? 'selected' : '' }}>SIM B2 (Truk Berat / Dump Truck)</option>
                </select>
            </div>

            <div>
                <label class="form-label">Nomor Lisensi / SIM <span style="color: #ef4444;">*</span></label>
                <input type="text" name="license_number" class="form-control" placeholder="Nomor SIM" value="{{ old('license_number') }}" required>
                @error('license_number')<div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label class="form-label">Masa Berlaku SIM</label>
                <input type="date" name="license_expiry" class="form-control" value="{{ old('license_expiry') }}">
            </div>

            <div>
                <label class="form-label">Nomor Telepon / WhatsApp <span style="color: #ef4444;">*</span></label>
                <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 24px;">
            <div>
                <label class="form-label">Lokasi Penugasan / Pool <span style="color: #ef4444;">*</span></label>
                <input type="text" name="location" class="form-control" placeholder="Contoh: Tambang Morowali 1" value="{{ old('location') }}" required>
            </div>

            <div>
                <label class="form-label">Status Awal</label>
                <select name="status" class="form-select">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="on_duty" {{ old('status') == 'on_duty' ? 'selected' : '' }}>Bertugas</option>
                    <option value="off" {{ old('status') == 'off' ? 'selected' : '' }}>Libur / Cuti</option>
                </select>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
            <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Driver
            </button>
        </div>
    </form>
</div>
@endsection
