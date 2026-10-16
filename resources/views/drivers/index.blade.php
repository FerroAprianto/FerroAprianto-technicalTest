@extends('layouts.app')
@section('title', 'Manajemen Driver')
@section('page-title', 'Manajemen Driver')
@section('page-subtitle', 'Kelola data pengemudi operasional tambang, lisensi berkendara (SIM), dan status ketersediaannya.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <span class="separator">Armada</span>
    <span class="separator">></span>
    <span class="current">Driver</span>
@endsection

@section('content')
<style>
    .page-top-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-bottom: 22px;
    }

    .btn-add-primary {
        background: var(--btn-green);
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(27, 110, 78, 0.25);
        transition: all 0.2s ease;
    }

    .btn-add-primary:hover {
        background: var(--btn-green-hover);
        color: #ffffff;
        transform: translateY(-1px);
    }
</style>

<!-- TOP ACTION -->
<div class="page-top-actions">
    <a href="{{ route('drivers.create') }}" class="btn-add-primary">
        <i class="fas fa-user-plus"></i>
        <span>Tambah Driver</span>
    </a>
</div>

<!-- FILTER CARD -->
<div class="filter-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; padding: 20px 24px; margin-bottom: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <div style="font-size: 14.5px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
        <i class="fas fa-filter" style="color: #10b981;"></i>
        <span>Filter Driver</span>
    </div>

    <form method="GET" action="{{ route('drivers.index') }}">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="position: relative; flex: 1; min-width: 220px;">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px;"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama, nomor SIM, atau ID karyawan..." 
                    style="width: 100%; height: 42px; padding: 0 14px 0 40px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13.5px; outline: none;"
                >
            </div>

            <select name="status" style="height: 42px; padding: 0 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #334155; outline: none;">
                <option value="">Semua Status</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                <option value="on_duty" {{ request('status') == 'on_duty' ? 'selected' : '' }}>Bertugas</option>
                <option value="off" {{ request('status') == 'off' ? 'selected' : '' }}>Libur / Cuti</option>
            </select>

            <a href="{{ route('drivers.index') }}" style="height: 42px; padding: 0 16px; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; color: #475569; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                <i class="fas fa-rotate-left"></i> Reset
            </a>

            <button type="submit" style="height: 42px; padding: 0 18px; background: var(--btn-green); border: none; border-radius: 10px; color: #ffffff; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- DRIVER TABLE CARD -->
<div class="table-container-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">Daftar Driver Armada</div>
        <div style="font-size: 12.5px; color: #64748b;">Total: <strong>{{ $drivers->total() }}</strong> driver terdaftar</div>
    </div>

    <div class="table-wrapper">
        <table class="table-clean" style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1.5px solid #f1f5f9; text-align: left;">
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Driver</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">ID Karyawan</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Lisensi / SIM</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Masa Berlaku SIM</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Lokasi Penugasan</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">No. Telepon</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Status</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $driver)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <!-- Driver Info -->
                    <td style="padding: 14px 18px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; background: #ecfdf5; border: 1.5px solid #a7f3d0; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #059669; font-size: 14px; flex-shrink: 0;">
                                {{ strtoupper(substr($driver->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #0f172a;">{{ $driver->name }}</div>
                                <div style="font-size: 11.5px; color: #64748b;">Pengemudi Operasional</div>
                            </div>
                        </div>
                    </td>

                    <!-- ID Karyawan -->
                    <td style="padding: 14px 18px;">
                        <span style="font-family: monospace; font-weight: 700; color: #334155; background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">
                            {{ $driver->employee_id ?? '-' }}
                        </span>
                    </td>

                    <!-- Lisensi / SIM -->
                    <td style="padding: 14px 18px;">
                        <div style="font-weight: 700; color: #1e293b;">SIM {{ $driver->license_type ?? 'B1' }}</div>
                        <div style="font-size: 11.5px; color: #64748b;">{{ $driver->license_number }}</div>
                    </td>

                    <!-- Masa Berlaku -->
                    <td style="padding: 14px 18px;">
                        @if($driver->license_expiry)
                        <div style="font-size: 12.5px; color: #334155; font-weight: 600;">
                            {{ \Carbon\Carbon::parse($driver->license_expiry)->isoFormat('D MMM Y') }}
                        </div>
                        @else
                        <span style="color: #94a3b8;">-</span>
                        @endif
                    </td>

                    <!-- Lokasi Penugasan -->
                    <td style="padding: 14px 18px;">
                        <div style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-location-dot" style="color: #64748b; font-size: 11px;"></i>
                            <span>{{ $driver->location }}</span>
                        </div>
                    </td>

                    <!-- Telepon -->
                    <td style="padding: 14px 18px;">
                        <div style="font-size: 12.5px; color: #334155;">{{ $driver->phone ?? '-' }}</div>
                    </td>

                    <!-- Status -->
                    <td style="padding: 14px 18px;">
                        @php
                            $dMap = [
                                'available' => ['class' => 'status-completed', 'text' => 'Tersedia'],
                                'on_duty' => ['class' => 'status-approved', 'text' => 'Bertugas'],
                                'off' => ['class' => 'status-cancelled', 'text' => 'Libur / Cuti'],
                            ];
                            $ds = $dMap[$driver->status] ?? ['class' => 'status-pending', 'text' => ucfirst($driver->status)];
                        @endphp
                        <span class="badge-pill-status {{ $ds['class'] }}">
                            {{ $ds['text'] }}
                        </span>
                    </td>

                    <!-- Aksi -->
                    <td style="padding: 14px 18px; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <a href="{{ route('drivers.edit', $driver) }}" class="btn-action-square" title="Edit Driver">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            <form method="POST" action="{{ route('drivers.destroy', $driver) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus driver {{ $driver->name }}?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-square" style="color: #ef4444; border-color: #fee2e2; background: #fff5f5;" title="Hapus">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 48px; color: #94a3b8;">
                        <i class="fas fa-id-card" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                        <div style="font-weight: 700; color: #334155;">Tidak ada data driver ditemukan</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($drivers->hasPages())
    <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end;">
        {{ $drivers->links() }}
    </div>
    @endif
</div>
@endsection
