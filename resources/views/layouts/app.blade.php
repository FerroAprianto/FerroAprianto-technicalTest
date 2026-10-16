<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Pemesanan Kendaraan - PT Sekawan Nikel Indonesia">
    <title>@yield('title', 'Dashboard') - SEKAWAN Fleet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --brand-green: #10b981;
            --brand-green-light: #34d399;
            --brand-green-dark: #059669;
            --btn-green: #1b6e4e;
            --btn-green-hover: #14573e;
            --sidebar-bg: #092218;
            --sidebar-item-active: #10b981;
            --bg-canvas: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-light: #f1f5f9;
            --border-default: #e2e8f0;
            --sidebar-width: 270px;
            --header-height: 80px;
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow-subtle: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.02);
            --shadow-card: 0 4px 12px rgba(15, 23, 42, 0.04);
        }

        /* ===== LUXURY ALERT NOTIFICATIONS ===== */
        .custom-alert-card, .alert {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 16px 20px;
            border-radius: 14px;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 4px 10px -2px rgba(15, 23, 42, 0.02);
            overflow: hidden;
            animation: alertSlideDown 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        .custom-alert-card.fade-out, .alert.fade-out {
            opacity: 0;
            transform: translateY(-12px);
            pointer-events: none;
            transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1), transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .custom-alert-card:hover .alert-progress-bar {
            animation-play-state: paused;
        }

        @keyframes alertSlideDown {
            from {
                opacity: 0;
                transform: translateY(-16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Success Theme */
        .alert-type-success, .alert-success {
            background: linear-gradient(135deg, rgba(236, 253, 245, 0.95) 0%, rgba(209, 250, 229, 0.8) 100%);
            border: 1.5px solid #a7f3d0;
            color: #065f46;
        }
        .alert-type-success .alert-icon-wrapper, .alert-success > i:first-child {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }
        .alert-type-success .alert-title-text {
            color: #047857;
        }

        /* Danger Theme */
        .alert-type-danger, .alert-danger {
            background: linear-gradient(135deg, rgba(254, 242, 242, 0.95) 0%, rgba(254, 226, 226, 0.8) 100%);
            border: 1.5px solid #fecaca;
            color: #991b1b;
        }
        .alert-type-danger .alert-icon-wrapper, .alert-danger > i:first-child {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
        }
        .alert-type-danger .alert-title-text {
            color: #b91c1c;
        }

        /* Warning Theme */
        .alert-type-warning, .alert-warning {
            background: linear-gradient(135deg, rgba(255, 251, 235, 0.95) 0%, rgba(254, 243, 199, 0.8) 100%);
            border: 1.5px solid #fde68a;
            color: #92400e;
        }
        .alert-type-warning .alert-icon-wrapper, .alert-warning > i:first-child {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
        }
        .alert-type-warning .alert-title-text {
            color: #b45309;
        }

        /* Info Theme */
        .alert-type-info, .alert-info {
            background: linear-gradient(135deg, rgba(240, 249, 255, 0.95) 0%, rgba(224, 242, 254, 0.8) 100%);
            border: 1.5px solid #bae6fd;
            color: #075985;
        }
        .alert-type-info .alert-icon-wrapper, .alert-info > i:first-child {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);
        }
        .alert-type-info .alert-title-text {
            color: #0369a1;
        }

        /* Alert elements */
        .alert-icon-wrapper, .alert > i:first-child {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-content-body {
            flex: 1;
        }

        .alert-title-text {
            font-size: 14.5px;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 3px;
            letter-spacing: -0.2px;
        }

        .alert-message-text {
            font-size: 13.5px;
            line-height: 1.45;
            color: #334155;
            font-weight: 500;
        }

        .alert-error-list {
            margin: 6px 0 0 18px;
            font-size: 13px;
            color: #334155;
            line-height: 1.5;
        }

        .alert-close-btn {
            background: transparent;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            margin-top: -2px;
            margin-right: -4px;
        }

        .alert-close-btn:hover {
            background: rgba(0, 0, 0, 0.06);
            color: #0f172a;
        }

        /* Animated Progress bar at bottom */
        .alert-progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3.5px;
            width: 100%;
            animation: alertProgress 7s linear forwards;
        }

        .bar-success { background: linear-gradient(90deg, #10b981, #059669); }
        .bar-danger  { background: linear-gradient(90deg, #ef4444, #dc2626); }
        .bar-warning { background: linear-gradient(90deg, #f59e0b, #d97706); }
        .bar-info    { background: linear-gradient(90deg, #0ea5e9, #0284c7); }

        @keyframes alertProgress {
            from { width: 100%; }
            to   { width: 0%; }
        }

        /* SweetAlert2 Brand Styling */
        div.swal2-container {
            z-index: 10000 !important;
            backdrop-filter: blur(4px) !important;
        }
        .swal2-popup.sekawan-swal {
            border-radius: 20px !important;
            padding: 24px !important;
            box-shadow: 0 25px 50px -12px rgba(9, 34, 24, 0.25) !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
        }
        .swal2-title.sekawan-swal-title {
            font-size: 18px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-bottom: 8px !important;
        }
        .swal2-html-container.sekawan-swal-text {
            font-size: 13.5px !important;
            color: #475569 !important;
            line-height: 1.55 !important;
            margin: 0 !important;
        }
        .swal2-actions {
            margin-top: 22px !important;
            gap: 10px !important;
        }
        .swal2-confirm.sekawan-swal-confirm {
            background: #1b6e4e !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            font-weight: 700 !important;
            font-size: 13.5px !important;
            padding: 10px 22px !important;
            box-shadow: 0 4px 12px rgba(27, 110, 78, 0.3) !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
        }
        .swal2-confirm.sekawan-swal-confirm:hover {
            background: #14573e !important;
            transform: translateY(-1px) !important;
        }
        .swal2-cancel.sekawan-swal-cancel {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 13.5px !important;
            padding: 10px 20px !important;
            border: 1px solid #e2e8f0 !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
        }
        .swal2-cancel.sekawan-swal-cancel:hover {
            background: #e2e8f0 !important;
            color: #0f172a !important;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
            background-color: var(--bg-canvas);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #092218 0%, #061912 100%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        .header-breadcrumb {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .header-breadcrumb a {
            color: #64748b;
            text-decoration: none;
        }

        .header-breadcrumb a:hover {
            color: #0f172a;
        }

        .header-breadcrumb span.separator {
            color: #cbd5e1;
            font-size: 11px;
        }

        .header-breadcrumb span.current {
            color: #0f172a;
        }

        /* Contour lines background decoration at bottom of sidebar */
        .sidebar::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 280px;
            background-image: radial-gradient(circle at 10% 90%, rgba(16, 185, 129, 0.08) 0%, transparent 60%),
                              radial-gradient(circle at 90% 80%, rgba(52, 211, 153, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .sidebar-brand {
            padding: 28px 24px 22px 24px;
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 2;
        }

        .brand-logo-svg {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            filter: drop-shadow(0 2px 8px rgba(16, 185, 129, 0.3));
        }

        .brand-title {
            font-size: 20px;
            line-height: 1.15;
            letter-spacing: -0.4px;
        }

        .brand-title span.bold {
            color: #ffffff;
            font-weight: 800;
        }

        .brand-title span.light {
            color: var(--brand-green-light);
            font-weight: 500;
            margin-left: 4px;
        }

        .brand-company {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 2px;
            font-weight: 400;
        }

        .sidebar-nav {
            padding: 8px 16px 20px 16px;
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .nav-section-label {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #648777;
            padding: 16px 12px 6px 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #9fb3a8;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 3px;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
            transform: translateX(2px);
        }

        .nav-item.active {
            background: var(--sidebar-item-active);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        }

        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
        }

        /* Sidebar User Footer */
        .sidebar-footer {
            padding: 18px 20px;
            position: relative;
            z-index: 2;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.15);
        }

        .sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--brand-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
            flex-shrink: 0;
        }

        .user-meta-name {
            font-size: 13.5px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 170px;
        }

        .user-meta-role {
            font-size: 11.5px;
            color: #84a997;
            text-transform: capitalize;
            margin-top: 2px;
        }

        .btn-logout {
            width: 100%;
            background: none;
            border: none;
            color: #9fb3a8;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            padding: 6px 4px;
            transition: color 0.2s;
            font-family: inherit;
        }

        .btn-logout:hover {
            color: #ffffff;
        }

        /* ===== TOP HEADER ===== */
        .top-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: #ffffff;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 36px;
            z-index: 900;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .header-greeting-wrap {
            display: flex;
            flex-direction: column;
        }

        .header-greeting-sub {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .header-greeting-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.4px;
            line-height: 1.2;
            margin-top: 1px;
        }

        .header-greeting-desc {
            font-size: 12.5px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .header-right-meta {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .datetime-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #334155;
            font-size: 12px;
            font-weight: 500;
        }

        .datetime-badge i {
            color: #94a3b8;
            font-size: 16px;
        }

        .datetime-badge .date-text {
            font-weight: 600;
            color: #1e293b;
        }

        .datetime-badge .time-text {
            color: #64748b;
            font-size: 11px;
            margin-top: 1px;
        }

        .header-profile-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }

        .header-user-avatar {
            width: 40px;
            height: 40px;
            background: var(--brand-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .header-profile-btn i {
            color: #94a3b8;
            font-size: 12px;
        }

        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 20px;
            cursor: pointer;
            padding: 6px;
            margin-right: 12px;
        }

        /* ===== MAIN CONTENT WRAPPER ===== */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 32px 36px 48px 36px;
            min-height: calc(100vh - var(--header-height));
        }

        /* ===== GENERAL CARD & UI COMPONENTS ===== */
        .content-card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-subtle);
            overflow: hidden;
        }

        .content-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .content-card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .content-card-title i {
            color: var(--brand-green);
        }

        .content-card-body {
            padding: 24px;
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            font-weight: 500;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            color: #991b1b;
        }

        /* Global Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1.5px solid transparent;
        }

        .btn-primary {
            background: var(--btn-green);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(27, 110, 78, 0.25);
        }

        .btn-primary:hover {
            background: var(--btn-green-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(27, 110, 78, 0.35);
        }

        .btn-secondary {
            background: #f8fafc;
            color: #334155;
            border-color: #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 8px;
        }

        /* Tables */
        .table-wrapper {
            overflow-x: auto;
            border-radius: var(--radius-md);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-align: left;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-light);
            white-space: nowrap;
        }

        td {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-light);
            color: #334155;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafcfb;
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .badge-danger  { background: #fee2e2; color: #b91c1c; }
        .badge-info    { background: #e0f2fe; color: #0369a1; }
        .badge-gray    { background: #f1f5f9; color: #475569; }

        /* Form Controls */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            width: 100%;
            height: 44px;
            padding: 0 14px;
            border: 1.5px solid var(--border-default);
            border-radius: 10px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--text-main);
            background: #ffffff;
            transition: all 0.2s;
            outline: none;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand-green);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .top-header {
                left: 0;
                padding: 0 20px;
            }
            .main-wrapper {
                margin-left: 0;
                padding: 24px 20px;
            }
            .hamburger-btn {
                display: block;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div>
            <!-- Brand Logo -->
            <div class="sidebar-brand">
                <svg class="brand-logo-svg" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 6 H28 L38 16 H22 Z" fill="#34D399"/>
                    <path d="M38 16 L26 28 H12 L24 16 Z" fill="#10B981"/>
                    <path d="M10 24 H26 L36 34 H20 Z" fill="#059669"/>
                    <path d="M34 34 L22 44 H8 L20 34 Z" fill="#047857"/>
                </svg>
                <div>
                    <div class="brand-title">
                        <span class="bold">SEKAWAN</span><span class="light">Fleet</span>
                    </div>
                    <div class="brand-company">PT Sekawan Nikel Indonesia</div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="sidebar-nav">
                <!-- Group: UTAMA -->
                <div class="nav-section-label">Utama</div>
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-house"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Group: PEMESANAN -->
                <div class="nav-section-label">Pemesanan</div>
                <a href="{{ route('bookings.index') }}" class="nav-item {{ request()->routeIs('bookings.index') || request()->routeIs('bookings.show') ? 'active' : '' }}">
                    <i class="fas fa-calendar-days"></i>
                    <span>Semua Pemesanan</span>
                </a>

                @if(auth()->user()->isAdmin())
                <a href="{{ route('bookings.create') }}" class="nav-item {{ request()->routeIs('bookings.create') ? 'active' : '' }}">
                    <i class="fas fa-circle-plus"></i>
                    <span>Buat Pemesanan</span>
                </a>
                @endif

                @php
                    $pendingCount = 0;
                    if(auth()->user()->isApprover()) {
                        if(auth()->user()->approval_level == 1) {
                            $pendingCount = \App\Models\Booking::where('status', 'pending')->count();
                        } elseif(auth()->user()->approval_level == 2) {
                            $pendingCount = \App\Models\Booking::where('status', 'approved_l1')->count();
                        } else {
                            $pendingCount = \App\Models\Booking::where(function($q) {
                                $q->where('approver1_id', auth()->id())->where('status', 'pending');
                            })->orWhere(function($q) {
                                $q->where('approver2_id', auth()->id())->where('status', 'approved_l1');
                            })->count();
                        }
                    } elseif(auth()->user()->isAdmin()) {
                        $pendingCount = \App\Models\Booking::whereIn('status', ['pending', 'approved_l1'])->count();
                    }
                @endphp
                <a href="{{ route('bookings.approvals') }}" class="nav-item {{ request()->routeIs('bookings.approvals') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Persetujuan</span>
                    @if($pendingCount > 0)
                    <span class="nav-badge">{{ $pendingCount }}</span>
                    @endif
                </a>

                <!-- Group: ARMADA -->
                <div class="nav-section-label">Armada</div>
                <a href="{{ route('vehicles.index') }}" class="nav-item {{ request()->routeIs('vehicles*') ? 'active' : '' }}">
                    <i class="fas fa-truck"></i>
                    <span>Kendaraan</span>
                </a>
                <a href="{{ route('drivers.index') }}" class="nav-item {{ request()->routeIs('drivers*') ? 'active' : '' }}">
                    <i class="fas fa-id-card"></i>
                    <span>Driver</span>
                </a>

                <!-- Group: ADMINISTRASI -->
                @if(auth()->user()->isAdmin())
                <div class="nav-section-label">Administrasi</div>
                <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users*') ? 'active' : '' }}">
                    <i class="fas fa-users-gear"></i>
                    <span>Manajemen User</span>
                </a>
                <a href="{{ route('logs.index') }}" class="nav-item {{ request()->routeIs('logs*') ? 'active' : '' }}">
                    <i class="fas fa-clock-rotate-left"></i>
                    <span>Log Aktivitas</span>
                </a>
                @endif
            </nav>
        </div>

        <!-- Sidebar User Card Footer -->
        <div class="sidebar-footer">
            <div class="sidebar-user-card">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-meta-name" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</div>
                    <div class="user-meta-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- TOP HEADER -->
    <header class="top-header">
        <div style="display: flex; align-items: center;">
            <button class="hamburger-btn" onclick="toggleSidebar()" id="hamburgerBtn" title="Menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="header-greeting-wrap">
                @hasSection('breadcrumb')
                    <div class="header-breadcrumb">@yield('breadcrumb')</div>
                    <h1 class="header-greeting-title">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-subtitle')
                        <p class="header-greeting-desc">@yield('page-subtitle')</p>
                    @endif
                @else
                    <span class="header-greeting-sub">Selamat Datang,</span>
                    <h1 class="header-greeting-title">{{ auth()->user()->name }}</h1>
                    <p class="header-greeting-desc">Pantau dan kelola seluruh armada SEKAWAN Fleet dengan mudah.</p>
                @endif
            </div>
        </div>

        <div class="header-right-meta">
            <!-- Dynamic Date & Live Time -->
            <div class="datetime-badge">
                <i class="fas fa-calendar-alt"></i>
                <div>
                    <div class="date-text" id="liveDateText">Jumat, 17 Oktober 2026</div>
                    <div class="time-text" id="liveTimeText">10:24 WIB</div>
                </div>
            </div>

            <!-- Profile Circle Button -->
            <div class="header-profile-btn" title="{{ auth()->user()->name }}">
                <div class="header-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </header>

    <!-- MAIN BODY -->
    <main class="main-wrapper">
        <!-- LUXURY FLASH ALERTS -->
        @if(session('success'))
        <div class="custom-alert-card alert-type-success" id="flashAlert">
            <div class="alert-icon-wrapper">
                <i class="fas fa-circle-check"></i>
            </div>
            <div class="alert-content-body">
                <div class="alert-title-text">Berhasil!</div>
                <div class="alert-message-text">{{ session('success') }}</div>
            </div>
            <button type="button" class="alert-close-btn" onclick="dismissAlert('flashAlert')" title="Tutup">
                <i class="fas fa-xmark"></i>
            </button>
            <div class="alert-progress-bar bar-success"></div>
        </div>
        @endif

        @if(session('error'))
        <div class="custom-alert-card alert-type-danger" id="flashAlert">
            <div class="alert-icon-wrapper">
                <i class="fas fa-circle-xmark"></i>
            </div>
            <div class="alert-content-body">
                <div class="alert-title-text">Perhatian / Terjadi Kesalahan</div>
                <div class="alert-message-text">{{ session('error') }}</div>
            </div>
            <button type="button" class="alert-close-btn" onclick="dismissAlert('flashAlert')" title="Tutup">
                <i class="fas fa-xmark"></i>
            </button>
            <div class="alert-progress-bar bar-danger"></div>
        </div>
        @endif

        @if(session('warning'))
        <div class="custom-alert-card alert-type-warning" id="flashAlert">
            <div class="alert-icon-wrapper">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
            <div class="alert-content-body">
                <div class="alert-title-text">Peringatan Sistem</div>
                <div class="alert-message-text">{{ session('warning') }}</div>
            </div>
            <button type="button" class="alert-close-btn" onclick="dismissAlert('flashAlert')" title="Tutup">
                <i class="fas fa-xmark"></i>
            </button>
            <div class="alert-progress-bar bar-warning"></div>
        </div>
        @endif

        @if(session('info'))
        <div class="custom-alert-card alert-type-info" id="flashAlert">
            <div class="alert-icon-wrapper">
                <i class="fas fa-circle-info"></i>
            </div>
            <div class="alert-content-body">
                <div class="alert-title-text">Informasi Operasional</div>
                <div class="alert-message-text">{{ session('info') }}</div>
            </div>
            <button type="button" class="alert-close-btn" onclick="dismissAlert('flashAlert')" title="Tutup">
                <i class="fas fa-xmark"></i>
            </button>
            <div class="alert-progress-bar bar-info"></div>
        </div>
        @endif

        @if($errors->any())
        <div class="custom-alert-card alert-type-danger" id="flashAlert">
            <div class="alert-icon-wrapper">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
            <div class="alert-content-body">
                <div class="alert-title-text">Terdapat {{ $errors->count() }} Kesalahan:</div>
                <ul class="alert-error-list">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="alert-close-btn" onclick="dismissAlert('flashAlert')" title="Tutup">
                <i class="fas fa-xmark"></i>
            </button>
            <div class="alert-progress-bar bar-danger"></div>
        </div>
        @endif

        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        // Live clock update in Indonesian
        function updateClock() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const dateNum = now.getDate();
            const monthName = months[now.getMonth()];
            const yearNum = now.getFullYear();

            const dateStr = `${dayName}, ${dateNum} ${monthName} ${yearNum}`;
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const timeStr = `${hours}:${minutes} WIB`;

            const dateEl = document.getElementById('liveDateText');
            const timeEl = document.getElementById('liveTimeText');
            if (dateEl) dateEl.innerText = dateStr;
            if (timeEl) timeEl.innerText = timeStr;
        }

        updateClock();
        setInterval(updateClock, 1000);

        function dismissAlert(alertId) {
            const el = document.getElementById(alertId);
            if (el) {
                el.classList.add('fade-out');
                setTimeout(() => el.remove(), 300);
            }
        }

        // Auto dismiss flash alert after 7s (pause on hover)
        let alertTimeout = setTimeout(() => {
            const alert = document.getElementById('flashAlert');
            if (alert) dismissAlert('flashAlert');
        }, 7000);

        const alertEl = document.getElementById('flashAlert');
        if (alertEl) {
            alertEl.addEventListener('mouseenter', () => clearTimeout(alertTimeout));
            alertEl.addEventListener('mouseleave', () => {
                alertTimeout = setTimeout(() => dismissAlert('flashAlert'), 4000);
            });
        }

        // Global SweetAlert Confirm Interceptor for seamless modern modal
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[onsubmit*="confirm("]').forEach(form => {
                const originalOnsubmit = form.getAttribute('onsubmit');
                const match = originalOnsubmit.match(/confirm\(['"](.*?)['"]\)/);
                const confirmMsg = match ? match[1] : 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                
                // Remove inline onsubmit to prevent default browser prompt
                form.removeAttribute('onsubmit');
                
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const isDanger = confirmMsg.toLowerCase().includes('hapus') || confirmMsg.toLowerCase().includes('batal') || confirmMsg.toLowerCase().includes('tolak');
                    
                    Swal.fire({
                        title: isDanger ? 'Konfirmasi Tindakan' : 'Persetujuan Pemesanan',
                        text: confirmMsg,
                        icon: isDanger ? 'warning' : 'question',
                        showCancelButton: true,
                        confirmButtonText: isDanger ? '<i class="fas fa-trash-can" style="margin-right: 6px;"></i> Ya, Lanjutkan' : '<i class="fas fa-check" style="margin-right: 6px;"></i> Ya, Setujui',
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'sekawan-swal',
                            title: 'sekawan-swal-title',
                            htmlContainer: 'sekawan-swal-text',
                            confirmButton: isDanger ? 'sekawan-swal-confirm' : 'sekawan-swal-confirm',
                            cancelButton: 'sekawan-swal-cancel'
                        },
                        buttonsStyling: false,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
