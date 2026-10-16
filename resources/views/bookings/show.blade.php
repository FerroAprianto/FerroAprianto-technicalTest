@extends('layouts.app')
@section('title', 'Detail Pemesanan ' . $booking->booking_number)
@section('page-title', 'Detail Pemesanan ' . $booking->booking_number)
@section('page-subtitle', 'Informasi lengkap permohonan kendaraan, persetujuan bertingkat, dan status perjalanan.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <a href="{{ route('bookings.index') }}">Pemesanan</a>
    <span class="separator">></span>
    <span class="current">{{ $booking->booking_number }}</span>
@endsection

@section('content')
<div style="display: flex; justify-content: flex-end; gap: 8px; margin-bottom: 20px;">
    @if($booking->status === 'pending' && (auth()->user()->isAdmin() || $booking->user_id === auth()->id()))
    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-secondary">
        <i class="fas fa-edit"></i> Edit
    </a>
    <form method="POST" action="{{ route('bookings.cancel', $booking) }}" onsubmit="return confirm('Batalkan pemesanan ini?')">
        @csrf
        <button type="submit" class="btn btn-danger" style="background: #dc2626; color: white;"><i class="fas fa-times-circle"></i> Batalkan</button>
    </form>
    @endif
    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    <!-- Main Info -->
    <div>
        <!-- Status Banner -->
        <div class="card" style="margin-bottom: 20px; background: linear-gradient(135deg,
            {{ $booking->status === 'approved_l2' || $booking->status === 'completed' ? 'var(--green-600), var(--green-800)' : ($booking->status === 'rejected' || $booking->status === 'cancelled' ? '#dc2626, #991b1b' : ($booking->status === 'pending' ? '#d97706, #92400e' : '#2563eb, #1e40af')) }});">
            <div class="card-body" style="padding: 20px; color: white;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="font-size: 40px;">
                        @if($booking->status === 'approved_l2' || $booking->status === 'completed') <i class="fas fa-check-circle"></i>
                        @elseif($booking->status === 'rejected') <i class="fas fa-times-circle"></i>
                        @elseif($booking->status === 'cancelled') <i class="fas fa-ban"></i>
                        @elseif($booking->status === 'pending') <i class="fas fa-hourglass-half"></i>
                        @else <i class="fas fa-clock"></i>
                        @endif
                    </div>
                    <div>
                        <div style="font-size: 18px; font-weight: 800;">{{ $booking->getStatusLabel() }}</div>
                        <div style="font-size: 13px; opacity: 0.8;">Dibuat {{ $booking->created_at->isoFormat('D MMMM Y, HH:mm') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trip Details -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-map-marker-alt"></i> Detail Perjalanan</div>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Tujuan</label>
                        <div class="value">{{ $booking->destination }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Keperluan</label>
                        <div class="value">{{ $booking->purpose }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Tanggal Berangkat</label>
                        <div class="value">{{ $booking->departure_datetime?->isoFormat('D MMMM Y, HH:mm') }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Tanggal Kembali</label>
                        <div class="value">{{ $booking->return_datetime?->isoFormat('D MMMM Y, HH:mm') }}</div>
                    </div>
                    <div class="detail-item">
                        <label>Jumlah Penumpang</label>
                        <div class="value">{{ $booking->passenger_count }} orang</div>
                    </div>
                    <div class="detail-item">
                        <label>Pemohon</label>
                        <div class="value">{{ $booking->user?->name ?? '-' }}</div>
                    </div>
                    @if($booking->description)
                    <div class="detail-item" style="grid-column: span 2;">
                        <label>Keterangan</label>
                        <div class="value">{{ $booking->description }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Approval Timeline -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-stream"></i> Alur Persetujuan</div>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <!-- Step 1: Created -->
                    <div class="timeline-item">
                        <div class="timeline-time">{{ $booking->created_at->isoFormat('D MMM Y, HH:mm') }}</div>
                        <div class="timeline-content">
                            <span class="timeline-actor">{{ $booking->user?->name }}</span> membuat pemesanan kendaraan
                            <span class="badge badge-secondary">{{ $booking->booking_number }}</span>
                        </div>
                    </div>

                    <!-- Step 2: L1 Approval -->
                    <div class="timeline-item {{ in_array($booking->status, ['pending']) ? 'pending' : ($booking->status === 'rejected' && !$booking->approved_at_l1 ? 'rejected' : '') }}">
                        @if($booking->approved_at_l1)
                        <div class="timeline-time">{{ $booking->approved_at_l1->isoFormat('D MMM Y, HH:mm') }}</div>
                        <div class="timeline-content">
                            <span class="timeline-actor">{{ $booking->approver1?->name }}</span> menyetujui (Level 1)
                            @if($booking->approval_note_l1)
                            <div style="color: var(--gray-500); font-size: 12px; margin-top: 2px;">"{{ $booking->approval_note_l1 }}"</div>
                            @endif
                        </div>
                        @elseif($booking->status === 'pending')
                        <div class="timeline-time">Menunggu</div>
                        <div class="timeline-content">
                            Menunggu persetujuan <span class="timeline-actor">{{ $booking->approver1?->name }}</span>
                            <span class="badge badge-warning">Level 1</span>
                        </div>
                        @elseif($booking->status === 'rejected' && !$booking->approved_at_l1)
                        <div class="timeline-time">{{ $booking->rejected_at?->isoFormat('D MMM Y, HH:mm') }}</div>
                        <div class="timeline-content">
                            <span class="timeline-actor">{{ $booking->rejectedBy?->name }}</span> menolak pemesanan
                            @if($booking->rejection_note)
                            <div style="color: #ef4444; font-size: 12px;">"{{ $booking->rejection_note }}"</div>
                            @endif
                        </div>
                        @else
                        <div class="timeline-time">Belum diproses</div>
                        <div class="timeline-content">Persetujuan Level 1 belum dilakukan</div>
                        @endif
                    </div>

                    <!-- Step 3: L2 Approval -->
                    <div class="timeline-item {{ $booking->status === 'approved_l1' ? 'pending' : ($booking->status === 'rejected' && $booking->approved_at_l1 ? 'rejected' : '') }}">
                        @if($booking->approved_at_l2)
                        <div class="timeline-time">{{ $booking->approved_at_l2->isoFormat('D MMM Y, HH:mm') }}</div>
                        <div class="timeline-content">
                            <span class="timeline-actor">{{ $booking->approver2?->name }}</span> menyetujui (Level 2)
                            @if($booking->approval_note_l2)
                            <div style="color: var(--gray-500); font-size: 12px; margin-top: 2px;">"{{ $booking->approval_note_l2 }}"</div>
                            @endif
                        </div>
                        @elseif($booking->status === 'approved_l1')
                        <div class="timeline-time">Menunggu</div>
                        <div class="timeline-content">
                            Menunggu persetujuan <span class="timeline-actor">{{ $booking->approver2?->name }}</span>
                            <span class="badge badge-info">Level 2</span>
                        </div>
                        @elseif($booking->status === 'rejected' && $booking->approved_at_l1)
                        <div class="timeline-time">{{ $booking->rejected_at?->isoFormat('D MMM Y, HH:mm') }}</div>
                        <div class="timeline-content">
                            <span class="timeline-actor">{{ $booking->rejectedBy?->name }}</span> menolak pemesanan
                            @if($booking->rejection_note)
                            <div style="color: #ef4444; font-size: 12px;">"{{ $booking->rejection_note }}"</div>
                            @endif
                        </div>
                        @else
                        <div class="timeline-time">Menunggu L1</div>
                        <div class="timeline-content">Persetujuan Level 2 menunggu persetujuan Level 1</div>
                        @endif
                    </div>

                    @if($booking->status === 'completed')
                    <div class="timeline-item">
                        <div class="timeline-time">{{ $booking->actual_return?->isoFormat('D MMM Y, HH:mm') ?? $booking->updated_at->isoFormat('D MMM Y, HH:mm') }}</div>
                        <div class="timeline-content">
                            Perjalanan selesai. Kendaraan dikembalikan. <span class="badge badge-completed">Selesai</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($booking->status === 'completed' && ($booking->start_km || $booking->fuel_used))
        <!-- Usage Report -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-tachometer-alt"></i> Laporan Pemakaian</div>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    @if($booking->start_km)
                    <div class="detail-item">
                        <label>KM Awal</label>
                        <div class="value">{{ number_format($booking->start_km) }} km</div>
                    </div>
                    <div class="detail-item">
                        <label>KM Akhir</label>
                        <div class="value">{{ number_format($booking->end_km) }} km</div>
                    </div>
                    <div class="detail-item">
                        <label>Jarak Tempuh</label>
                        <div class="value" style="color: var(--green-700);">{{ number_format($booking->getDistanceKm()) }} km</div>
                    </div>
                    @endif
                    @if($booking->fuel_used)
                    <div class="detail-item">
                        <label>BBM Terpakai</label>
                        <div class="value">{{ $booking->fuel_used }} Liter</div>
                    </div>
                    @endif
                    @if($booking->usage_notes)
                    <div class="detail-item" style="grid-column: span 2;">
                        <label>Catatan Pemakaian</label>
                        <div class="value">{{ $booking->usage_notes }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Vehicle & Driver -->
        <div class="card" style="margin-bottom: 16px;">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-car"></i> Kendaraan</div>
            </div>
            <div class="card-body">
                @if($booking->vehicle)
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div style="width: 44px; height: 44px; background: var(--green-50); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--green-600);">
                        <i class="fas fa-{{ $booking->vehicle->type === 'cargo' ? 'truck' : 'car' }}"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 15px;">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</div>
                        <div style="font-size: 12px; color: var(--gray-500);">{{ $booking->vehicle->year }}</div>
                    </div>
                </div>
                <div style="font-size: 13px; display: flex; flex-direction: column; gap: 6px;">
                    <div><span class="badge badge-secondary" style="font-size: 13px; padding: 4px 12px;">{{ $booking->vehicle->plate_number }}</span></div>
                    <div><i class="fas fa-tag" style="color: var(--gray-400); width: 16px;"></i> {{ $booking->vehicle->getTypeLabel() }}</div>
                    <div><i class="fas fa-map-marker-alt" style="color: var(--gray-400); width: 16px;"></i> {{ $booking->vehicle->location }}</div>
                </div>
                @else
                <div style="color: var(--gray-400); font-size: 13px;">Data kendaraan tidak ditemukan</div>
                @endif
            </div>
        </div>

        <div class="card" style="margin-bottom: 16px;">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-id-card"></i> Driver</div>
            </div>
            <div class="card-body">
                @if($booking->driver)
                <div style="font-size: 13px; display: flex; flex-direction: column; gap: 6px;">
                    <div style="font-weight: 700; font-size: 15px;">{{ $booking->driver->name }}</div>
                    <div><i class="fas fa-id-card" style="color: var(--gray-400); width: 16px;"></i> SIM {{ $booking->driver->license_type }}</div>
                    <div><i class="fas fa-phone" style="color: var(--gray-400); width: 16px;"></i> {{ $booking->driver->phone ?? '-' }}</div>
                </div>
                @else
                <div style="color: var(--gray-400); font-size: 13px;"><i class="fas fa-user-slash"></i> Tanpa Driver</div>
                @endif
            </div>
        </div>

        <!-- Action Buttons for Approvers -->
        @php $user = auth()->user(); @endphp

        @if($booking->status === 'pending' && $booking->approver1_id === $user->id)
        <div class="card" style="border: 2px solid var(--green-200); margin-bottom: 16px;">
            <div class="card-header" style="background: var(--green-50);">
                <div class="card-title"><i class="fas fa-gavel"></i> Tindakan Anda (Level 1)</div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('bookings.approve-l1', $booking) }}" style="margin-bottom: 12px;">
                    @csrf
                    <div class="form-group">
                        <label>Catatan Persetujuan</label>
                        <textarea name="approval_note_l1" class="form-control" rows="2" placeholder="Catatan opsional..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%;" onclick="return confirm('Setujui pemesanan ini?')">
                        <i class="fas fa-check"></i> Setujui (Level 1)
                    </button>
                </form>
                <button type="button" class="btn btn-danger" style="width: 100%;" onclick="document.getElementById('rejectModal').classList.add('show')">
                    <i class="fas fa-times"></i> Tolak
                </button>
            </div>
        </div>
        @endif

        @if($booking->status === 'approved_l1' && $booking->approver2_id === $user->id)
        <div class="card" style="border: 2px solid #bfdbfe; margin-bottom: 16px;">
            <div class="card-header" style="background: #eff6ff;">
                <div class="card-title"><i class="fas fa-gavel"></i> Tindakan Anda (Level 2)</div>
            </div>
            <div class="card-body">
                <div class="alert alert-info" style="margin-bottom: 12px; font-size: 12px;">
                    <i class="fas fa-info-circle"></i> Sudah disetujui Level 1 oleh {{ $booking->approver1?->name }}
                </div>
                <form method="POST" action="{{ route('bookings.approve-l2', $booking) }}" style="margin-bottom: 12px;">
                    @csrf
                    <div class="form-group">
                        <label>Catatan Persetujuan</label>
                        <textarea name="approval_note_l2" class="form-control" rows="2" placeholder="Catatan opsional..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%;" onclick="return confirm('Setujui pemesanan ini?')">
                        <i class="fas fa-check-double"></i> Setujui Final (Level 2)
                    </button>
                </form>
                <button type="button" class="btn btn-danger" style="width: 100%;" onclick="document.getElementById('rejectModal').classList.add('show')">
                    <i class="fas fa-times"></i> Tolak
                </button>
            </div>
        </div>
        @endif

        @if($booking->status === 'approved_l2' && $user->isAdmin())
        <div class="card" style="border: 2px solid var(--green-200); margin-bottom: 16px;">
            <div class="card-header" style="background: var(--green-50);">
                <div class="card-title"><i class="fas fa-flag-checkered"></i> Selesaikan Perjalanan</div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('bookings.complete', $booking) }}">
                    @csrf
                    <div class="form-group">
                        <label>KM Awal <span class="required">*</span></label>
                        <input type="number" name="start_km" class="form-control" required min="0">
                    </div>
                    <div class="form-group">
                        <label>KM Akhir <span class="required">*</span></label>
                        <input type="number" name="end_km" class="form-control" required min="0">
                    </div>
                    <div class="form-group">
                        <label>BBM Terpakai (Liter)</label>
                        <input type="number" name="fuel_used" class="form-control" step="0.01" min="0">
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="usage_notes" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;" onclick="return confirm('Tandai perjalanan sebagai selesai?')">
                        <i class="fas fa-flag-checkered"></i> Selesaikan Perjalanan
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div class="modal-overlay" id="rejectModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title"><i class="fas fa-times-circle" style="color: #ef4444;"></i> Tolak Pemesanan</span>
            <button class="modal-close" onclick="document.getElementById('rejectModal').classList.remove('show')">&times;</button>
        </div>
        <form method="POST" action="{{ route('bookings.reject', $booking) }}">
            @csrf
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Penolakan tidak dapat dibatalkan. Pemohon akan diberitahu.</span>
                </div>
                <div class="form-group">
                    <label>Alasan Penolakan <span class="required">*</span></label>
                    <textarea name="rejection_note" class="form-control" rows="4" required
                        placeholder="Jelaskan alasan penolakan pemesanan ini..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('rejectModal').classList.remove('show')">Batal</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Tolak Pemesanan</button>
            </div>
        </form>
    </div>
</div>
@endsection
