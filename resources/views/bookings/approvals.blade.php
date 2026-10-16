@extends('layouts.app')
@section('title', 'Persetujuan Pemesanan')
@section('page-title', 'Persetujuan Pemesanan')
@section('page-subtitle', 'Tinjau dan proses permohonan pemesanan kendaraan sesuai tingkat kewenangan Anda.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <a href="{{ route('bookings.index') }}">Pemesanan</a>
    <span class="separator">></span>
    <span class="current">Persetujuan</span>
@endsection

@section('content')
<style>
    .approval-section {
        margin-bottom: 32px;
    }

    .approval-section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .level-badge-number {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
    }

    .level-1-badge { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .level-2-badge { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }

    .approval-section-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
    }

    .approval-count-badge {
        background: #ef4444;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
    }

    .approval-item-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        padding: 20px 24px;
        margin-bottom: 16px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .approval-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    .border-l1 { border-left: 4px solid #f59e0b; }
    .border-l2 { border-left: 4px solid #0284c7; }

    .card-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .booking-code-chip {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .meta-details-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        background: #f8fafc;
        border-radius: 12px;
        padding: 14px 16px;
        margin-top: 14px;
        margin-bottom: 16px;
    }

    .meta-label {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .meta-val-text {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .meta-sub-text {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    .approval-actions-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-action-view {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-view:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .btn-action-approve {
        background: var(--btn-green);
        border: none;
        color: #ffffff;
        padding: 9px 18px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(27, 110, 78, 0.25);
    }

    .btn-action-approve:hover {
        background: var(--btn-green-hover);
    }

    .btn-action-reject {
        background: #fef2f2;
        border: 1.5px solid #fecaca;
        color: #dc2626;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-reject:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Modal */
    .reject-modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .reject-modal-backdrop.show {
        display: flex;
    }

    .reject-modal-card {
        background: #ffffff;
        border-radius: 16px;
        max-width: 440px;
        width: 100%;
        padding: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 900px) {
        .meta-details-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- SECTION 1: Menunggu Persetujuan Level 1 -->
<div class="approval-section">
    <div class="approval-section-header">
        <div class="level-badge-number level-1-badge">1</div>
        <h3 class="approval-section-title">Persetujuan Tingkat 1 (Atasan Langsung)</h3>
        @if($pendingL1->count() > 0)
        <span class="approval-count-badge">{{ $pendingL1->count() }} Permohonan</span>
        @endif
    </div>

    @forelse($pendingL1 as $booking)
    <div class="approval-item-card border-l1">
        <div class="card-top-row">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="booking-code-chip">{{ $booking->booking_number }}</span>
                <span class="badge-pill-status status-pending">Menunggu Level 1</span>
            </div>
            <span style="font-size: 12px; color: #64748b;">Diajukan: {{ $booking->created_at->isoFormat('D MMMM Y HH:mm') }}</span>
        </div>

        <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
            <i class="fas fa-location-dot" style="color: #10b981; font-size: 14px;"></i> {{ $booking->destination }}
        </div>
        <div style="font-size: 13.5px; color: #475569;">{{ $booking->purpose }}</div>

        <!-- Meta Grid -->
        <div class="meta-details-grid">
            <div>
                <div class="meta-label"><i class="fas fa-user"></i> Pemohon</div>
                <div class="meta-val-text">{{ $booking->user->name ?? '-' }}</div>
                <div class="meta-sub-text">{{ $booking->user->department ?? 'Operasional' }}</div>
            </div>
            <div>
                <div class="meta-label"><i class="fas fa-truck"></i> Kendaraan</div>
                <div class="meta-val-text">{{ $booking->vehicle->brand ?? '-' }} {{ $booking->vehicle->model ?? '' }}</div>
                <div class="meta-sub-text">{{ $booking->vehicle->plate_number ?? '-' }}</div>
            </div>
            <div>
                <div class="meta-label"><i class="fas fa-id-card"></i> Driver</div>
                <div class="meta-val-text">{{ $booking->driver->name ?? 'Belum Ditentukan' }}</div>
                <div class="meta-sub-text">{{ $booking->driver->phone ?? '-' }}</div>
            </div>
            <div>
                <div class="meta-label"><i class="far fa-calendar"></i> Jadwal</div>
                <div class="meta-val-text">{{ \Carbon\Carbon::parse($booking->departure_datetime)->isoFormat('D MMM Y') }}</div>
                <div class="meta-sub-text">Kembali: {{ \Carbon\Carbon::parse($booking->return_datetime)->isoFormat('D MMM Y') }}</div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="approval-actions-bar">
            <a href="{{ route('bookings.show', $booking) }}" class="btn-action-view">
                <i class="fas fa-eye"></i> Detail
            </a>

            @if(auth()->user()->isAdmin() || (auth()->user()->isApprover() && ($booking->approver1_id == auth()->id() || auth()->user()->approval_level == 1)))
            <form method="POST" action="{{ route('bookings.approve-l1', $booking) }}" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pemesanan ini untuk Tingkat 1?')">
                @csrf
                <button type="submit" class="btn-action-approve">
                    <i class="fas fa-check"></i> Setujui Level 1
                </button>
            </form>

            <button type="button" class="btn-action-reject" onclick="openRejectModal('{{ route('bookings.reject', $booking) }}', '{{ $booking->booking_number }}')">
                <i class="fas fa-times"></i> Tolak
            </button>
            @endif
        </div>
    </div>
    @empty
    <div style="background: #ffffff; border-radius: 14px; border: 1px dashed #e2e8f0; padding: 32px; text-align: center; color: #94a3b8;">
        <i class="fas fa-circle-check" style="font-size: 28px; color: #10b981; margin-bottom: 8px; display: block;"></i>
        <div style="font-weight: 700; color: #334155;">Tidak ada permohonan pending Level 1</div>
        <div style="font-size: 12px; margin-top: 2px;">Semua permohonan tingkat 1 telah diproses.</div>
    </div>
    @endforelse
</div>

<!-- SECTION 2: Menunggu Persetujuan Level 2 -->
<div class="approval-section">
    <div class="approval-section-header">
        <div class="level-badge-number level-2-badge">2</div>
        <h3 class="approval-section-title">Persetujuan Tingkat 2 (Manajemen / Direksi)</h3>
        @if($pendingL2->count() > 0)
        <span class="approval-count-badge">{{ $pendingL2->count() }} Permohonan</span>
        @endif
    </div>

    @forelse($pendingL2 as $booking)
    <div class="approval-item-card border-l2">
        <div class="card-top-row">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="booking-code-chip">{{ $booking->booking_number }}</span>
                <span class="badge-pill-status status-approved">Disetujui L1 - Menunggu L2</span>
            </div>
            <span style="font-size: 12px; color: #64748b;">Diajukan: {{ $booking->created_at->isoFormat('D MMMM Y HH:mm') }}</span>
        </div>

        <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
            <i class="fas fa-location-dot" style="color: #0284c7; font-size: 14px;"></i> {{ $booking->destination }}
        </div>
        <div style="font-size: 13.5px; color: #475569;">{{ $booking->purpose }}</div>

        <!-- Meta Grid -->
        <div class="meta-details-grid">
            <div>
                <div class="meta-label"><i class="fas fa-user"></i> Pemohon</div>
                <div class="meta-val-text">{{ $booking->user->name ?? '-' }}</div>
                <div class="meta-sub-text">{{ $booking->user->department ?? 'Operasional' }}</div>
            </div>
            <div>
                <div class="meta-label"><i class="fas fa-truck"></i> Kendaraan</div>
                <div class="meta-val-text">{{ $booking->vehicle->brand ?? '-' }} {{ $booking->vehicle->model ?? '' }}</div>
                <div class="meta-sub-text">{{ $booking->vehicle->plate_number ?? '-' }}</div>
            </div>
            <div>
                <div class="meta-label"><i class="fas fa-id-card"></i> Driver</div>
                <div class="meta-val-text">{{ $booking->driver->name ?? 'Belum Ditentukan' }}</div>
                <div class="meta-sub-text">{{ $booking->driver->phone ?? '-' }}</div>
            </div>
            <div>
                <div class="meta-label"><i class="far fa-calendar"></i> Jadwal</div>
                <div class="meta-val-text">{{ \Carbon\Carbon::parse($booking->departure_datetime)->isoFormat('D MMM Y') }}</div>
                <div class="meta-sub-text">Kembali: {{ \Carbon\Carbon::parse($booking->return_datetime)->isoFormat('D MMM Y') }}</div>
            </div>
        </div>

        <div style="font-size: 12px; color: #065f46; background: #ecfdf5; border-radius: 8px; padding: 8px 12px; margin-bottom: 14px;">
            <i class="fas fa-check-double"></i> Telah disetujui Tingkat 1 oleh: <strong>{{ $booking->approver1->name ?? 'Atasan Langsung' }}</strong>
            pada {{ $booking->approved_at_l1 ? \Carbon\Carbon::parse($booking->approved_at_l1)->isoFormat('D MMM Y HH:mm') : '-' }}
        </div>

        <!-- Action Buttons -->
        <div class="approval-actions-bar">
            <a href="{{ route('bookings.show', $booking) }}" class="btn-action-view">
                <i class="fas fa-eye"></i> Detail
            </a>

            @if(auth()->user()->isAdmin() || (auth()->user()->isApprover() && ($booking->approver2_id == auth()->id() || auth()->user()->approval_level == 2)))
            <form method="POST" action="{{ route('bookings.approve-l2', $booking) }}" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui final permohonan pemesanan ini?')">
                @csrf
                <button type="submit" class="btn-action-approve">
                    <i class="fas fa-check-double"></i> Setujui Final (Level 2)
                </button>
            </form>

            <button type="button" class="btn-action-reject" onclick="openRejectModal('{{ route('bookings.reject', $booking) }}', '{{ $booking->booking_number }}')">
                <i class="fas fa-times"></i> Tolak
            </button>
            @endif
        </div>
    </div>
    @empty
    <div style="background: #ffffff; border-radius: 14px; border: 1px dashed #e2e8f0; padding: 32px; text-align: center; color: #94a3b8;">
        <i class="fas fa-circle-check" style="font-size: 28px; color: #10b981; margin-bottom: 8px; display: block;"></i>
        <div style="font-weight: 700; color: #334155;">Tidak ada permohonan pending Level 2</div>
        <div style="font-size: 12px; margin-top: 2px;">Semua permohonan tingkat 2 telah diproses.</div>
    </div>
    @endforelse
</div>

<!-- REJECT MODAL -->
<div class="reject-modal-backdrop" id="rejectModal">
    <div class="reject-modal-card">
        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">
            <i class="fas fa-circle-xmark" style="color: #ef4444;"></i> Tolak Pemesanan
        </h3>
        <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">
            Nomor: <strong id="modalBookingNumber" style="color: #0f172a;"></strong>
        </p>

        <form method="POST" id="rejectForm">
            @csrf
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="rejection_reason" class="form-label">Alasan Penolakan <span style="color: #ef4444;">*</span></label>
                <textarea 
                    name="rejection_reason" 
                    id="rejection_reason" 
                    class="form-control" 
                    rows="3" 
                    placeholder="Tuliskan alasan penolakan secara jelas..." 
                    required
                ></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn-action-view" onclick="closeRejectModal()">Batal</button>
                <button type="submit" class="btn-action-reject" style="border: none; background: #dc2626; color: white;">
                    <i class="fas fa-times"></i> Ya, Tolak Pemesanan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(actionUrl, bookingNumber) {
        document.getElementById('rejectForm').action = actionUrl;
        document.getElementById('modalBookingNumber').innerText = bookingNumber;
        document.getElementById('rejectModal').classList.add('show');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('show');
    }
</script>
@endsection
