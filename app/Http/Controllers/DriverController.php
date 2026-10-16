<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = Driver::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('license_number', 'like', '%' . $request->search . '%')
                  ->orWhere('employee_id', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $drivers = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('drivers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'license_number' => 'required|string|unique:drivers',
            'license_type' => 'required|in:A,B1,B2,C',
            'license_expiry' => 'required|date',
            'phone' => 'nullable|string|max:20',
            'employee_id' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:200',
            'status' => 'required|in:available,on_duty,off,inactive',
        ]);

        $driver = Driver::create($data);

        ActivityLog::log('CREATE', "Driver baru ditambahkan: {$driver->name}", $driver, [], $data);

        return redirect()->route('drivers.index')
            ->with('success', 'Driver berhasil ditambahkan.');
    }

    public function show(Driver $driver)
    {
        $driver->load('bookings.vehicle');
        $recentBookings = $driver->bookings()->with('vehicle')->orderBy('created_at', 'desc')->take(10)->get();
        return view('drivers.show', compact('driver', 'recentBookings'));
    }

    public function edit(Driver $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'license_number' => 'required|string|unique:drivers,license_number,' . $driver->id,
            'license_type' => 'required|in:A,B1,B2,C',
            'license_expiry' => 'required|date',
            'phone' => 'nullable|string|max:20',
            'employee_id' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:200',
            'status' => 'required|in:available,on_duty,off,inactive',
            'is_active' => 'boolean',
        ]);

        $oldValues = $driver->toArray();
        $driver->update($data);

        ActivityLog::log('UPDATE', "Data driver diperbarui: {$driver->name}", $driver, $oldValues, $data);

        return redirect()->route('drivers.index')
            ->with('success', 'Driver berhasil diperbarui.');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->bookings()->whereIn('status', ['pending', 'approved_l1', 'approved_l2', 'in_use'])->exists()) {
            return back()->with('error', 'Driver tidak dapat dihapus karena masih ada pemesanan aktif.');
        }

        ActivityLog::log('DELETE', "Driver dihapus: {$driver->name}", $driver, $driver->toArray());
        $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', 'Driver berhasil dihapus.');
    }
}
