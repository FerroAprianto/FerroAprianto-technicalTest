@extends('layouts.app')
@section('title', 'Manajemen Kendaraan')
@section('page-title', 'Manajemen Kendaraan')
@section('page-subtitle', 'Kelola inventaris armada kendaraan operasional tambang dan status penggunaannya.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <span class="separator">Armada</span>
    <span class="separator">></span>
    <span class="current">Kendaraan</span>
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
        box-shadow: 0 4px 12px rgba(27, 110, 78, 0.35);
    }

    .plate-number-badge {
        display: inline-block;
        background: #0f172a;
        color: #ffffff;
        border-radius: 6px;
        padding: 4px 8px;
        font-family: monospace;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.5px;
        border: 1px solid #334155;
    }
</style>

<!-- TOP ACTION -->
<div class="page-top-actions">
    <a href="{{ route('vehicles.create') }}" class="btn-add-primary">
        <i class="fas fa-plus"></i>
        <span>Tambah Kendaraan</span>
    </a>
</div>

<!-- FILTER CARD -->
<div class="filter-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; padding: 20px 24px; margin-bottom: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <div style="font-size: 14.5px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
        <i class="fas fa-filter" style="color: #10b981;"></i>
        <span>Filter Kendaraan</span>
    </div>

    <form method="GET" action="{{ route('vehicles.index') }}">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="position: relative; flex: 1; min-width: 220px;">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px;"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari plat nomor, merek, atau model..." 
                    style="width: 100%; height: 42px; padding: 0 14px 0 40px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13.5px; outline: none;"
                >
            </div>

            <select name="type" style="height: 42px; padding: 0 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #334155; outline: none;">
                <option value="">Semua Jenis</option>
                <option value="passenger" {{ request('type') == 'passenger' ? 'selected' : '' }}>Angkutan Orang</option>
                <option value="cargo" {{ request('type') == 'cargo' ? 'selected' : '' }}>Angkutan Barang</option>
            </select>

            <select name="status" style="height: 42px; padding: 0 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #334155; outline: none;">
                <option value="">Semua Status</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>Sedang Digunakan</option>
                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Dalam Perawatan</option>
            </select>

            <select name="ownership" style="height: 42px; padding: 0 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #334155; outline: none;">
                <option value="">Semua Kepemilikan</option>
                <option value="own" {{ request('ownership') == 'own' ? 'selected' : '' }}>Milik Perusahaan</option>
                <option value="rental" {{ request('ownership') == 'rental' ? 'selected' : '' }}>Sewa (Rental)</option>
            </select>

            <a href="{{ route('vehicles.index') }}" style="height: 42px; padding: 0 16px; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; color: #475569; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                <i class="fas fa-rotate-left"></i> Reset
            </a>

            <button type="submit" style="height: 42px; padding: 0 18px; background: var(--btn-green); border: none; border-radius: 10px; color: #ffffff; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- VEHICLES TABLE CARD -->
<div class="table-container-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">Daftar Armada Kendaraan</div>
        <div style="font-size: 12.5px; color: #64748b;">Total: <strong>{{ $vehicles->total() }}</strong> unit kendaraan terdaftar</div>
    </div>

    <div class="table-wrapper">
        <table class="table-clean" style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1.5px solid #f1f5f9; text-align: left;">
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Kendaraan</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Plat Nomor</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Tipe</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Kepemilikan</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Lokasi Pool/Site</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">BBM & Servis</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Status</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <!-- Kendaraan -->
                    <td style="padding: 14px 18px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #ecfdf5; border: 1px solid #a7f3d0; display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 15px; flex-shrink: 0;">
                                <i class="fas fa-{{ $vehicle->type === 'cargo' ? 'truck' : 'car-side' }}"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #0f172a;">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                                <div style="font-size: 11.5px; color: #64748b;">Tahun {{ $vehicle->year }} • {{ $vehicle->color ?? 'Standar' }}</div>
                            </div>
                        </div>
                    </td>

                    <!-- Plat Nomor -->
                    <td style="padding: 14px 18px;">
                        <span class="plate-number-badge">{{ $vehicle->plate_number }}</span>
                    </td>

                    <!-- Tipe -->
                    <td style="padding: 14px 18px;">
                        <span style="font-weight: 600; color: #334155;">
                            {{ $vehicle->type === 'cargo' ? 'Angkutan Barang' : 'Angkutan Orang' }}
                        </span>
                    </td>

                    <!-- Kepemilikan -->
                    <td style="padding: 14px 18px;">
                        @if($vehicle->ownership === 'own')
                        <span style="display: inline-flex; align-items: center; gap: 5px; font-weight: 600; color: #059669;">
                            <i class="fas fa-building" style="font-size: 11px;"></i> Milik Sendiri
                        </span>
                        @else
                        <div>
                            <span style="display: inline-flex; align-items: center; gap: 5px; font-weight: 600; color: #2563eb;">
                                <i class="fas fa-handshake" style="font-size: 11px;"></i> Sewa (Rental)
                            </span>
                            @if($vehicle->rental_company)
                            <div style="font-size: 11px; color: #64748b;">{{ $vehicle->rental_company }}</div>
                            @endif
                        </div>
                        @endif
                    </td>

                    <!-- Lokasi -->
                    <td style="padding: 14px 18px;">
                        <div style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-location-dot" style="color: #64748b; font-size: 11px;"></i>
                            <span>{{ $vehicle->location }}</span>
                        </div>
                    </td>

                    <!-- BBM & Servis -->
                    <td style="padding: 14px 18px;">
                        <div style="font-size: 12px; color: #334155;">
                            <i class="fas fa-gas-pump" style="color: #10b981; font-size: 11px;"></i>
                            <strong>{{ $vehicle->fuel_consumption ?? '-' }}</strong> km/L ({{ $vehicle->fuel_capacity }}L)
                        </div>
                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                            Servis: {{ $vehicle->next_service_km ? number_format($vehicle->next_service_km, 0, ',', '.') . ' km' : '-' }}
                        </div>
                    </td>

                    <!-- Status -->
                    <td style="padding: 14px 18px;">
                        @php
                            $stMap = [
                                'available' => ['class' => 'status-completed', 'text' => 'Tersedia'],
                                'in_use' => ['class' => 'status-approved', 'text' => 'Digunakan'],
                                'maintenance' => ['class' => 'status-rejected', 'text' => 'Perawatan'],
                                'retired' => ['class' => 'status-cancelled', 'text' => 'Nonaktif'],
                            ];
                            $stat = $stMap[$vehicle->status] ?? ['class' => 'status-pending', 'text' => ucfirst($vehicle->status)];
                        @endphp
                        <span class="badge-pill-status {{ $stat['class'] }}">
                            {{ $stat['text'] }}
                        </span>
                    </td>

                    <!-- Aksi -->
                    <td style="padding: 14px 18px; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn-action-square" title="Edit Kendaraan">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan {{ $vehicle->plate_number }}?')" style="display: inline;">
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
                        <i class="fas fa-car" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                        <div style="font-weight: 700; color: #334155;">Tidak ada kendaraan ditemukan</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($vehicles->hasPages())
    <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end;">
        {{ $vehicles->links() }}
    </div>
    @endif
</div>
@endsection
