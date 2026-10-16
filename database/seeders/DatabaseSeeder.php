<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Booking;
use App\Models\FuelRecord;
use App\Models\ServiceRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== USERS ====================
        $admin = User::create([
            'name' => 'Administrator Sistem',
            'email' => 'admin@sekawan.com',
            'password' => 'admin123',
            'role' => 'admin',
            'department' => 'IT & Operasional',
            'position' => 'System Administrator',
            'approval_level' => 0,
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $admin2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@sekawan.com',
            'password' => 'budi123',
            'role' => 'admin',
            'department' => 'Pool Kendaraan',
            'position' => 'Staff Pool',
            'approval_level' => 0,
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        $approver1 = User::create([
            'name' => 'Ir. Hendra Wijaya',
            'email' => 'hendra@sekawan.com',
            'password' => 'hendra123',
            'role' => 'approver',
            'department' => 'Operasional Tambang',
            'position' => 'Kepala Seksi Operasional',
            'approval_level' => 1,
            'phone' => '081234567892',
            'is_active' => true,
        ]);

        $approver2 = User::create([
            'name' => 'Dr. Siti Rahayu',
            'email' => 'siti@sekawan.com',
            'password' => 'siti123',
            'role' => 'approver',
            'department' => 'Manajemen',
            'position' => 'Manajer Operasional',
            'approval_level' => 2,
            'phone' => '081234567893',
            'is_active' => true,
        ]);

        $approver3 = User::create([
            'name' => 'Drs. Bambang Sutrisno',
            'email' => 'bambang@sekawan.com',
            'password' => 'bambang123',
            'role' => 'approver',
            'department' => 'HRD',
            'position' => 'Kepala HRD',
            'approval_level' => 1,
            'phone' => '081234567894',
            'is_active' => true,
        ]);

        $approver4 = User::create([
            'name' => 'Dra. Dewi Permata',
            'email' => 'dewi@sekawan.com',
            'password' => 'dewi123',
            'role' => 'approver',
            'department' => 'Direktur',
            'position' => 'Direktur Operasional',
            'approval_level' => 2,
            'phone' => '081234567895',
            'is_active' => true,
        ]);

        // ==================== VEHICLES ====================
        $vehicles = [
            ['plate_number' => 'KB 1234 AB', 'brand' => 'Toyota', 'model' => 'Hilux', 'year' => 2022, 'type' => 'cargo', 'ownership' => 'own', 'location' => 'Tambang Morowali 1', 'fuel_capacity' => 80, 'fuel_consumption' => 12, 'status' => 'available', 'color' => 'Putih'],
            ['plate_number' => 'KB 5678 CD', 'brand' => 'Toyota', 'model' => 'Fortuner', 'year' => 2023, 'type' => 'passenger', 'ownership' => 'own', 'location' => 'Kantor Pusat - Jakarta', 'fuel_capacity' => 65, 'fuel_consumption' => 10, 'status' => 'available', 'color' => 'Hitam'],
            ['plate_number' => 'KB 9012 EF', 'brand' => 'Mitsubishi', 'model' => 'Pajero Sport', 'year' => 2021, 'type' => 'passenger', 'ownership' => 'own', 'location' => 'Tambang Kendari', 'fuel_capacity' => 68, 'fuel_consumption' => 9.5, 'status' => 'in_use', 'color' => 'Silver'],
            ['plate_number' => 'KB 3456 GH', 'brand' => 'Isuzu', 'model' => 'Elf', 'year' => 2020, 'type' => 'cargo', 'ownership' => 'own', 'location' => 'Tambang Morowali 2', 'fuel_capacity' => 100, 'fuel_consumption' => 8, 'status' => 'available', 'color' => 'Putih'],
            ['plate_number' => 'KB 7890 IJ', 'brand' => 'Toyota', 'model' => 'Land Cruiser', 'year' => 2022, 'type' => 'passenger', 'ownership' => 'own', 'location' => 'Tambang Konawe', 'fuel_capacity' => 87, 'fuel_consumption' => 11, 'status' => 'maintenance', 'color' => 'Hitam'],
            ['plate_number' => 'KB 2468 KL', 'brand' => 'Hino', 'model' => 'Dutro', 'year' => 2019, 'type' => 'cargo', 'ownership' => 'rental', 'rental_company' => 'PT Sewa Kendaraan Sulawesi', 'location' => 'Tambang Pomalaa', 'fuel_capacity' => 130, 'fuel_consumption' => 6, 'status' => 'available', 'color' => 'Merah'],
            ['plate_number' => 'KB 1357 MN', 'brand' => 'Daihatsu', 'model' => 'Gran Max', 'year' => 2021, 'type' => 'cargo', 'ownership' => 'own', 'location' => 'Kantor Cabang - Makassar', 'fuel_capacity' => 55, 'fuel_consumption' => 13, 'status' => 'available', 'color' => 'Putih'],
            ['plate_number' => 'KB 2468 OP', 'brand' => 'Toyota', 'model' => 'Innova', 'year' => 2023, 'type' => 'passenger', 'ownership' => 'rental', 'rental_company' => 'CV Transportasi Prima', 'location' => 'Kantor Pusat - Jakarta', 'fuel_capacity' => 65, 'fuel_consumption' => 12, 'status' => 'available', 'color' => 'Silver'],
            ['plate_number' => 'KB 3579 QR', 'brand' => 'Nissan', 'model' => 'Navara', 'year' => 2022, 'type' => 'cargo', 'ownership' => 'own', 'location' => 'Tambang Morowali 1', 'fuel_capacity' => 80, 'fuel_consumption' => 11, 'status' => 'available', 'color' => 'Abu-abu'],
            ['plate_number' => 'KB 4680 ST', 'brand' => 'Mitsubishi', 'model' => 'Strada', 'year' => 2020, 'type' => 'cargo', 'ownership' => 'own', 'location' => 'Tambang Konawe', 'fuel_capacity' => 75, 'fuel_consumption' => 10, 'status' => 'available', 'color' => 'Putih'],
        ];

        $vehicleModels = [];
        foreach ($vehicles as $v) {
            $v['last_service_date'] = Carbon::now()->subMonths(rand(1, 6));
            $v['last_service_km'] = rand(50000, 80000);
            $v['next_service_km'] = $v['last_service_km'] + 10000;
            $vehicleModels[] = Vehicle::create($v);
        }

        // ==================== DRIVERS ====================
        $drivers = [
            ['name' => 'Agus Setiawan', 'license_number' => 'SIM-001-2024', 'license_type' => 'B1', 'license_expiry' => '2026-12-31', 'phone' => '082111111101', 'employee_id' => 'EMP-001', 'location' => 'Tambang Morowali 1', 'status' => 'available'],
            ['name' => 'Rudi Hartono', 'license_number' => 'SIM-002-2024', 'license_type' => 'B1', 'license_expiry' => '2025-08-15', 'phone' => '082111111102', 'employee_id' => 'EMP-002', 'location' => 'Kantor Pusat - Jakarta', 'status' => 'on_duty'],
            ['name' => 'Slamet Riyadi', 'license_number' => 'SIM-003-2024', 'license_type' => 'B2', 'license_expiry' => '2027-03-20', 'phone' => '082111111103', 'employee_id' => 'EMP-003', 'location' => 'Tambang Morowali 2', 'status' => 'available'],
            ['name' => 'Wahyu Nugroho', 'license_number' => 'SIM-004-2024', 'license_type' => 'B1', 'license_expiry' => '2026-06-10', 'phone' => '082111111104', 'employee_id' => 'EMP-004', 'location' => 'Tambang Kendari', 'status' => 'available'],
            ['name' => 'Eko Prasetyo', 'license_number' => 'SIM-005-2024', 'license_type' => 'B1', 'license_expiry' => '2025-11-28', 'phone' => '082111111105', 'employee_id' => 'EMP-005', 'location' => 'Tambang Konawe', 'status' => 'available'],
            ['name' => 'Heri Susanto', 'license_number' => 'SIM-006-2024', 'license_type' => 'B2', 'license_expiry' => '2026-09-05', 'phone' => '082111111106', 'employee_id' => 'EMP-006', 'location' => 'Tambang Pomalaa', 'status' => 'available'],
            ['name' => 'Joko Widodo', 'license_number' => 'SIM-007-2024', 'license_type' => 'B1', 'license_expiry' => '2027-02-14', 'phone' => '082111111107', 'employee_id' => 'EMP-007', 'location' => 'Kantor Cabang - Makassar', 'status' => 'available'],
            ['name' => 'Darmawan Putra', 'license_number' => 'SIM-008-2024', 'license_type' => 'B1', 'license_expiry' => '2026-07-22', 'phone' => '082111111108', 'employee_id' => 'EMP-008', 'location' => 'Tambang Morowali 1', 'status' => 'off'],
        ];

        $driverModels = [];
        foreach ($drivers as $d) {
            $driverModels[] = Driver::create($d);
        }

        // ==================== BOOKINGS (historical) ====================
        $statuses = ['completed', 'completed', 'completed', 'rejected', 'cancelled', 'approved_l2'];
        $destinations = [
            'Tambang Morowali 1', 'Kantor Pusat Jakarta', 'Bandara Soekarno-Hatta', 
            'Pelabuhan Kendari', 'Site Tambang Konawe', 'Kantor Cabang Makassar',
            'Tambang Pomalaa', 'Hotel Grand Makassar', 'Rumah Sakit Daerah'
        ];
        $purposes = [
            'Inspeksi lapangan', 'Rapat direksi', 'Pengiriman material', 
            'Kunjungan site', 'Pengambilan dokumen', 'Antar jemput tamu',
            'Survey lokasi', 'Pengiriman alat', 'Perjalanan dinas'
        ];

        for ($i = 0; $i < 30; $i++) {
            $departure = Carbon::now()->subDays(rand(1, 180));
            $return = (clone $departure)->addHours(rand(4, 48));
            $vehicleIdx = $i % count($vehicleModels);
            $status = $statuses[$i % count($statuses)];

            $booking = [
                'user_id' => $admin->id,
                'vehicle_id' => $vehicleModels[$vehicleIdx]->id,
                'driver_id' => $driverModels[$i % count($driverModels)]->id,
                'purpose' => $purposes[$i % count($purposes)],
                'description' => 'Keperluan operasional perusahaan',
                'destination' => $destinations[$i % count($destinations)],
                'departure_datetime' => $departure,
                'return_datetime' => $return,
                'passenger_count' => rand(1, 5),
                'status' => $status,
                'approver1_id' => $approver1->id,
                'approver2_id' => $approver2->id,
            ];

            if (in_array($status, ['completed', 'approved_l2', 'rejected'])) {
                $booking['approved_at_l1'] = (clone $departure)->subDays(rand(1, 3));
                $booking['approval_note_l1'] = 'Disetujui untuk keperluan operasional';
            }

            if ($status === 'completed' || $status === 'approved_l2') {
                $booking['approved_at_l2'] = (clone $departure)->subDays(rand(0, 1));
                $booking['approval_note_l2'] = 'Disetujui. Pastikan keselamatan berkendara.';
            }

            if ($status === 'rejected') {
                $booking['rejection_note'] = 'Kendaraan sedang dalam perbaikan, gunakan kendaraan alternatif';
                $booking['rejected_at'] = (clone $departure)->subDays(1);
                $booking['rejected_by'] = $approver2->id;
            }

            if ($status === 'completed') {
                $startKm = rand(50000, 100000);
                $distance = rand(50, 500);
                $booking['start_km'] = $startKm;
                $booking['end_km'] = $startKm + $distance;
                $booking['fuel_used'] = round($distance / rand(8, 14), 2);
                $booking['actual_departure'] = $departure;
                $booking['actual_return'] = $return;
            }

            Booking::create($booking);
        }

        // Pending bookings
        Booking::create([
            'user_id' => $admin->id,
            'vehicle_id' => $vehicleModels[0]->id,
            'driver_id' => $driverModels[0]->id,
            'purpose' => 'Inspeksi tambang Morowali',
            'description' => 'Inspeksi rutin kondisi tambang dan peralatan',
            'destination' => 'Tambang Morowali 1',
            'departure_datetime' => Carbon::now()->addDays(2),
            'return_datetime' => Carbon::now()->addDays(3),
            'passenger_count' => 3,
            'status' => 'pending',
            'approver1_id' => $approver1->id,
            'approver2_id' => $approver2->id,
        ]);

        Booking::create([
            'user_id' => $admin2->id,
            'vehicle_id' => $vehicleModels[7]->id,
            'driver_id' => $driverModels[2]->id,
            'purpose' => 'Rapat koordinasi kantor pusat',
            'description' => 'Rapat koordinasi bulanan dengan manajemen pusat',
            'destination' => 'Kantor Pusat Jakarta',
            'departure_datetime' => Carbon::now()->addDays(5),
            'return_datetime' => Carbon::now()->addDays(7),
            'passenger_count' => 2,
            'status' => 'approved_l1',
            'approver1_id' => $approver3->id,
            'approved_at_l1' => now()->subHours(2),
            'approval_note_l1' => 'Disetujui, keperluan mendesak',
            'approver2_id' => $approver4->id,
        ]);

        // ==================== SERVICE RECORDS ====================
        $serviceTypes = ['Ganti Oli', 'Tune Up', 'Ganti Ban', 'Service Berkala', 'Perbaikan AC', 'Ganti Rem'];
        foreach ($vehicleModels as $idx => $vehicle) {
            ServiceRecord::create([
                'vehicle_id' => $vehicle->id,
                'user_id' => $admin->id,
                'service_date' => Carbon::now()->subMonths(rand(1, 6)),
                'service_type' => $serviceTypes[$idx % count($serviceTypes)],
                'description' => 'Service rutin kendaraan',
                'odometer_km' => rand(50000, 80000),
                'cost' => rand(500000, 5000000),
                'workshop' => 'Bengkel Resmi ' . $vehicle->brand,
                'next_service_date' => Carbon::now()->addMonths(3),
                'next_service_km' => rand(85000, 95000),
            ]);
        }

        // ==================== FUEL RECORDS ====================
        foreach ($vehicleModels as $vehicle) {
            for ($j = 0; $j < rand(3, 6); $j++) {
                FuelRecord::create([
                    'vehicle_id' => $vehicle->id,
                    'user_id' => $admin->id,
                    'refuel_date' => Carbon::now()->subDays(rand(1, 90)),
                    'liters' => rand(30, 80),
                    'cost_per_liter' => rand(9000, 10500),
                    'total_cost' => rand(300000, 800000),
                    'odometer_km' => rand(50000, 100000),
                    'fuel_station' => 'SPBU ' . rand(1000, 9999),
                ]);
            }
        }
    }
}
