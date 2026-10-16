@extends('layouts.app')
@section('title', 'Buat Pemesanan Kendaraan')
@section('page-title', 'Buat Pemesanan Kendaraan')
@section('page-subtitle', 'Lengkapi rincian operasional, tentukan armada & driver, serta tetapkan atasan penyetuju berjenjang.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <a href="{{ route('bookings.index') }}">Pemesanan</a>
    <span class="separator">></span>
    <span class="current">Buat Baru</span>
@endsection

@section('content')
<style>
    /* ===== MAIN LAYOUT GRID ===== */
    .booking-create-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.75fr) minmax(360px, 1.25fr);
        gap: 24px;
        align-items: flex-start;
    }

    /* ===== SECTION CARDS ===== */
    .form-panel-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #eef2f6;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-panel-card:hover {
        border-color: #e2e8f0;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
    }

    .form-panel-header {
        padding: 18px 24px;
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .icon-emerald {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
    }

    .icon-amber {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
    }

    .icon-blue {
        background: rgba(14, 165, 233, 0.12);
        color: #0284c7;
    }

    .header-main-text {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.2px;
    }

    .header-sub-text {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 500;
    }

    .form-panel-body {
        padding: 24px;
    }

    /* ===== FORM FIELDS & GROUPS ===== */
    .field-group {
        margin-bottom: 20px;
    }

    .field-group:last-child {
        margin-bottom: 0;
    }

    .field-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .field-label .req-star {
        color: #ef4444;
        margin-left: 2px;
    }

    .field-label .hint-badge {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 6px;
    }

    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon-lead {
        position: absolute;
        left: 14px;
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
        transition: color 0.2s;
    }

    .text-input-field, .select-input-field, .textarea-input-field {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 11px 14px 11px 40px;
        font-size: 13.5px;
        color: #0f172a;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
    }

    .select-input-field {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 13px;
        padding-right: 38px;
        cursor: pointer;
    }

    .textarea-input-field {
        padding-left: 14px;
        resize: vertical;
        min-height: 85px;
        line-height: 1.5;
    }

    .text-input-field:focus, .select-input-field:focus, .textarea-input-field:focus {
        background: #ffffff;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }

    .input-with-icon:focus-within .input-icon-lead {
        color: #10b981;
    }

    .is-invalid {
        border-color: #ef4444 !important;
        background-color: #fffaf0;
    }

    .error-msg {
        font-size: 12px;
        color: #ef4444;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Quick Suggestion Pills */
    .quick-chips-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .quick-chip-btn {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 3px 9px;
        font-size: 11.5px;
        color: #475569;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .quick-chip-btn:hover {
        background: #ecfdf5;
        border-color: #a7f3d0;
        color: #065f46;
    }

    /* 2 Columns & 3 Columns Row */
    .row-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .duration-indicator-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        color: #166534;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 8px;
    }

    /* ===== 2-TIER APPROVAL FLOW ===== */
    .workflow-timeline {
        display: flex;
        flex-direction: column;
        gap: 16px;
        position: relative;
    }

    .workflow-step-item {
        position: relative;
        display: flex;
        gap: 16px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 20px;
        transition: border-color 0.2s, background 0.2s;
    }

    .workflow-step-item:hover {
        background: #ffffff;
        border-color: #cbd5e1;
    }

    .workflow-step-badge {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .badge-step-1 {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .badge-step-2 {
        background: #e0f2fe;
        color: #075985;
        border: 1px solid #bae6fd;
    }

    .workflow-step-content {
        flex: 1;
    }

    .workflow-step-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .workflow-step-desc {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 10px;
    }

    /* Policy Warning Card */
    .policy-box {
        background: linear-gradient(135deg, rgba(236, 253, 245, 0.8) 0%, rgba(209, 250, 229, 0.5) 100%);
        border: 1px solid #a7f3d0;
        border-radius: 12px;
        padding: 14px 16px;
        margin-top: 16px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 12.5px;
        line-height: 1.5;
        color: #065f46;
    }

    .policy-box i {
        font-size: 16px;
        color: #10b981;
        margin-top: 2px;
    }

    /* ===== RIGHT SIDEBAR (FLEET & PREVIEWS) ===== */
    .sidebar-sticky-panel {
        position: sticky;
        top: 96px;
    }

    .preview-info-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        margin-top: 12px;
        display: none;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .preview-header-tag {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .preview-chip-plate {
        background: #0f172a;
        color: #ffffff;
        font-size: 12px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        letter-spacing: 0.5px;
    }

    .preview-badge-status {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        background: #dcfce7;
        color: #15803d;
    }

    .preview-grid-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        font-size: 12px;
    }

    .preview-stat-row {
        color: #64748b;
    }

    .preview-stat-row strong {
        color: #0f172a;
        display: block;
        font-size: 12.5px;
    }

    /* Booking Summary Overview */
    .submission-summary-box {
        background: #092218;
        color: #ffffff;
        border-radius: 18px;
        padding: 22px 24px;
        margin-top: 24px;
        box-shadow: 0 12px 30px -5px rgba(9, 34, 24, 0.4);
    }

    .summary-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .summary-heading-title {
        font-size: 14.5px;
        font-weight: 800;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-badge-live {
        font-size: 11px;
        font-weight: 700;
        color: #34d399;
        background: rgba(52, 211, 153, 0.15);
        padding: 2px 8px;
        border-radius: 12px;
    }

    .summary-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 10px;
        color: rgba(255, 255, 255, 0.75);
    }

    .summary-item-row span.val {
        color: #ffffff;
        font-weight: 700;
        text-align: right;
        max-width: 60%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .form-btn-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-submit-main {
        width: 100%;
        height: 48px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4);
        transition: all 0.2s ease;
    }

    .btn-submit-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.5);
    }

    .btn-back-cancel {
        width: 100%;
        height: 42px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: rgba(255, 255, 255, 0.85);
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-back-cancel:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    @media (max-width: 1024px) {
        .booking-create-layout {
            grid-template-columns: 1fr;
        }
        .sidebar-sticky-panel {
            position: static;
        }
    }

    @media (max-width: 640px) {
        .row-2col {
            grid-template-columns: 1fr;
        }
    }
</style>

<form method="POST" action="{{ route('bookings.store') }}" id="createBookingForm">
    @csrf

    <div class="booking-create-layout">
        <!-- ================= LEFT COLUMN ================= -->
        <div>
            <!-- CARD 1: INFORMASI PERJALANAN & OPERASIONAL -->
            <div class="form-panel-card">
                <div class="form-panel-header">
                    <div class="header-title-wrap">
                        <div class="header-icon-box icon-emerald">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div>
                            <div class="header-main-text">Informasi Perjalanan Operasional</div>
                            <div class="header-sub-text">Tentukan agenda perjalanan dinas tambang dan destinasi tujuan</div>
                        </div>
                    </div>
                    <span class="field-label hint-badge" style="margin: 0;">Langkah 1 dari 2</span>
                </div>

                <div class="form-panel-body">
                    <!-- Keperluan / Agenda -->
                    <div class="field-group">
                        <label for="purpose" class="field-label">
                            <span>Keperluan / Agenda Pemakaian <span class="req-star">*</span></span>
                            <span class="hint-badge">Wajib Diisi</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-briefcase input-icon-lead"></i>
                            <input 
                                type="text" 
                                id="purpose" 
                                name="purpose" 
                                class="text-input-field {{ $errors->has('purpose') ? 'is-invalid' : '' }}" 
                                placeholder="Contoh: Inspeksi operasional site tambang nikel"
                                value="{{ old('purpose') }}" 
                                required
                                autocomplete="off"
                            >
                        </div>
                        @error('purpose')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                        
                        <!-- Quick tags to ease input -->
                        <div class="quick-chips-wrap">
                            <span style="font-size: 11px; color: #94a3b8; align-self: center; margin-right: 2px;">Cepat isi:</span>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('purpose', 'Inspeksi Operasional Site')">Inspeksi Site</button>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('purpose', 'Pengiriman Logistik & Suku Cadang')">Pengiriman Logistik</button>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('purpose', 'Rapat Koordinasi Direksi Tambang')">Rapat Koordinasi</button>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('purpose', 'Antar Jemput Tamu Stakeholder')">Antar Jemput Tamu</button>
                        </div>
                    </div>

                    <!-- Lokasi Tujuan -->
                    <div class="field-group">
                        <label for="destination" class="field-label">
                            <span>Lokasi Tujuan <span class="req-star">*</span></span>
                            <span class="hint-badge">Site / Kantor</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-map-pin input-icon-lead"></i>
                            <input 
                                type="text" 
                                id="destination" 
                                name="destination" 
                                class="text-input-field {{ $errors->has('destination') ? 'is-invalid' : '' }}" 
                                placeholder="Contoh: Tambang Morowali 1, Sulawesi Tengah"
                                value="{{ old('destination') }}" 
                                required
                                autocomplete="off"
                            >
                        </div>
                        @error('destination')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror

                        <!-- Quick destinations -->
                        <div class="quick-chips-wrap">
                            <span style="font-size: 11px; color: #94a3b8; align-self: center; margin-right: 2px;">Site Populer:</span>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('destination', 'Tambang Morowali 1')">Morowali 1</button>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('destination', 'Tambang Morowali 2')">Morowali 2</button>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('destination', 'Tambang Konawe')">Konawe</button>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('destination', 'Tambang Pomalaa')">Pomalaa</button>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('destination', 'Kantor Pusat - Jakarta')">Pusat Jakarta</button>
                            <button type="button" class="quick-chip-btn" onclick="setFieldValue('destination', 'Kantor Cabang - Makassar')">Cabang Makassar</button>
                        </div>
                    </div>

                    <!-- Jadwal Waktu Berangkat & Kembali -->
                    <div class="row-2col">
                        <div class="field-group">
                            <label for="departure_datetime" class="field-label">
                                <span>Waktu Berangkat <span class="req-star">*</span></span>
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-calendar-day input-icon-lead"></i>
                                <input 
                                    type="datetime-local" 
                                    id="departure_datetime" 
                                    name="departure_datetime" 
                                    class="text-input-field {{ $errors->has('departure_datetime') ? 'is-invalid' : '' }}" 
                                    value="{{ old('departure_datetime') }}" 
                                    required
                                >
                            </div>
                            @error('departure_datetime')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                        </div>

                        <div class="field-group">
                            <label for="return_datetime" class="field-label">
                                <span>Waktu Kembali <span class="req-star">*</span></span>
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-calendar-check input-icon-lead"></i>
                                <input 
                                    type="datetime-local" 
                                    id="return_datetime" 
                                    name="return_datetime" 
                                    class="text-input-field {{ $errors->has('return_datetime') ? 'is-invalid' : '' }}" 
                                    value="{{ old('return_datetime') }}" 
                                    required
                                >
                            </div>
                            @error('return_datetime')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Duration indicator live pill -->
                    <div class="duration-indicator-box" id="durationBox" style="display: none;">
                        <i class="fas fa-stopwatch"></i>
                        <span>Estimasi Durasi Perjalanan: <strong id="durationText">0 jam</strong></span>
                    </div>

                    <div style="margin-top: 18px;" class="row-2col">
                        <!-- Jumlah Penumpang -->
                        <div class="field-group">
                            <label for="passenger_count" class="field-label">
                                <span>Kapasitas / Penumpang <span class="req-star">*</span></span>
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-users input-icon-lead"></i>
                                <input 
                                    type="number" 
                                    id="passenger_count" 
                                    name="passenger_count" 
                                    class="text-input-field {{ $errors->has('passenger_count') ? 'is-invalid' : '' }}" 
                                    min="1" 
                                    max="50" 
                                    value="{{ old('passenger_count', 1) }}" 
                                    required
                                >
                            </div>
                            @error('passenger_count')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                        </div>

                        <!-- Catatan Ringkas -->
                        <div class="field-group">
                            <label for="description" class="field-label">
                                <span>Catatan Operasional</span>
                                <span class="hint-badge">Opsional</span>
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-file-pen input-icon-lead"></i>
                                <input 
                                    type="text" 
                                    id="description" 
                                    name="description" 
                                    class="text-input-field" 
                                    placeholder="Contoh: Membawa APD & sampel bijih nikel"
                                    value="{{ old('description') }}"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2: ALUR PERSETUJUAN BERJENJANG (2 TIER) -->
            <div class="form-panel-card">
                <div class="form-panel-header">
                    <div class="header-title-wrap">
                        <div class="header-icon-box icon-amber">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <div>
                            <div class="header-main-text">Alur Persetujuan Bertingkat (2 Level)</div>
                            <div class="header-sub-text">Persetujuan berjenjang sesuai Standar Operasional Prosedur PT Sekawan Nikel</div>
                        </div>
                    </div>
                    <span class="field-label hint-badge" style="margin: 0;">SOP Wajib</span>
                </div>

                <div class="form-panel-body">
                    <div class="workflow-timeline">
                        <!-- Level 1 Approval -->
                        <div class="workflow-step-item">
                            <div class="workflow-step-badge badge-step-1">1</div>
                            <div class="workflow-step-content">
                                <div class="workflow-step-title">Penyetuju Tingkat 1 (Atasan Langsung) <span class="req-star">*</span></div>
                                <div class="workflow-step-desc">Memverifikasi urgensi operasional dan izin tugas kerja di area tambang.</div>
                                <div class="input-with-icon">
                                    <i class="fas fa-user-check input-icon-lead"></i>
                                    <select name="approver1_id" id="approver1_id" class="select-input-field {{ $errors->has('approver1_id') ? 'is-invalid' : '' }}" required>
                                        <option value="">-- Pilih Penyetuju Tingkat 1 --</option>
                                        @foreach($approvers->where('approval_level', 1) as $appr1)
                                        <option value="{{ $appr1->id }}" {{ old('approver1_id') == $appr1->id ? 'selected' : '' }}>
                                            {{ $appr1->name }} — {{ $appr1->position ?? 'Atasan Langsung' }} ({{ $appr1->department ?? 'Operasional' }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('approver1_id')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Level 2 Approval -->
                        <div class="workflow-step-item">
                            <div class="workflow-step-badge badge-step-2">2</div>
                            <div class="workflow-step-content">
                                <div class="workflow-step-title">Penyetuju Tingkat 2 (Manajemen / Direksi) <span class="req-star">*</span></div>
                                <div class="workflow-step-desc">Otorisasi final penggunaan armada tambang sebelum kendaraan dapat diberangkatkan.</div>
                                <div class="input-with-icon">
                                    <i class="fas fa-user-shield input-icon-lead"></i>
                                    <select name="approver2_id" id="approver2_id" class="select-input-field {{ $errors->has('approver2_id') ? 'is-invalid' : '' }}" required>
                                        <option value="">-- Pilih Penyetuju Tingkat 2 --</option>
                                        @foreach($approvers->where('approval_level', 2) as $appr2)
                                        <option value="{{ $appr2->id }}" {{ old('approver2_id') == $appr2->id ? 'selected' : '' }}>
                                            {{ $appr2->name }} — {{ $appr2->position ?? 'Manajemen' }} ({{ $appr2->department ?? 'Direksi' }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('approver2_id')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informational policy alert -->
                    <div class="policy-box">
                        <i class="fas fa-circle-info"></i>
                        <div>
                            <strong>Prosedur Pemesanan:</strong> Permohonan akan berstatus <em>Menunggu Level 1</em>. Setelah disetujui oleh Penyetuju Tingkat 1, notifikasi otomatis diteruskan ke Penyetuju Tingkat 2 untuk otorisasi final.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= RIGHT COLUMN: FLEET, DRIVER & SUMMARY ================= -->
        <div class="sidebar-sticky-panel">
            <!-- CARD 3: ARMADA & DRIVER SELECTION -->
            <div class="form-panel-card">
                <div class="form-panel-header">
                    <div class="header-title-wrap">
                        <div class="header-icon-box icon-blue">
                            <i class="fas fa-truck-front"></i>
                        </div>
                        <div>
                            <div class="header-main-text">Penugasan Armada & Driver</div>
                            <div class="header-sub-text">Pilih kendaraan tambang dan driver bertugas</div>
                        </div>
                    </div>
                </div>

                <div class="form-panel-body">
                    <!-- Pilih Kendaraan -->
                    <div class="field-group">
                        <label for="vehicle_id" class="field-label">
                            <span>Pilih Kendaraan Tersedia <span class="req-star">*</span></span>
                            <span class="hint-badge">{{ $vehicles->count() }} Siap Pakai</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-truck-pickup input-icon-lead"></i>
                            <select name="vehicle_id" id="vehicle_id" class="select-input-field {{ $errors->has('vehicle_id') ? 'is-invalid' : '' }}" required onchange="updateVehiclePreview()">
                                <option value="">-- Pilih Kendaraan Tersedia --</option>
                                @foreach($vehicles as $vehicle)
                                <option 
                                    value="{{ $vehicle->id }}" 
                                    data-brand="{{ $vehicle->brand }} {{ $vehicle->model }}"
                                    data-plate="{{ $vehicle->plate_number }}"
                                    data-type="{{ $vehicle->type === 'cargo' ? 'Angkutan Barang' : 'Angkutan Orang' }}"
                                    data-ownership="{{ $vehicle->ownership === 'own' ? 'Milik Perusahaan' : 'Sewa / Rental' }}"
                                    data-rental="{{ $vehicle->rental_company ?? '-' }}"
                                    data-location="{{ $vehicle->location }}"
                                    data-fuel="{{ $vehicle->fuel_capacity ?? 80 }} Liter"
                                    {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}
                                >
                                    {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate_number }}) - {{ $vehicle->location }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('vehicle_id')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror

                        <!-- Dynamic Vehicle Preview Card -->
                        <div class="preview-info-card" id="vehiclePreviewCard">
                            <div class="preview-header-tag">
                                <span class="preview-chip-plate" id="prevPlate">KB 1234 AB</span>
                                <span class="preview-badge-status" id="prevOwnership">Milik Sendiri</span>
                            </div>
                            <div style="font-size: 14px; font-weight: 800; color: #0f172a; margin-bottom: 6px;" id="prevModel">
                                Toyota Hilux
                            </div>
                            <div class="preview-grid-details">
                                <div class="preview-stat-row">
                                    Jenis Armada
                                    <strong id="prevType">Angkutan Barang</strong>
                                </div>
                                <div class="preview-stat-row">
                                    Lokasi Pool
                                    <strong id="prevLocation">Tambang Morowali 1</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pilih Driver -->
                    <div class="field-group" style="margin-top: 18px;">
                        <label for="driver_id" class="field-label">
                            <span>Pilih Driver Tersedia <span class="req-star">*</span></span>
                            <span class="hint-badge">{{ $drivers->count() }} Driver Aktif</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-id-card input-icon-lead"></i>
                            <select name="driver_id" id="driver_id" class="select-input-field {{ $errors->has('driver_id') ? 'is-invalid' : '' }}" required onchange="updateDriverPreview()">
                                <option value="">-- Pilih Driver Bertugas --</option>
                                @foreach($drivers as $driver)
                                <option 
                                    value="{{ $driver->id }}"
                                    data-name="{{ $driver->name }}"
                                    data-sim="{{ $driver->license_type ?? 'SIM B1' }}"
                                    data-phone="{{ $driver->phone ?? '-' }}"
                                    data-location="{{ $driver->location }}"
                                    {{ old('driver_id') == $driver->id ? 'selected' : '' }}
                                >
                                    {{ $driver->name }} ({{ $driver->license_type ?? 'SIM' }}) - {{ $driver->location }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('driver_id')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror

                        <!-- Dynamic Driver Preview Card -->
                        <div class="preview-info-card" id="driverPreviewCard">
                            <div class="preview-header-tag">
                                <span style="font-size: 12px; font-weight: 800; color: #0284c7; background: #e0f2fe; padding: 2px 8px; border-radius: 6px;" id="prevDriverSim">SIM B1 Tambang</span>
                                <span class="preview-badge-status">Siap Bertugas</span>
                            </div>
                            <div style="font-size: 14px; font-weight: 800; color: #0f172a; margin-bottom: 6px;" id="prevDriverName">
                                Agus Setiawan
                            </div>
                            <div class="preview-grid-details">
                                <div class="preview-stat-row">
                                    Kontak HP
                                    <strong id="prevDriverPhone">0821-xxxx-xxxx</strong>
                                </div>
                                <div class="preview-stat-row">
                                    Penempatan
                                    <strong id="prevDriverLoc">Site Morowali</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 4: RINGKASAN & SUBMISSION BUTTONS -->
            <div class="submission-summary-box">
                <div class="summary-heading">
                    <div class="summary-heading-title">
                        <i class="fas fa-clipboard-list" style="color: #34d399;"></i>
                        <span>Ringkasan Pengajuan</span>
                    </div>
                    <span class="summary-badge-live">Live Sync</span>
                </div>

                <div class="summary-item-row">
                    <span>Tujuan:</span>
                    <span class="val" id="sumDestination">Belum Ditentukan</span>
                </div>

                <div class="summary-item-row">
                    <span>Kendaraan:</span>
                    <span class="val" id="sumVehicle">Belum Dipilih</span>
                </div>

                <div class="summary-item-row">
                    <span>Driver:</span>
                    <span class="val" id="sumDriver">Belum Dipilih</span>
                </div>

                <div class="summary-item-row">
                    <span>Tingkat Persetujuan:</span>
                    <span class="val" style="color: #34d399;">2 Level Berjenjang</span>
                </div>

                <div class="form-btn-actions">
                    <button type="submit" class="btn-submit-main" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        <span>Kirim Permohonan Pemesanan</span>
                    </button>
                    <a href="{{ route('bookings.index') }}" class="btn-back-cancel">
                        <i class="fas fa-arrow-left"></i>
                        <span>Batal & Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // Quick suggestion helper
    function setFieldValue(fieldId, value) {
        const input = document.getElementById(fieldId);
        if (input) {
            input.value = value;
            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
            input.focus();
        }
    }

    // Dynamic duration calculator
    function calculateDuration() {
        const startVal = document.getElementById('departure_datetime').value;
        const endVal = document.getElementById('return_datetime').value;
        const box = document.getElementById('durationBox');
        const text = document.getElementById('durationText');

        if (startVal && endVal) {
            const start = new Date(startVal);
            const end = new Date(endVal);
            const diffMs = end - start;

            if (diffMs > 0) {
                const totalHours = Math.floor(diffMs / (1000 * 60 * 60));
                const days = Math.floor(totalHours / 24);
                const remHours = totalHours % 24;

                let str = '';
                if (days > 0) str += `${days} Hari `;
                if (remHours > 0 || days === 0) str += `${remHours} Jam`;

                text.innerText = str;
                box.style.display = 'flex';
                return;
            }
        }
        box.style.display = 'none';
    }

    document.getElementById('departure_datetime').addEventListener('change', calculateDuration);
    document.getElementById('return_datetime').addEventListener('change', calculateDuration);

    // Live Vehicle preview
    function updateVehiclePreview() {
        const sel = document.getElementById('vehicle_id');
        const card = document.getElementById('vehiclePreviewCard');
        const sumVehicle = document.getElementById('sumVehicle');
        const opt = sel.options[sel.selectedIndex];

        if (opt && opt.value) {
            document.getElementById('prevPlate').innerText = opt.getAttribute('data-plate');
            document.getElementById('prevModel').innerText = opt.getAttribute('data-brand');
            document.getElementById('prevType').innerText = opt.getAttribute('data-type');
            document.getElementById('prevOwnership').innerText = opt.getAttribute('data-ownership');
            document.getElementById('prevLocation').innerText = opt.getAttribute('data-location');
            card.style.display = 'block';
            sumVehicle.innerText = opt.getAttribute('data-brand') + ' (' + opt.getAttribute('data-plate') + ')';
        } else {
            card.style.display = 'none';
            sumVehicle.innerText = 'Belum Dipilih';
        }
    }

    // Live Driver preview
    function updateDriverPreview() {
        const sel = document.getElementById('driver_id');
        const card = document.getElementById('driverPreviewCard');
        const sumDriver = document.getElementById('sumDriver');
        const opt = sel.options[sel.selectedIndex];

        if (opt && opt.value) {
            document.getElementById('prevDriverName').innerText = opt.getAttribute('data-name');
            document.getElementById('prevDriverSim').innerText = opt.getAttribute('data-sim');
            document.getElementById('prevDriverPhone').innerText = opt.getAttribute('data-phone');
            document.getElementById('prevDriverLoc').innerText = opt.getAttribute('data-location');
            card.style.display = 'block';
            sumDriver.innerText = opt.getAttribute('data-name');
        } else {
            card.style.display = 'none';
            sumDriver.innerText = 'Belum Dipilih';
        }
    }

    // Sync live destination summary
    const destInput = document.getElementById('destination');
    const sumDestination = document.getElementById('sumDestination');
    if (destInput && sumDestination) {
        destInput.addEventListener('input', function() {
            sumDestination.innerText = this.value.trim() ? this.value.trim() : 'Belum Ditentukan';
        });
    }

    // Run on initial load in case of old values
    document.addEventListener('DOMContentLoaded', function() {
        calculateDuration();
        updateVehiclePreview();
        updateDriverPreview();
        if (destInput && destInput.value) {
            sumDestination.innerText = destInput.value.trim();
        }
    });

    // Submit loading state
    document.getElementById('createBookingForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Mengirim Permohonan...</span>';
        btn.style.opacity = '0.85';
        btn.style.pointerEvents = 'none';
    });
</script>
@endsection
