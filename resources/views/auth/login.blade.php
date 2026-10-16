<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEKAWAN Fleet - Sistem Manajemen Armada</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --brand-green: #10b981;
            --brand-green-light: #34d399;
            --brand-green-dark: #059669;
            --btn-green: #1b6e4e;
            --btn-green-hover: #15573e;
            --dark-bg: #0d2319;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #ffffff;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .login-wrapper {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        /* ================= LEFT HERO SECTION ================= */
        .hero-section {
            flex: 1.25;
            position: relative;
            background-color: var(--dark-bg);
            background-image: 
                linear-gradient(135deg, rgba(7, 24, 18, 0.94) 0%, rgba(9, 32, 24, 0.82) 42%, rgba(6, 20, 15, 0.90) 100%),
                url('/images/fleet-bg.jpg');
            background-size: cover;
            background-position: center 70%;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 56px 64px 44px 64px;
            color: #ffffff;
            overflow: hidden;
        }

        /* Subtle glowing pin and route in the sky */
        .sky-route-container {
            position: absolute;
            top: 14%;
            left: 56%;
            z-index: 2;
            pointer-events: none;
        }

        .sky-route-svg {
            overflow: visible;
        }

        .sky-pin-marker {
            position: absolute;
            top: -12px;
            right: 12px;
            width: 28px;
            height: 28px;
            background: rgba(16, 185, 129, 0.25);
            border: 1px solid rgba(52, 211, 153, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #34d399;
            font-size: 13px;
            box-shadow: 0 0 16px rgba(52, 211, 153, 0.6);
            animation: pulse-pin 3s infinite ease-in-out;
        }

        @keyframes pulse-pin {
            0%, 100% { transform: scale(1); box-shadow: 0 0 12px rgba(52, 211, 153, 0.5); }
            50% { transform: scale(1.12); box-shadow: 0 0 22px rgba(52, 211, 153, 0.85); }
        }

        /* Diagonal geometric accent corner */
        .corner-accent-1 {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 260px;
            height: 120px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.45) 100%);
            clip-path: polygon(100% 0, 100% 100%, 0 100%);
            pointer-events: none;
            z-index: 1;
        }

        .corner-accent-2 {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 170px;
            height: 75px;
            background: linear-gradient(135deg, rgba(52, 211, 153, 0.3) 0%, rgba(16, 185, 129, 0.55) 100%);
            clip-path: polygon(100% 0, 100% 100%, 0 100%);
            pointer-events: none;
            z-index: 2;
        }

        /* Brand Header */
        .hero-brand {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 3;
        }

        .brand-logo-svg {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            filter: drop-shadow(0 2px 8px rgba(16, 185, 129, 0.4));
        }

        .brand-title {
            font-size: 24px;
            line-height: 1.1;
            letter-spacing: -0.5px;
        }

        .brand-title span.bold {
            color: #ffffff;
            font-weight: 800;
        }

        .brand-title span.light {
            color: #34d399;
            font-weight: 500;
            margin-left: 6px;
        }

        .brand-company {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.72);
            font-weight: 400;
            margin-top: 3px;
        }

        /* Hero Content */
        .hero-main {
            position: relative;
            z-index: 3;
            margin-top: 36px;
            margin-bottom: 36px;
            max-width: 540px;
        }

        .hero-heading {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.8px;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .hero-heading .green-text {
            color: #34d399;
            display: inline-block;
        }

        .hero-desc {
            font-size: 14px;
            line-height: 1.65;
            color: rgba(255, 255, 255, 0.75);
            max-width: 440px;
            margin-bottom: 32px;
        }

        /* Feature items */
        .features-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .feature-card {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .feature-badge {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.14);
            border: 1px solid rgba(52, 211, 153, 0.28);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #34d399;
            font-size: 16px;
            flex-shrink: 0;
            transition: all 0.25s ease;
        }

        .feature-card:hover .feature-badge {
            background: rgba(16, 185, 129, 0.24);
            border-color: rgba(52, 211, 153, 0.5);
            transform: scale(1.05);
        }

        .feature-title {
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .feature-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.4;
        }

        /* Hero Footer */
        .hero-footer {
            position: relative;
            z-index: 3;
        }

        .footer-line {
            width: 32px;
            height: 3px;
            background: #10b981;
            border-radius: 2px;
            margin-bottom: 12px;
        }

        .footer-tagline {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.8px;
            color: rgba(255, 255, 255, 0.68);
            text-transform: uppercase;
        }

        /* ================= RIGHT FORM SECTION ================= */
        .form-section {
            flex: 0.95;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 60px 36px 60px;
            position: relative;
            overflow: hidden;
        }

        /* Top Bar */
        .form-header-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
        }

        .header-brand-tag {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: 0.2px;
        }

        .header-accent-line {
            width: 38px;
            height: 2.5px;
            background: #10b981;
            border-radius: 2px;
        }

        /* Form Container */
        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .form-greeting h2 {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.7px;
            margin-bottom: 8px;
        }

        .form-greeting p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        /* Alert */
        .alert-error {
            background: linear-gradient(135deg, rgba(254, 242, 242, 0.95) 0%, rgba(254, 226, 226, 0.8) 100%);
            border: 1.5px solid #fecaca;
            color: #991b1b;
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 13.5px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 24px;
            box-shadow: 0 8px 20px -4px rgba(239, 68, 68, 0.15);
            animation: alertSlideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes alertSlideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-error .alert-error-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        }

        .alert-error-title {
            font-weight: 800;
            color: #b91c1c;
            font-size: 13.5px;
            margin-bottom: 2px;
        }

        .alert-error-body {
            line-height: 1.45;
            color: #475569;
            font-size: 13px;
        }

        /* Inputs */
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

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 16px;
            color: #94a3af;
            font-size: 15px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-field {
            width: 100%;
            height: 48px;
            padding: 0 44px 0 46px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            color: #0f172a;
            transition: all 0.2s ease;
            outline: none;
        }

        .input-field::placeholder {
            color: #94a3b8;
            font-size: 14px;
        }

        .input-field:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            background: #ffffff;
        }

        .input-field:focus ~ .input-icon-left,
        .input-box:focus-within .input-icon-left {
            color: #10b981;
        }

        .input-toggle-eye {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 15px;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .input-toggle-eye:hover {
            color: #475569;
        }

        /* Checkbox & Forgot */
        .form-options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 6px;
            margin-bottom: 24px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #334155;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-container input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            accent-color: var(--brand-green-dark);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            font-weight: 600;
            color: #059669;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #047857;
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            height: 48px;
            background: var(--btn-green);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 14px rgba(27, 110, 78, 0.25);
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            background: var(--btn-green-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(27, 110, 78, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Quick Account Helper Pills */
        .quick-accounts {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px dashed #e2e8f0;
        }

        .quick-accounts-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .account-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .account-pill {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 11.5px;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .account-pill:hover {
            background: #ecfdf5;
            border-color: #a7f3d0;
            color: #065f46;
            transform: translateY(-1px);
        }

        .account-pill .pill-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10b981;
        }

        /* Form Footer */
        .form-footer {
            position: relative;
            z-index: 2;
            padding-top: 20px;
        }

        .copyright-text {
            font-size: 12px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 2px;
        }

        .sub-copyright-text {
            font-size: 11.5px;
            color: #94a3b8;
        }

        /* Large faint watermark of 'S' logo in bottom right */
        .watermark-logo {
            position: absolute;
            bottom: -25px;
            right: -25px;
            width: 200px;
            height: 200px;
            pointer-events: none;
            opacity: 0.06;
            z-index: 1;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-section {
                padding: 40px 36px;
            }
            .form-section {
                padding: 40px 36px;
            }
            .hero-heading {
                font-size: 34px;
            }
            .sky-route-container {
                display: none;
            }
        }

        @media (max-width: 860px) {
            .login-wrapper {
                flex-direction: column;
            }
            .hero-section {
                padding: 36px 24px;
                flex: none;
            }
            .hero-main {
                margin: 24px 0;
            }
            .form-section {
                padding: 40px 24px 32px 24px;
                flex: 1;
                min-height: auto;
            }
            .corner-accent-1, .corner-accent-2 {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- LEFT HERO SECTION -->
        <div class="hero-section">
            <!-- Dotted path & Pin in sky -->
            <div class="sky-route-container">
                <svg class="sky-route-svg" width="130" height="70" viewBox="0 0 130 70" fill="none">
                    <path d="M5 60 C 35 48, 65 24, 115 8" stroke="rgba(52, 211, 153, 0.4)" stroke-width="2" stroke-dasharray="4 5" />
                </svg>
                <div class="sky-pin-marker">
                    <i class="fas fa-location-dot"></i>
                </div>
            </div>

            <!-- Corner geometric accents -->
            <div class="corner-accent-1"></div>
            <div class="corner-accent-2"></div>

            <!-- Top Brand Header -->
            <div class="hero-brand">
                <svg class="brand-logo-svg" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Top Ribbon -->
                    <path d="M12 6 H28 L38 16 H22 Z" fill="#34D399"/>
                    <path d="M38 16 L26 28 H12 L24 16 Z" fill="#10B981"/>
                    <!-- Bottom Ribbon -->
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

            <!-- Hero Main Headline -->
            <div class="hero-main">
                <h1 class="hero-heading">
                    Kelola Armada,<br>
                    <span class="green-text">Lebih Efisien</span>
                </h1>
                <p class="hero-desc">
                    Sistem manajemen armada terintegrasi untuk mendukung operasional yang aman, transparan, dan produktif.
                </p>

                <!-- 4 Feature Badges -->
                <div class="features-list">
                    <div class="feature-card">
                        <div class="feature-badge">
                            <i class="fas fa-gas-pump"></i>
                        </div>
                        <div>
                            <div class="feature-title">Pemantauan BBM Real-time</div>
                            <div class="feature-sub">Kontrol konsumsi bahan bakar dengan akurat.</div>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-badge">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <div class="feature-title">Persetujuan Berjenjang</div>
                            <div class="feature-sub">Proses lebih aman dan terstruktur.</div>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-badge">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="feature-title">Monitoring & Laporan</div>
                            <div class="feature-sub">Pantau kondisi armada kapan saja.</div>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-badge">
                            <i class="fas fa-file-excel"></i>
                        </div>
                        <div>
                            <div class="feature-title">Ekspor Data ke Excel</div>
                            <div class="feature-sub">Mudah untuk analisa dan pelaporan.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Footer -->
            <div class="hero-footer">
                <div class="footer-line"></div>
                <div class="footer-tagline">
                    SATU SISTEM &nbsp;|&nbsp; SEMUA ARMADA &nbsp;|&nbsp; KINERJA LEBIH BAIK
                </div>
            </div>
        </div>

        <!-- RIGHT LOGIN FORM SECTION -->
        <div class="form-section">
            <!-- Header Bar -->
            <div class="form-header-bar">
                <span class="header-brand-tag">SEKAWAN Fleet</span>
                <span class="header-accent-line"></span>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-greeting">
                    <h2>Selamat Datang!</h2>
                    <p>Masuk ke akun Anda untuk melanjutkan ke sistem manajemen armada.</p>
                </div>

                @if($errors->any())
                <div class="alert-error">
                    <div class="alert-error-icon">
                        <i class="fas fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <div class="alert-error-title">Gagal Masuk</div>
                        <div class="alert-error-body">
                            @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                    @csrf
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-box">
                            <i class="fas fa-envelope input-icon-left"></i>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="input-field" 
                                placeholder="nama@sekawan.com" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                            >
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-box">
                            <i class="fas fa-lock input-icon-left"></i>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="input-field" 
                                placeholder="Masukkan password" 
                                required
                            >
                            <button type="button" class="input-toggle-eye" id="togglePasswordBtn" title="Lihat/Sembunyikan password">
                                <i class="fas fa-eye-slash" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="form-options-row">
                        <label class="checkbox-container">
                            <input type="checkbox" id="remember" name="remember">
                            <span>Ingat saya</span>
                        </label>
                        <a href="javascript:void(0)" class="forgot-link" onclick="alert('Silakan hubungi IT Administrator untuk reset password.')">Lupa password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit" id="loginBtn">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        <span>Masuk</span>
                    </button>
                </form>

                <!-- Quick Account Selector for effortless testing -->
                <div class="quick-accounts">
                    <div class="quick-accounts-label">
                        <i class="fas fa-bolt"></i> Akun Demo Cepat
                    </div>
                    <div class="account-pills">
                        <button type="button" class="account-pill" onclick="fillAccount('admin@sekawan.com', 'admin123')">
                            <span class="pill-dot"></span> Admin
                        </button>
                        <button type="button" class="account-pill" onclick="fillAccount('hendra@sekawan.com', 'hendra123')">
                            <span class="pill-dot"></span> Approver 1 (Hendra)
                        </button>
                        <button type="button" class="account-pill" onclick="fillAccount('siti@sekawan.com', 'siti123')">
                            <span class="pill-dot"></span> Approver 2 (Siti)
                        </button>
                        <button type="button" class="account-pill" onclick="fillAccount('dewi@sekawan.com', 'dewi123')">
                            <span class="pill-dot"></span> Approver 2 (Dewi)
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="form-footer">
                <div class="copyright-text">© 2026 PT Sekawan Nikel Indonesia</div>
                <div class="sub-copyright-text">Sistem Manajemen Armada Kendaraan</div>
            </div>

            <!-- Watermark 'S' logo in bottom right corner -->
            <svg class="watermark-logo" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M28 14 H64 L82 32 H46 Z" fill="#0f172a" />
                <path d="M82 32 L58 58 H38 L62 32 Z" fill="#0f172a" />
                <path d="M22 48 H44 L64 68 H42 Z" fill="#0f172a" />
                <path d="M64 68 L42 90 H18 L40 68 Z" fill="#0f172a" />
            </svg>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passInput = document.getElementById('password');
        const passIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', function() {
                if (passInput.type === 'password') {
                    passInput.type = 'text';
                    passIcon.classList.remove('fa-eye-slash');
                    passIcon.classList.add('fa-eye');
                } else {
                    passInput.type = 'password';
                    passIcon.classList.remove('fa-eye');
                    passIcon.classList.add('fa-eye-slash');
                }
            });
        }

        // Quick demo filler
        function fillAccount(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        // Submit loading state
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        if (loginForm && loginBtn) {
            loginForm.addEventListener('submit', function() {
                loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Memproses...</span>';
                loginBtn.style.opacity = '0.85';
                loginBtn.style.pointerEvents = 'none';
            });
        }
    </script>
</body>
</html>
