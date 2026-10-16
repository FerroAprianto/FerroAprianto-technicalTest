@extends('layouts.app')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola akun pengguna, hak akses peran (Admin / Approver), dan departemen.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <span class="separator">Administrasi</span>
    <span class="separator">></span>
    <span class="current">User</span>
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
    <a href="{{ route('users.create') }}" class="btn-add-primary">
        <i class="fas fa-user-plus"></i>
        <span>Tambah Pengguna</span>
    </a>
</div>

<!-- FILTER CARD -->
<div class="filter-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; padding: 20px 24px; margin-bottom: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <div style="font-size: 14.5px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
        <i class="fas fa-filter" style="color: #10b981;"></i>
        <span>Filter Pengguna</span>
    </div>

    <form method="GET" action="{{ route('users.index') }}">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="position: relative; flex: 1; min-width: 220px;">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px;"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama atau email pengguna..." 
                    style="width: 100%; height: 42px; padding: 0 14px 0 40px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13.5px; outline: none;"
                >
            </div>

            <select name="role" style="height: 42px; padding: 0 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #334155; outline: none;">
                <option value="">Semua Peran (Role)</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="approver" {{ request('role') == 'approver' ? 'selected' : '' }}>Approver</option>
            </select>

            <a href="{{ route('users.index') }}" style="height: 42px; padding: 0 16px; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; color: #475569; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                <i class="fas fa-rotate-left"></i> Reset
            </a>

            <button type="submit" style="height: 42px; padding: 0 18px; background: var(--btn-green); border: none; border-radius: 10px; color: #ffffff; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- USERS TABLE CARD -->
<div class="table-container-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">Daftar Akun Pengguna</div>
        <div style="font-size: 12.5px; color: #64748b;">Total: <strong>{{ $users->total() }}</strong> pengguna terdaftar</div>
    </div>

    <div class="table-wrapper">
        <table class="table-clean" style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1.5px solid #f1f5f9; text-align: left;">
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Pengguna</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Email</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Peran / Hak Akses</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Departemen / Jabatan</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase;">Status Akun</th>
                    <th style="padding: 14px 18px; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <!-- User Info -->
                    <td style="padding: 14px 18px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; background: {{ $user->role === 'admin' ? '#ecfdf5' : '#eff6ff' }}; border: 1.5px solid {{ $user->role === 'admin' ? '#a7f3d0' : '#bfdbfe' }}; display: flex; align-items: center; justify-content: center; font-weight: 800; color: {{ $user->role === 'admin' ? '#059669' : '#2563eb' }}; font-size: 14px; flex-shrink: 0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #0f172a;">{{ $user->name }}</div>
                                <div style="font-size: 11.5px; color: #64748b;">{{ $user->phone ?? 'Tidak ada kontak' }}</div>
                            </div>
                        </div>
                    </td>

                    <!-- Email -->
                    <td style="padding: 14px 18px;">
                        <span style="font-family: monospace; font-size: 12.5px; color: #334155;">{{ $user->email }}</span>
                    </td>

                    <!-- Peran / Role -->
                    <td style="padding: 14px 18px;">
                        @if($user->role === 'admin')
                        <span class="badge-pill-status status-completed">
                            <i class="fas fa-shield-halved" style="font-size: 10px; margin-right: 4px;"></i> Admin Sistem
                        </span>
                        @else
                        <span class="badge-pill-status status-approved">
                            <i class="fas fa-check-double" style="font-size: 10px; margin-right: 4px;"></i> Approver Tk. {{ $user->approval_level ?? 1 }}
                        </span>
                        @endif
                    </td>

                    <!-- Departemen -->
                    <td style="padding: 14px 18px;">
                        <div style="font-weight: 600; color: #1e293b;">{{ $user->department ?? '-' }}</div>
                        <div style="font-size: 11.5px; color: #64748b;">{{ $user->position ?? '-' }}</div>
                    </td>

                    <!-- Status Akun -->
                    <td style="padding: 14px 18px;">
                        @if($user->is_active)
                        <span class="badge-pill-status status-completed">Aktif</span>
                        @else
                        <span class="badge-pill-status status-cancelled">Nonaktif</span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td style="padding: 14px 18px; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <a href="{{ route('users.edit', $user) }}" class="btn-action-square" title="Edit Pengguna">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-square" style="color: #ef4444; border-color: #fee2e2; background: #fff5f5;" title="Hapus">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 48px; color: #94a3b8;">
                        <i class="fas fa-users" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                        <div style="font-weight: 700; color: #334155;">Tidak ada data pengguna ditemukan</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end;">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
