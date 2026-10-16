<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,approver',
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'approval_level' => 'required_if:role,approver|integer|min:1|max:2',
            'phone' => 'nullable|string|max:20',
        ]);

        $data['is_active'] = true;

        $user = User::create($data);

        ActivityLog::log('CREATE', "User baru ditambahkan: {$user->name} ({$user->role})", $user);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,approver',
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'approval_level' => 'required_if:role,approver|integer|min:1|max:2',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $oldValues = $user->toArray();
        $user->update($data);

        ActivityLog::log('UPDATE', "User diperbarui: {$user->name}", $user, $oldValues, $data);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        ActivityLog::log('DELETE', "User dihapus: {$user->name}", $user, $user->toArray());
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
