@extends('layouts.app')
@section('title', 'Pemesanan Kendaraan')
@section('page-title', 'Pemesanan Kendaraan')
@section('page-subtitle', 'Kelola permintaan dan pantau status pemesanan armada.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <span class="current">Pemesanan</span>
@endsection

@section('content')
<style>
    /* Top action buttons bar */
    .page-top-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-bottom: 22px;
    }

    .btn-export-excel {
        background: #ffffff;
        color: #10b981;
        border: 1.5px solid #10b981;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-export-excel:hover {
        background: #ecfdf5;
        color: #059669;
        transform: translateY(-1px);
    }

    .btn-add-booking {
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

    .btn-add-booking:hover {
        background: var(--btn-green-hover);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(27, 110, 78, 0.35);
    }

    /* Filter card */
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        padding: 20px 24px;
        margin-bottom: 22px;
    }

    .filter-card-header {
        font-size: 14.5px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .filter-card-header i {
        color: #10b981;
    }

    .filter-search-box {
        position: relative;
        margin-bottom: 14px;
    }

    .filter-search-box i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 15px;
    }

    .filter-search-input {
        width: 100%;
        height: 44px;
        padding: 0 16px 0 44px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13.5px;
        color: #0f172a;
        font-family: inherit;
        outline: none;
        transition: all 0.2s;
    }

    .filter-search-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }

    .filter-bottom-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-select {
        height: 42px;
        padding: 0 14px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        color: #334155;
        font-family: inherit;
        outline: none;
        min-width: 170px;
        cursor: pointer;
    }

    .filter-select:focus {
        border-color: #10b981;
    }

    .filter-date-input {
        height: 42px;
        padding: 0 12px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        color: #334155;
        font-family: inherit;
        outline: none;
    }

    .filter-date-input:focus {
        border-color: #10b981;
    }

    .btn-reset-filter {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        height: 42px;
        padding: 0 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        margin-left: auto;
    }

    .btn-reset-filter:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .btn-apply-filter {
        background: var(--btn-green);
        border: none;
        color: #ffffff;
        height: 42px;
        padding: 0 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 6px rgba(27, 110, 78, 0.25);
    }

    .btn-apply-filter:hover {
        background: var(--btn-green-hover);
    }

    /* 5 Stat cards row */
    .booking-stats-row {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .booking-stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px 14px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .booking-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .bs-green  { background: #ecfdf5; color: #10b981; }
    .bs-teal   { background: #f0fdf4; color: #059669; }
    .bs-yellow { background: #fffbeb; color: #d97706; }
    .bs-blue   { background: #eff6ff; color: #3b82f6; }
    .bs-red    { background: #fef2f2; color: #dc2626; }

    .booking-stat-title {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .booking-stat-val-row {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .booking-stat-num {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .booking-stat-trend {
        font-size: 10.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 2px;
    }

    .booking-stat-trend.up { color: #10b981; }
    .booking-stat-trend.neutral { color: #64748b; }
    .booking-stat-trend.down { color: #ef4444; }

    .booking-stat-period {
        font-size: 9.5px;
        color: #94a3b8;
        display: block;
        margin-top: 2px;
    }

    /* Table Card */
    .table-container-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .table-top-bar {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-heading-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
    }

    .table-pagination-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 12.5px;
        color: #64748b;
    }

    /* Custom Pagination Pills */
    .custom-pagination-pills {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .page-pill {
        min-width: 30px;
        height: 30px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .page-pill:hover:not(.disabled):not(.active) {
        background: #f1f5f9;
        color: #0f172a;
    }

    .page-pill.active {
        background: var(--btn-green);
        border-color: var(--btn-green);
        color: #ffffff;
        font-weight: 700;
    }

    .page-pill.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Table Details */
    .table-clean {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table-clean th {
        background: #f8fafc;
        padding: 14px 18px;
        font-weight: 700;
        color: #475569;
        text-align: left;
        border-bottom: 1.5px solid #f1f5f9;
        white-space: nowrap;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-clean td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .table-clean tbody tr:hover {
        background: #fafcfb;
    }

    .cell-bold {
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
    }

    .cell-sub {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Status Badges */
    .badge-pill-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.2px;
        white-space: nowrap;
    }

    .status-completed  { background: #ecfdf5; color: #059669; }
    .status-approved   { background: #eff6ff; color: #2563eb; }
    .status-pending    { background: #fffbeb; color: #d97706; }
    .status-rejected   { background: #fef2f2; color: #dc2626; }
    .status-cancelled  { background: #fef2f2; color: #dc2626; }

    /* Action buttons */
    .actions-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-square {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.15s ease;
    }

    .btn-action-square:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    @media (max-width: 1024px) {
        .booking-stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- TOP ACTION BUTTONS BAR -->
<div class="page-top-actions">
    <a href="{{ route('bookings.export') }}" class="btn-export-excel" title="Download Excel">
        <i class="fas fa-file-excel"></i>
        <span>Export Excel</span>
    </a>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('bookings.create') }}" class="btn-add-booking" title="Buat Pemesanan Baru">
        <i class="fas fa-plus"></i>
        <span>Buat Pemesanan</span>
    </a>
    @endif
</div>

<!-- FILTER CARD -->
<div class="filter-card">
    <div class="filter-card-header">
        <i class="fas fa-filter"></i>
        <span>Filter Pemesanan</span>
    </div>

    <form method="GET" action="{{ route('bookings.index') }}">
        <div class="filter-search-box">
            <i class="fas fa-search"></i>
            <input 
                type="text" 
                name="search" 
                class="filter-search-input" 
                placeholder="Cari nomor, tujuan, pemohon..."
                value="{{ request('search') }}"
            >
        </div>

        <div class="filter-bottom-row">
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                <option value="approved_l1" {{ request('status') === 'approved_l1' ? 'selected' : '' }}>Disetujui L1</option>
                <option value="approved_l2" {{ request('status') === 'approved_l2' ? 'selected' : '' }}>Disetujui / Diproses</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <input 
                type="date" 
                name="date_from" 
                class="filter-date-input" 
                value="{{ request('date_from') }}" 
                title="Dari Tanggal"
            >
            <span style="color: #94a3b8; font-size: 13px;">-</span>
            <input 
                type="date" 
                name="date_to" 
                class="filter-date-input" 
                value="{{ request('date_to') }}" 
                title="Sampai Tanggal"
            >

            <a href="{{ route('bookings.index') }}" class="btn-reset-filter">
                <i class="fas fa-rotate-left"></i>
                <span>Reset</span>
            </a>

            <button type="submit" class="btn-apply-filter">
                <i class="fas fa-filter"></i>
                <span>Terapkan Filter</span>
            </button>
        </div>
    </form>
</div>

<!-- 5 STATS CARDS ROW -->
<div class="booking-stats-row">
    <!-- Total Pemesanan -->
    <div class="booking-stat-card">
        <div class="booking-stat-icon bs-green">
            <i class="fas fa-truck"></i>
        </div>
        <div>
            <div class="booking-stat-title">Total Pemesanan</div>
            <div class="booking-stat-val-row">
                <span class="booking-stat-num">{{ $stats['total'] }}</span>
                <span class="booking-stat-trend up">
                    <i class="fas fa-arrow-up"></i> 12%
                </span>
            </div>
            <span class="booking-stat-period">vs bulan lalu</span>
        </div>
    </div>

    <!-- Selesai -->
    <div class="booking-stat-card">
        <div class="booking-stat-icon bs-teal">
            <i class="fas fa-circle-check"></i>
        </div>
        <div>
            <div class="booking-stat-title">Selesai</div>
            <div class="booking-stat-val-row">
                <span class="booking-stat-num">{{ $stats['completed'] }}</span>
                <span class="booking-stat-trend up">
                    <i class="fas fa-arrow-up"></i> 8%
                </span>
            </div>
            <span class="booking-stat-period">vs bulan lalu</span>
        </div>
    </div>

    <!-- Menunggu Persetujuan -->
    <div class="booking-stat-card">
        <div class="booking-stat-icon bs-yellow">
            <i class="fas fa-hourglass-half"></i>
        </div>
        <div>
            <div class="booking-stat-title">Menunggu Persetujuan</div>
            <div class="booking-stat-val-row">
                <span class="booking-stat-num">{{ $stats['pending'] }}</span>
                <span class="booking-stat-trend up">
                    <i class="fas fa-arrow-up"></i> 50%
                </span>
            </div>
            <span class="booking-stat-period">vs bulan lalu</span>
        </div>
    </div>

    <!-- Dalam Proses -->
    <div class="booking-stat-card">
        <div class="booking-stat-icon bs-blue">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <div class="booking-stat-title">Dalam Proses</div>
            <div class="booking-stat-val-row">
                <span class="booking-stat-num">{{ $stats['in_progress'] }}</span>
                <span class="booking-stat-trend neutral">
                    <i class="fas fa-arrow-up"></i> 0%
                </span>
            </div>
            <span class="booking-stat-period">vs bulan lalu</span>
        </div>
    </div>

    <!-- Dibatalkan -->
    <div class="booking-stat-card">
        <div class="booking-stat-icon bs-red">
            <i class="fas fa-times-circle"></i>
        </div>
        <div>
            <div class="booking-stat-title">Dibatalkan</div>
            <div class="booking-stat-val-row">
                <span class="booking-stat-num">{{ $stats['cancelled'] }}</span>
                <span class="booking-stat-trend down">
                    <i class="fas fa-arrow-down"></i> 0%
                </span>
            </div>
            <span class="booking-stat-period">vs bulan lalu</span>
        </div>
    </div>
</div>

<!-- TABLE CARD -->
<div class="table-container-card">
    <div class="table-top-bar">
        <div class="table-heading-title">Daftar Pemesanan</div>

        <div class="table-pagination-meta">
            <span>Menampilkan {{ $bookings->firstItem() ?? 0 }}-{{ $bookings->lastItem() ?? 0 }} dari {{ $bookings->total() }} data</span>

            <!-- Custom Pagination Links -->
            @if($bookings->hasPages())
            <div class="custom-pagination-pills">
                {{-- Previous Page Link --}}
                @if ($bookings->onFirstPage())
                    <span class="page-pill disabled">&lt;</span>
                @else
                    <a href="{{ $bookings->previousPageUrl() }}" class="page-pill">&lt;</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                    @if ($page == $bookings->currentPage())
                        <span class="page-pill active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-pill">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($bookings->hasMorePages())
                    <a href="{{ $bookings->nextPageUrl() }}" class="page-pill">&gt;</a>
                @else
                    <span class="page-pill disabled">&gt;</span>
                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table-clean">
            <thead>
                <tr>
                    <th style="width: 15%;">No. Pemesanan</th>
                    <th style="width: 16%;">Pemohon</th>
                    <th style="width: 15%;">Kendaraan</th>
                    <th style="width: 16%;">Tujuan</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 14%;">Penyetuju</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 7%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <!-- No. Pemesanan -->
                    <td>
                        <div class="cell-bold">{{ $booking->booking_number }}</div>
                        <div class="cell-sub">{{ $booking->created_at->isoFormat('D MMM Y') }}</div>
                    </td>

                    <!-- Pemohon -->
                    <td>
                        <div class="cell-bold">{{ $booking->user->name ?? 'Administrator' }}</div>
                        <div class="cell-sub">{{ $booking->user->department ?? 'Operasional' }}</div>
                    </td>

                    <!-- Kendaraan -->
                    <td>
                        <div class="cell-bold">{{ $booking->vehicle->brand ?? '-' }} {{ $booking->vehicle->model ?? '' }}</div>
                        <div class="cell-sub">{{ $booking->vehicle->plate_number ?? '-' }}</div>
                    </td>

                    <!-- Tujuan -->
                    <td>
                        <div class="cell-bold" style="display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-location-dot" style="color: #64748b; font-size: 11px;"></i>
                            <span>{{ $booking->destination }}</span>
                        </div>
                        <div class="cell-sub">{{ $booking->purpose }}</div>
                    </td>

                    <!-- Tanggal -->
                    <td>
                        <div class="cell-sub" style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 5px;">
                            <i class="far fa-calendar" style="color: #64748b; font-size: 11px;"></i>
                            <span>Berangkat: {{ \Carbon\Carbon::parse($booking->departure_datetime)->isoFormat('D MMM Y HH:mm') }}</span>
                        </div>
                        <div class="cell-sub" style="margin-left: 16px;">
                            Kembali: {{ \Carbon\Carbon::parse($booking->return_datetime)->isoFormat('D MMM Y HH:mm') }}
                        </div>
                    </td>

                    <!-- Penyetuju -->
                    <td>
                        <div class="cell-sub" style="color: #334155;">
                            <strong>L1:</strong> {{ $booking->approver1->name ?? '-' }}
                        </div>
                        <div class="cell-sub" style="color: #334155;">
                            <strong>L2:</strong> {{ $booking->approver2->name ?? '-' }}
                        </div>
                    </td>

                    <!-- Status -->
                    <td>
                        @php
                            $statusMap = [
                                'completed' => ['label' => 'Selesai', 'class' => 'status-completed'],
                                'approved_l2' => ['label' => 'Diproses', 'class' => 'status-approved'],
                                'approved_l1' => ['label' => 'Disetujui L1', 'class' => 'status-approved'],
                                'pending' => ['label' => 'Menunggu', 'class' => 'status-pending'],
                                'rejected' => ['label' => 'Ditolak', 'class' => 'status-rejected'],
                                'cancelled' => ['label' => 'Dibatalkan', 'class' => 'status-cancelled'],
                            ];
                            $st = $statusMap[$booking->status] ?? ['label' => ucfirst($booking->status), 'class' => 'status-pending'];
                        @endphp
                        <span class="badge-pill-status {{ $st['class'] }}">
                            {{ $st['label'] }}
                        </span>
                    </td>

                    <!-- Aksi -->
                    <td style="text-align: center;">
                        <div class="actions-group" style="justify-content: center;">
                            <a href="{{ route('bookings.show', $booking) }}" class="btn-action-square" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin() && in_array($booking->status, ['pending', 'approved_l1']))
                            <a href="{{ route('bookings.edit', $booking) }}" class="btn-action-square" title="Edit Pemesanan">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 48px; color: #94a3b8;">
                        <i class="fas fa-inbox" style="font-size: 36px; margin-bottom: 12px; display: block; color: #cbd5e1;"></i>
                        <div style="font-weight: 700; font-size: 14px; color: #475569;">Tidak ada data pemesanan ditemukan</div>
                        <div style="font-size: 12px; margin-top: 4px;">Coba ubah filter atau kata kunci pencarian Anda.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
