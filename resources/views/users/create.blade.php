@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')
@section('page-subtitle', 'Buat akun pengguna baru dengan hak akses peran Administrator atau Approver.')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span class="separator">></span>
    <a href="{{ route('users.index') }}">User</a>
    <span class="separator">></span>
    <span class="current">Tambah</span>
@endsection

@section('content')
<div class="content-card" style="max-width: 720px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 20px 28px; border-bottom: 1px solid #f1f5f9; font-size: 15px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-user-plus" style="color: #10b981;"></i> Formulir Pengguna Baru
    </div>

    <form method="POST" action="{{ route('users.store') }}" style="padding: 28px;">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label class="form-label">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Nama lengkap" value="{{ old('name') }}" required>
                @error('name')<div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="form-label">Email <span style="color: #ef4444;">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="user@sekawan.com" value="{{ old('email') }}" required>
                @error('email')<div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label class="form-label">Password <span style="color: #ef4444;">*</span></label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                @error('password')<div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="form-label">Konfirmasi Password <span style="color: #ef4444;">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label class="form-label">Peran (Role) <span style="color: #ef4444;">*</span></label>
                <select name="role" id="roleSelect" class="form-select" onchange="toggleApprovalLevel(this.value)" required>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="approver" {{ old('role') == 'approver' ? 'selected' : '' }}>Approver (Pihak Penyetuju)</option>
                </select>
            </div>

            <div id="approvalLevelWrap" style="{{ old('role') == 'approver' ? '' : 'display: none;' }}">
                <label class="form-label">Tingkat Persetujuan (Approval Level)</label>
                <select name="approval_level" class="form-select">
                    <option value="1" {{ old('approval_level') == 1 ? 'selected' : '' }}>Tingkat 1 (Atasan Langsung / Kepala)</option>
                    <option value="2" {{ old('approval_level') == 2 ? 'selected' : '' }}>Tingkat 2 (Manajemen / Direktur)</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label class="form-label">Departemen</label>
                <input type="text" name="department" class="form-control" placeholder="Contoh: Operasional Tambang" value="{{ old('department') }}">
            </div>

            <div>
                <label class="form-label">Jabatan / Posisi</label>
                <input type="text" name="position" class="form-control" placeholder="Contoh: Kepala Seksi" value="{{ old('position') }}">
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label class="form-label">Nomor Telepon / WhatsApp</label>
            <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Pengguna
            </button>
        </div>
    </form>
</div>

<script>
    function toggleApprovalLevel(role) {
        const wrap = document.getElementById('approvalLevelWrap');
        if (role === 'approver') {
            wrap.style.display = 'block';
        } else {
            wrap.style.display = 'none';
        }
    }
</script>
@endsection
