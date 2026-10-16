@extends('layouts.app')
@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas Sistem')
@section('page-subtitle', 'Jejak audit seluruh aktivitas operasional, login, perubahan data pemesanan, dan armada.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <span class="separator">Administrasi</span>
    <span class="separator">></span>
    <span class="current">Log Aktivitas</span>
@endsection

@section('content')
<!-- FILTER CARD -->
<div class="filter-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; padding: 20px 24px; margin-bottom: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <div style="font-size: 14.5px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
        <i class="fas fa-filter" style="color: #10b981;"></i>
        <span>Filter Log Aktivitas</span>
    </div>

    <form method="GET" action="{{ route('logs.index') }}">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="position: relative; flex: 1; min-width: 220px;">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px;"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari aksi, deskripsi, atau nama pengguna..." 
                    style="width: 100%; height: 42px; padding: 0 14px 0 40px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13.5px; outline: none;"
                >
            </div>

            <select name="action" style="height: 42px; padding: 0 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #334155; outline: none;">
                <option value="">Semua Tipe Aksi</option>
                @foreach($actions as $act)
                <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ $act }}</option>
                @endforeach
            </select>

            <input 
                type="date" 
                name="date_from" 
                value="{{ request('date_from') }}" 
                style="height: 42px; padding: 0 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #334155; outline: none;"
                title="Dari Tanggal"
            >
            <span style="color: #94a3b8; font-size: 13px;">-</span>
            <input 
                type="date" 
                name="date_to" 
                value="{{ request('date_to') }}" 
                style="height: 42px; padding: 0 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #334155; outline: none;"
                title="Sampai Tanggal"
            >

            <a href="{{ route('logs.index') }}" style="height: 42px; padding: 0 16px; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; color: #475569; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                <i class="fas fa-rotate-left"></i> Reset
            </a>

            <button type="submit" style="height: 42px; padding: 0 18px; background: var(--btn-green); border: none; border-radius: 10px; color: #ffffff; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- LOGS TABLE CARD -->
<div class="table-container-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">Jejak Audit Aktivitas</div>
        <div style="font-size: 12.5px; color: #64748b;">Total: <strong>{{ $logs->total() }}</strong> catatan log</div>
    </div>

    <div class="table-wrapper">
        <table class="table-clean" style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1.5px solid #f1f5f9; text-align: left;">
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; width: 18%;">Waktu & Tanggal</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; width: 18%;">Pengguna</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; width: 14%;">Aksi</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; width: 35%;">Deskripsi Aktivitas</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; width: 15%;">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <!-- Waktu -->
                    <td style="padding: 14px 18px;">
                        <div style="font-weight: 700; color: #0f172a;">{{ $log->created_at->isoFormat('D MMMM Y') }}</div>
                        <div style="font-size: 11.5px; color: #64748b;">{{ $log->created_at->format('H:i:s') }} WIB</div>
                    </td>

                    <!-- Pengguna -->
                    <td style="padding: 14px 18px;">
                        @if($log->user)
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #ecfdf5; color: #059669; font-weight: 800; font-size: 11px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                {{ strtoupper(substr($log->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #0f172a; font-size: 13px;">{{ $log->user->name }}</div>
                                <div style="font-size: 11px; color: #64748b;">{{ ucfirst($log->user->role) }}</div>
                            </div>
                        </div>
                        @else
                        <span style="color: #94a3b8; font-style: italic;">Sistem Otomatis</span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td style="padding: 14px 18px;">
                        @php
                            $actionColors = [
                                'LOGIN' => 'status-completed',
                                'LOGOUT' => 'status-pending',
                                'CREATE' => 'status-approved',
                                'UPDATE' => 'status-approved',
                                'APPROVE' => 'status-completed',
                                'REJECT' => 'status-rejected',
                                'DELETE' => 'status-rejected',
                            ];
                            $actClass = $actionColors[$log->action] ?? 'status-pending';
                        @endphp
                        <span class="badge-pill-status {{ $actClass }}">
                            {{ $log->action }}
                        </span>
                    </td>

                    <!-- Deskripsi -->
                    <td style="padding: 14px 18px;">
                        <div style="color: #334155; line-height: 1.4; font-weight: 500;">
                            {{ $log->description }}
                        </div>
                    </td>

                    <!-- IP Address -->
                    <td style="padding: 14px 18px;">
                        <span style="font-family: monospace; font-size: 12px; color: #64748b; background: #f8fafc; border: 1px solid #e2e8f0; padding: 2px 6px; border-radius: 4px;">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 48px; color: #94a3b8;">
                        <i class="fas fa-clock-rotate-left" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                        <div style="font-weight: 700; color: #334155;">Tidak ada log aktivitas ditemukan</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
    <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end;">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
