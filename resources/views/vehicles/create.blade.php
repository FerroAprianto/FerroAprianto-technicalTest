@extends('layouts.app')
@section('title', 'Tambah Kendaraan')
@section('page-title', 'Tambah Kendaraan Baru')
@section('page-subtitle', 'Daftarkan unit kendaraan baru ke dalam sistem inventaris armada SEKAWAN Fleet.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <a href="{{ route('vehicles.index') }}">Kendaraan</a>
    <span class="separator">></span>
    <span class="current">Tambah</span>
@endsection

@section('content')
<style>
    .form-grid-2col {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    .form-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .form-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .form-card-header i {
        color: #10b981;
    }

    .form-card-body {
        padding: 24px;
    }

    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-input, .form-select-clean {
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13.5px;
        color: #0f172a;
        font-family: inherit;
        outline: none;
        transition: all 0.2s;
    }

    .form-input:focus, .form-select-clean:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }

    .field-error-text {
        font-size: 12px;
        color: #ef4444;
        margin-top: 5px;
    }

    .form-actions-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
    }

    .btn-save-submit {
        flex: 1;
        height: 46px;
        background: var(--btn-green);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(27, 110, 78, 0.25);
        transition: all 0.2s ease;
    }

    .btn-save-submit:hover {
        background: var(--btn-green-hover);
        transform: translateY(-1px);
    }

    .btn-cancel-back {
        height: 46px;
        padding: 0 20px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-cancel-back:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    @media (max-width: 1024px) {
        .form-grid-2col {
            grid-template-columns: 1fr;
        }
        .form-row-2 {
            grid-template-columns: 1fr;
        }
    }
</style>

<form method="POST" action="{{ route('vehicles.store') }}">
    @csrf
    <div class="form-grid-2col">
        <!-- Main Form -->
        <div>
            <!-- Info Kendaraan -->
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-truck"></i>
                    <span>Informasi Utama Kendaraan</span>
                </div>
                <div class="form-card-body">
                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Plat Nomor Kendaraan <span class="required">*</span></label>
                            <input type="text" name="plate_number" class="form-input {{ $errors->has('plate_number') ? 'is-invalid' : '' }}"
                                value="{{ old('plate_number') }}" placeholder="Contoh: KB 1234 AB" required style="text-transform: uppercase;">
                            @error('plate_number')<div class="field-error-text">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tahun Pembuatan <span class="required">*</span></label>
                            <input type="number" name="year" class="form-input" value="{{ old('year', date('Y')) }}" min="1990" max="{{ date('Y') + 1 }}" required>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Merek Kendaraan <span class="required">*</span></label>
                            <input type="text" name="brand" class="form-input" value="{{ old('brand') }}" placeholder="Toyota, Mitsubishi, Hino..." required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Model Kendaraan <span class="required">*</span></label>
                            <input type="text" name="model" class="form-input" value="{{ old('model') }}" placeholder="Hilux, Fortuner, Dutro..." required>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Jenis Angkutan <span class="required">*</span></label>
                            <select name="type" class="form-select-clean" required>
                                <option value="passenger" {{ old('type') == 'passenger' ? 'selected' : '' }}>Angkutan Orang</option>
                                <option value="cargo" {{ old('type') == 'cargo' ? 'selected' : '' }}>Angkutan Barang / Logistik</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Warna Kendaraan</label>
                            <input type="text" name="color" class="form-input" value="{{ old('color') }}" placeholder="Putih, Hitam, Silver...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Operasional & Konsumsi BBM -->
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-gas-pump"></i>
                    <span>Operasional & Konsumsi BBM</span>
                </div>
                <div class="form-card-body">
                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Konsumsi BBM Rata-rata (km/liter)</label>
                            <input type="number" step="0.1" name="fuel_consumption" class="form-input" value="{{ old('fuel_consumption', 10) }}" placeholder="Contoh: 10.5">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kapasitas Tangki BBM (Liter) <span class="required">*</span></label>
                            <input type="number" name="fuel_capacity" class="form-input" value="{{ old('fuel_capacity', 80) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lokasi Penempatan / Site Pool <span class="required">*</span></label>
                        <input type="text" name="location" class="form-input" value="{{ old('location') }}" placeholder="Contoh: Tambang Morowali 1, Kantor Pusat..." required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div>
            <div class="form-card" style="position: sticky; top: 100px;">
                <div class="form-card-header">
                    <i class="fas fa-sliders"></i>
                    <span>Status & Kepemilikan</span>
                </div>
                <div class="form-card-body">
                    <div class="form-group">
                        <label class="form-label">Status Kepemilikan <span class="required">*</span></label>
                        <select name="ownership" id="ownershipSelect" class="form-select-clean" onchange="toggleRentalField(this.value)" required>
                            <option value="own" {{ old('ownership') == 'own' ? 'selected' : '' }}>Milik Sendiri</option>
                            <option value="rental" {{ old('ownership') == 'rental' ? 'selected' : '' }}>Sewa (Rental)</option>
                        </select>
                    </div>

                    <div class="form-group" id="rentalCompanyWrap" style="{{ old('ownership') == 'rental' ? '' : 'display: none;' }}">
                        <label class="form-label">Nama Perusahaan Rental <span class="required">*</span></label>
                        <input type="text" name="rental_company" class="form-input" value="{{ old('rental_company') }}" placeholder="PT Sewa Kendaraan...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Awal Kendaraan</label>
                        <select name="status" class="form-select-clean">
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>Sedang Digunakan</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Dalam Perawatan</option>
                        </select>
                    </div>

                    <hr style="border: none; border-top: 1px dashed #e2e8f0; margin: 20px 0;">

                    <div class="form-actions-bar">
                        <a href="{{ route('vehicles.index') }}" class="btn-cancel-back">Batal</a>
                        <button type="submit" class="btn-save-submit">
                            <i class="fas fa-save"></i>
                            <span>Simpan Kendaraan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function toggleRentalField(val) {
        const wrap = document.getElementById('rentalCompanyWrap');
        if (val === 'rental') {
            wrap.style.display = 'block';
        } else {
            wrap.style.display = 'none';
        }
    }
</script>
@endsection
