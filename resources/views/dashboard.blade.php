@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<style>
    /* ===== HERO PANORAMIC BANNER ===== */
    .dashboard-hero-banner {
        position: relative;
        height: 200px;
        border-radius: 18px;
        background-color: #0b2319;
        background-image: 
            linear-gradient(90deg, rgba(7, 24, 18, 0.95) 0%, rgba(9, 32, 24, 0.86) 45%, rgba(6, 20, 15, 0.25) 100%),
            url('/images/mining-banner.jpg');
        background-size: cover;
        background-position: center 60%;
        background-repeat: no-repeat;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0 44px;
        color: #ffffff;
        margin-bottom: 22px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05);
    }

    .hero-pill-tag {
        font-size: 11px;
        font-weight: 800;
        color: #34d399;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .hero-banner-title {
        font-size: 26px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.5px;
        color: #ffffff;
    }

    .hero-banner-title .mint-text {
        color: #34d399;
    }

    .hero-banner-desc {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.78);
        line-height: 1.5;
        max-width: 440px;
        margin-top: 8px;
    }

    /* ===== STATS ROW (5 CARDS IN 1 ROW) ===== */
    .stat-cards-row {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .stat-badge-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px 14px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-badge-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .stat-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .stat-icon-green  { background: #ecfdf5; color: #10b981; }
    .stat-icon-teal   { background: #f0fdf4; color: #059669; }
    .stat-icon-blue   { background: #eff6ff; color: #3b82f6; }
    .stat-icon-orange { background: #fffbeb; color: #d97706; }
    .stat-icon-red    { background: #fef2f2; color: #dc2626; }

    .stat-content {
        flex: 1;
        min-width: 0;
    }

    .stat-title {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-number-row {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .stat-trend {
        font-size: 10.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 2px;
    }

    .stat-trend.up { color: #10b981; }
    .stat-trend.down { color: #ef4444; }

    .stat-period {
        font-size: 9.5px;
        color: #94a3b8;
        display: block;
        margin-top: 2px;
    }

    /* ===== CHARTS & WIDGETS GRID (SIDE BY SIDE) ===== */
    .dashboard-grid-row {
        display: grid;
        grid-template-columns: 1.8fr 1.2fr;
        gap: 20px;
    }

    .grid-column-right {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Header in cards */
    .widget-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .widget-title {
        font-size: 14.5px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .widget-title i {
        color: #10b981;
        font-size: 15px;
    }

    .date-filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
    }

    .date-filter-pill i {
        color: #94a3b8;
        font-size: 11px;
    }

    .view-all-link {
        font-size: 12px;
        font-weight: 700;
        color: #10b981;
        text-decoration: none;
        transition: color 0.15s;
    }

    .view-all-link:hover {
        color: #059669;
        text-decoration: underline;
    }

    /* Chart legend custom */
    .chart-custom-legend {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 12px 20px 4px 20px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .legend-dot-bar {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #10b981;
    }

    .legend-line-icon {
        display: inline-flex;
        align-items: center;
        color: #065f46;
        font-size: 12px;
    }

    /* Donut chart wrap */
    .donut-layout {
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding: 12px 18px;
        gap: 14px;
    }

    .donut-chart-container {
        position: relative;
        width: 135px;
        height: 135px;
        flex-shrink: 0;
    }

    .donut-center-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }

    .donut-center-label .big-count {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .donut-center-label .sub-text {
        font-size: 9px;
        font-weight: 600;
        color: #94a3b8;
        margin-top: 2px;
        white-space: nowrap;
    }

    .donut-legend-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .donut-legend-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
    }

    .donut-legend-left {
        display: flex;
        align-items: center;
        gap: 7px;
        font-weight: 600;
        color: #334155;
    }

    .donut-color-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .donut-legend-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .donut-qty {
        font-weight: 700;
        color: #0f172a;
    }

    .donut-pct {
        color: #94a3b8;
        font-size: 11px;
    }

    /* Recent activities widget */
    .activity-list {
        padding: 6px 18px;
        display: flex;
        flex-direction: column;
    }

    .activity-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f8fafc;
    }

    .activity-row:last-child {
        border-bottom: none;
    }

    .activity-left-part {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .activity-icon-badge {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #334155;
        flex-shrink: 0;
    }

    .activity-main-text {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
    }

    .activity-sub-text {
        font-size: 11px;
        color: #64748b;
        margin-top: 1px;
    }

    .activity-time-text {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .stat-cards-row {
            grid-template-columns: repeat(2, 1fr);
        }
        .dashboard-grid-row {
            grid-template-columns: 1fr;
        }
        .dashboard-hero-banner {
            height: auto;
            padding: 24px;
        }
        .hero-banner-title {
            font-size: 22px;
        }
    }
</style>

<!-- 1. HERO PANORAMIC BANNER -->
<div class="dashboard-hero-banner">
    <div class="hero-pill-tag">
        <i class="fas fa-layer-group"></i> SEKAWAN FLEET
    </div>
    <h2 class="hero-banner-title">
        Armada Terkendali,<br>
        Operasional <span class="mint-text">Lebih Efisien</span>
    </h2>
    <p class="hero-banner-desc">
        Sistem manajemen armada terintegrasi untuk mendukung operasional yang aman, transparan, dan produktif.
    </p>
</div>

<!-- 2. 5 STAT CARDS ROW (1 neat row) -->
<div class="stat-cards-row">
    <!-- Total Kendaraan -->
    <a href="{{ route('vehicles.index') }}" class="stat-badge-card">
        <div class="stat-icon-box stat-icon-green">
            <i class="fas fa-truck"></i>
        </div>
        <div class="stat-content">
            <div class="stat-title">Total Kendaraan</div>
            <div class="stat-number-row">
                <span class="stat-val">{{ $totalVehicles }}</span>
                <span class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> 12%
                </span>
            </div>
            <span class="stat-period">vs bulan lalu</span>
        </div>
    </a>

    <!-- Kendaraan Tersedia -->
    <a href="{{ route('vehicles.index') }}?status=available" class="stat-badge-card">
        <div class="stat-icon-box stat-icon-teal">
            <i class="fas fa-circle-check"></i>
        </div>
        <div class="stat-content">
            <div class="stat-title">Kendaraan Tersedia</div>
            <div class="stat-number-row">
                <span class="stat-val">{{ $availableVehicles }}</span>
                <span class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> 8%
                </span>
            </div>
            <span class="stat-period">vs bulan lalu</span>
        </div>
    </a>

    <!-- Total Pemesanan -->
    <a href="{{ route('bookings.index') }}" class="stat-badge-card">
        <div class="stat-icon-box stat-icon-blue">
            <i class="fas fa-calendar-days"></i>
        </div>
        <div class="stat-content">
            <div class="stat-title">Total Pemesanan</div>
            <div class="stat-number-row">
                <span class="stat-val">{{ $totalBookings }}</span>
                <span class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> 15%
                </span>
            </div>
            <span class="stat-period">vs bulan lalu</span>
        </div>
    </a>

    <!-- Sedang Digunakan -->
    <a href="{{ route('vehicles.index') }}?status=in_use" class="stat-badge-card">
        <div class="stat-icon-box stat-icon-orange">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div class="stat-content">
            <div class="stat-title">Sedang Digunakan</div>
            <div class="stat-number-row">
                <span class="stat-val">{{ $inUseVehicles }}</span>
                <span class="stat-trend down">
                    <i class="fas fa-arrow-down"></i> 25%
                </span>
            </div>
            <span class="stat-period">vs bulan lalu</span>
        </div>
    </a>

    <!-- Dalam Perawatan -->
    <a href="{{ route('vehicles.index') }}?status=maintenance" class="stat-badge-card">
        <div class="stat-icon-box stat-icon-red">
            <i class="fas fa-wrench"></i>
        </div>
        <div class="stat-content">
            <div class="stat-title">Dalam Perawatan</div>
            <div class="stat-number-row">
                <span class="stat-val">{{ $maintenanceVehicles }}</span>
                <span class="stat-trend down" style="color: #94a3b8;">
                    <i class="fas fa-arrow-down"></i> 0%
                </span>
            </div>
            <span class="stat-period">vs bulan lalu</span>
        </div>
    </a>
</div>

<!-- 3. MAIN CHARTS & WIDGETS (SIDE BY SIDE) -->
<div class="dashboard-grid-row">
    <!-- LEFT COLUMN: Tren Pemakaian Armada -->
    <div class="content-card">
        <div class="widget-header">
            <div class="widget-title">
                <i class="fas fa-chart-line"></i>
                <span>Tren Pemakaian Armada</span>
            </div>
            <div class="date-filter-pill">
                <i class="far fa-calendar"></i>
                <span>17 Sep 2026 - 16 Okt 2026</span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>

        <div class="content-card-body" style="padding: 16px 20px 8px 20px;">
            <div style="position: relative; height: 260px; width: 100%;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Legend at bottom -->
        <div class="chart-custom-legend">
            <div class="legend-item">
                <span class="legend-dot-bar"></span>
                <span>Persentase Pemakaian</span>
            </div>
            <div class="legend-item">
                <span class="legend-line-icon">━●━</span>
                <span>Jumlah Kendaraan</span>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Jenis Kendaraan + Aktivitas Terbaru -->
    <div class="grid-column-right">
        <!-- Jenis Kendaraan (Donut Chart) -->
        <div class="content-card">
            <div class="widget-header">
                <div class="widget-title">
                    <i class="fas fa-chart-pie"></i>
                    <span>Jenis Kendaraan</span>
                </div>
            </div>

            <div class="content-card-body" style="padding: 14px 16px;">
                <div class="donut-layout">
                    <div class="donut-chart-container">
                        <canvas id="vehicleTypeChart"></canvas>
                        <div class="donut-center-label">
                            <div class="big-count">{{ $totalVehicles }}</div>
                            <div class="sub-text">Total Armada</div>
                        </div>
                    </div>

                    <div class="donut-legend-list">
                        @foreach($vehicleBreakdown as $vb)
                        <div class="donut-legend-row">
                            <div class="donut-legend-left">
                                <span class="donut-color-dot" style="background-color: {{ $vb['color'] }};"></span>
                                <span>{{ $vb['name'] }}</span>
                            </div>
                            <div class="donut-legend-right">
                                <span class="donut-qty">{{ $vb['count'] }}</span>
                                <span class="donut-pct">{{ $vb['percentage'] }}%</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="content-card">
            <div class="widget-header">
                <div class="widget-title">
                    <i class="fas fa-clock-rotate-left"></i>
                    <span>Aktivitas Terbaru</span>
                </div>
                <a href="{{ route('logs.index') }}" class="view-all-link">Lihat Semua</a>
            </div>

            <div class="activity-list">
                @foreach($defaultActivities as $act)
                <div class="activity-row">
                    <div class="activity-left-part">
                        <div class="activity-icon-badge" style="color: {{ $act['color'] }};">
                            <i class="fas {{ $act['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="activity-main-text">{{ $act['title'] }}</div>
                            <div class="activity-sub-text">{{ $act['desc'] }}</div>
                        </div>
                    </div>
                    <div class="activity-time-text">{{ $act['time'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // 1. Combo Bar & Line Chart (Tren Pemakaian Armada)
    const ctxTrend = document.getElementById('trendChart').getContext('2d');
    const trendLabels = @json($trendLabels);
    const trendLineData = @json($trendLineData);
    const trendBarData = @json($trendBarData);

    new Chart(ctxTrend, {
        type: 'bar',
        data: {
            labels: trendLabels,
            datasets: [
                {
                    type: 'line',
                    label: 'Jumlah Kendaraan',
                    data: trendLineData,
                    borderColor: '#065f46',
                    backgroundColor: '#065f46',
                    borderWidth: 2,
                    pointBackgroundColor: '#065f46',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 1.5,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3,
                    yAxisID: 'y'
                },
                {
                    type: 'bar',
                    label: 'Persentase Pemakaian',
                    data: trendBarData,
                    backgroundColor: 'rgba(167, 243, 208, 0.75)',
                    hoverBackgroundColor: '#10b981',
                    borderRadius: 4,
                    barThickness: 11,
                    yAxisID: 'y'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { family: 'Plus Jakarta Sans', size: 12 },
                    bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 10.5 },
                        color: '#94a3b8',
                        maxRotation: 0,
                        autoSkip: true,
                        maxTicksLimit: 9
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 50,
                    grid: {
                        color: '#f1f5f9'
                    },
                    ticks: {
                        stepSize: 10,
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        color: '#94a3b8'
                    }
                }
            }
        }
    });

    // 2. Donut Chart (Jenis Kendaraan)
    const ctxType = document.getElementById('vehicleTypeChart').getContext('2d');
    const breakdown = @json($vehicleBreakdown);
    const typeLabels = Object.values(breakdown).map(b => b.name);
    const typeData = Object.values(breakdown).map(b => b.count);
    const typeColors = Object.values(breakdown).map(b => b.color);

    new Chart(ctxType, {
        type: 'doughnut',
        data: {
            labels: typeLabels,
            datasets: [{
                data: typeData,
                backgroundColor: typeColors,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                    padding: 10,
                    cornerRadius: 8
                }
            }
        }
    });
</script>
@endpush
@endsection
