<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('plate_number', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('model', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->ownership) {
            $query->where('ownership', $request->ownership);
        }

        if ($request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $vehicles = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plate_number' => 'required|string|unique:vehicles',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'type' => 'required|in:passenger,cargo',
            'ownership' => 'required|in:own,rental',
            'rental_company' => 'nullable|required_if:ownership,rental|string|max:200',
            'location' => 'required|string|max:200',
            'fuel_capacity' => 'required|integer|min:1',
            'fuel_consumption' => 'required|numeric|min:0.1',
            'last_service_date' => 'nullable|date',
            'last_service_km' => 'nullable|integer|min:0',
            'next_service_km' => 'nullable|integer|min:0',
            'status' => 'required|in:available,in_use,maintenance,retired',
            'color' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $vehicle = Vehicle::create($data);

        ActivityLog::log('CREATE', "Kendaraan baru ditambahkan: {$vehicle->plate_number} ({$vehicle->brand} {$vehicle->model})", $vehicle, [], $data);

        return redirect()->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['bookings.user', 'bookings.driver', 'fuelRecords', 'serviceRecords']);
        $recentBookings = $vehicle->bookings()->with(['user', 'driver'])->orderBy('created_at', 'desc')->take(10)->get();
        $fuelRecords = $vehicle->fuelRecords()->orderBy('refuel_date', 'desc')->take(10)->get();
        $serviceRecords = $vehicle->serviceRecords()->orderBy('service_date', 'desc')->take(10)->get();
        return view('vehicles.show', compact('vehicle', 'recentBookings', 'fuelRecords', 'serviceRecords'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'plate_number' => 'required|string|unique:vehicles,plate_number,' . $vehicle->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'type' => 'required|in:passenger,cargo',
            'ownership' => 'required|in:own,rental',
            'rental_company' => 'nullable|string|max:200',
            'location' => 'required|string|max:200',
            'fuel_capacity' => 'required|integer|min:1',
            'fuel_consumption' => 'required|numeric|min:0.1',
            'last_service_date' => 'nullable|date',
            'last_service_km' => 'nullable|integer|min:0',
            'next_service_km' => 'nullable|integer|min:0',
            'status' => 'required|in:available,in_use,maintenance,retired',
            'color' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $oldValues = $vehicle->toArray();
        $vehicle->update($data);

        ActivityLog::log('UPDATE', "Kendaraan diperbarui: {$vehicle->plate_number}", $vehicle, $oldValues, $data);

        return redirect()->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->bookings()->whereIn('status', ['pending', 'approved_l1', 'approved_l2', 'in_use'])->exists()) {
            return back()->with('error', 'Kendaraan tidak dapat dihapus karena masih ada pemesanan aktif.');
        }

        ActivityLog::log('DELETE', "Kendaraan dihapus: {$vehicle->plate_number}", $vehicle, $vehicle->toArray());
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}
