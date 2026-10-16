<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class BookingsExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStyles, WithColumnWidths
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Booking::with(['user', 'vehicle', 'driver', 'approver1', 'approver2']);

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('departure_datetime', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('departure_datetime', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'No. Pemesanan',
            'Tanggal Pemesanan',
            'Pemohon',
            'Departemen',
            'Kendaraan',
            'Plat Nomor',
            'Driver',
            'Tujuan',
            'Keperluan',
            'Tgl Berangkat',
            'Tgl Kembali',
            'Jumlah Penumpang',
            'Status',
            'Penyetuju L1',
            'Tgl Persetujuan L1',
            'Penyetuju L2',
            'Tgl Persetujuan L2',
            'KM Awal',
            'KM Akhir',
            'Jarak Tempuh (km)',
            'BBM Terpakai (L)',
            'Catatan',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->booking_number,
            $booking->created_at->format('d/m/Y'),
            $booking->user?->name ?? '-',
            $booking->user?->department ?? '-',
            ($booking->vehicle?->brand ?? '-') . ' ' . ($booking->vehicle?->model ?? ''),
            $booking->vehicle?->plate_number ?? '-',
            $booking->driver?->name ?? 'Tanpa Driver',
            $booking->destination,
            $booking->purpose,
            $booking->departure_datetime?->format('d/m/Y H:i') ?? '-',
            $booking->return_datetime?->format('d/m/Y H:i') ?? '-',
            $booking->passenger_count,
            $booking->getStatusLabel(),
            $booking->approver1?->name ?? '-',
            $booking->approved_at_l1?->format('d/m/Y H:i') ?? '-',
            $booking->approver2?->name ?? '-',
            $booking->approved_at_l2?->format('d/m/Y H:i') ?? '-',
            $booking->start_km ?? '-',
            $booking->end_km ?? '-',
            $booking->getDistanceKm() ?? '-',
            $booking->fuel_used ?? '-',
            $booking->usage_notes ?? '-',
        ];
    }

    public function title(): string
    {
        return 'Laporan Pemesanan Kendaraan';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF16A34A'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 15,
            'C' => 25,
            'D' => 20,
            'E' => 25,
            'F' => 15,
            'G' => 25,
            'H' => 25,
            'I' => 30,
            'J' => 18,
            'K' => 18,
            'L' => 10,
            'M' => 20,
            'N' => 25,
            'O' => 18,
            'P' => 25,
            'Q' => 18,
            'R' => 10,
            'S' => 10,
            'T' => 15,
            'U' => 15,
            'V' => 30,
        ];
    }
}
