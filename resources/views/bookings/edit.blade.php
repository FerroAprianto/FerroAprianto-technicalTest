@extends('layouts.app')
@section('title', 'Edit Pemesanan')
@section('page-title', 'Edit Pemesanan ' . $booking->booking_number)
@section('page-subtitle', 'Perbarui detail perjalanan, kendaraan, pengemudi, atau pihak penyetuju.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <a href="{{ route('bookings.index') }}">Pemesanan</a>
    <span class="separator">></span>
    <span class="current">Edit</span>
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

    .form-input, .form-textarea, .form-select-clean {
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

    .form-input:focus, .form-textarea:focus, .form-select-clean:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
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

<form method="POST" action="{{ route('bookings.update', $booking) }}">
    @csrf
    @method('PUT')
    <div class="form-grid-2col">
        <!-- LEFT COLUMN: Trip & Approvers -->
        <div>
            <!-- Informasi Perjalanan -->
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-location-dot"></i>
                    <span>Informasi Perjalanan</span>
                </div>
                <div class="form-card-body">
                    <div class="form-group">
                        <label for="purpose" class="form-label">Keperluan Perjalanan <span class="required">*</span></label>
                        <input type="text" id="purpose" name="purpose" class="form-input" value="{{ old('purpose', $booking->purpose) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="destination" class="form-label">Lokasi Tujuan <span class="required">*</span></label>
                        <input type="text" id="destination" name="destination" class="form-input" value="{{ old('destination', $booking->destination) }}" required>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Waktu Berangkat <span class="required">*</span></label>
                            <input type="datetime-local" name="departure_datetime" class="form-input" value="{{ old('departure_datetime', $booking->departure_datetime?->format('Y-m-d\TH:i')) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Waktu Kembali <span class="required">*</span></label>
                            <input type="datetime-local" name="return_datetime" class="form-input" value="{{ old('return_datetime', $booking->return_datetime?->format('Y-m-d\TH:i')) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Penumpang <span class="required">*</span></label>
                        <input type="number" name="passenger_count" class="form-input" value="{{ old('passenger_count', $booking->passenger_count) }}" min="1" max="50" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Keterangan Tambahan</label>
                        <textarea name="description" class="form-textarea" rows="3">{{ old('description', $booking->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Persetujuan -->
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Penyetuju Berjenjang</span>
                </div>
                <div class="form-card-body">
                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Penyetuju Tingkat 1 <span class="required">*</span></label>
                            <select name="approver1_id" class="form-select-clean" required>
                                @foreach($approvers->where('approval_level', 1) as $appr1)
                                <option value="{{ $appr1->id }}" {{ old('approver1_id', $booking->approver1_id) == $appr1->id ? 'selected' : '' }}>
                                    {{ $appr1->name }} ({{ $appr1->position ?? 'Level 1' }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Penyetuju Tingkat 2 <span class="required">*</span></label>
                            <select name="approver2_id" class="form-select-clean" required>
                                @foreach($approvers->where('approval_level', 2) as $appr2)
                                <option value="{{ $appr2->id }}" {{ old('approver2_id', $booking->approver2_id) == $appr2->id ? 'selected' : '' }}>
                                    {{ $appr2->name }} ({{ $appr2->position ?? 'Level 2' }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Armada & Driver -->
        <div>
            <div class="form-card" style="position: sticky; top: 100px;">
                <div class="form-card-header">
                    <i class="fas fa-truck"></i>
                    <span>Armada & Driver</span>
                </div>
                <div class="form-card-body">
                    <div class="form-group">
                        <label class="form-label">Pilih Kendaraan <span class="required">*</span></label>
                        <select name="vehicle_id" class="form-select-clean" required>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $booking->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate_number }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pilih Driver <span class="required">*</span></label>
                        <select name="driver_id" class="form-select-clean" required>
                            @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id', $booking->driver_id) == $driver->id ? 'selected' : '' }}>
                                {{ $driver->name }} (SIM {{ $driver->license_type ?? 'B1' }} - {{ $driver->location }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <hr style="border: none; border-top: 1px dashed #e2e8f0; margin: 20px 0;">

                    <div class="form-actions-bar">
                        <a href="{{ route('bookings.index') }}" class="btn-cancel-back">Batal</a>
                        <button type="submit" class="btn-save-submit">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
