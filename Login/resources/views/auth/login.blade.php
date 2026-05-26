<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CIMB Niaga | Log in</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .cimb-auth-root {
            display: flex;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: #f8f8f8;
        }

        /* ─── LEFT PANEL ─── */
        .cimb-auth-left {
            position: relative;
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 45%;
            min-height: 100vh;
            background: linear-gradient(145deg, #4a0e0e 0%, #6b1717 40%, #8b1a1a 70%, #9e2020 100%);
            overflow: hidden;
            padding: 48px 48px 32px;
        }

        @media (min-width: 1024px) {
            .cimb-auth-left { display: flex; }
        }

        .cimb-auth-left-overlay {
            position: absolute;
            inset: 0;
            background: url('/images/cimb-login-bg.png') center/cover no-repeat;
            opacity: 0.12;
        }

        /* Decorative geometric shapes */
        .cimb-deco {
            position: absolute;
            border-radius: 50%;
            opacity: 0.08;
        }
        .cimb-deco-1 {
            width: 400px; height: 400px;
            background: #ff4444;
            top: -100px; right: -100px;
        }
        .cimb-deco-2 {
            width: 300px; height: 300px;
            background: #cc0000;
            bottom: 100px; left: -80px;
        }
        .cimb-deco-3 {
            width: 200px; height: 200px;
            background: #ff6666;
            top: 50%; right: 40px;
            transform: translateY(-50%) rotate(45deg);
            opacity: 0.06;
        }

        .cimb-auth-left-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 48px;
            flex: 1;
            justify-content: center;
        }

        .cimb-auth-logo-link {
            display: inline-block;
            margin-bottom: 8px;
        }

        .cimb-auth-logo {
            height: 52px;
            width: auto;
            object-fit: contain;
            /* Make white so it shows on dark bg */
            filter: brightness(0) invert(1);
        }

        .cimb-auth-tagline { color: #fff; }

        .cimb-auth-tagline-title {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.25;
            margin: 0 0 16px;
            letter-spacing: -0.02em;
        }

        .cimb-auth-tagline-highlight {
            color: #ff8080;
        }

        .cimb-auth-tagline-desc {
            font-size: 1rem;
            color: rgba(255,255,255,0.72);
            line-height: 1.6;
            margin: 0;
            max-width: 340px;
        }

        /* Feature badges */
        .cimb-auth-badges {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cimb-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 14px 18px;
            color: rgba(255,255,255,0.9);
            font-size: 0.875rem;
            font-weight: 500;
            backdrop-filter: blur(8px);
            transition: background 0.2s;
        }
        .cimb-badge:hover {
            background: rgba(255,255,255,0.14);
        }

        .cimb-badge-icon {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .cimb-auth-left-footer {
            position: relative;
            z-index: 1;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
        }

        /* ─── RIGHT PANEL ─── */
        .cimb-auth-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            background: #ffffff;
            gap: 24px;
        }

        /* Mobile logo — only shown on small screens */
        .cimb-auth-mobile-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }
        .cimb-auth-mobile-logo-img {
            height: 44px;
            width: auto;
            object-fit: contain;
        }
        @media (min-width: 1024px) {
            .cimb-auth-mobile-logo { display: none; }
        }

        /* Form card */
        .cimb-auth-form-card {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .cimb-auth-form-header {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .cimb-auth-form-title {
            font-size: 1.625rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
            letter-spacing: -0.025em;
        }

        .cimb-auth-form-desc {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
            line-height: 1.5;
        }

        /* Label color */
        .cimb-auth-form-card label {
            display: block;
            color: #374151;
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 6px;
        }

        /* Inputs styling */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 16px;
        }

        .form-group-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 10px 14px;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            color: #1f2937;
            font-family: inherit;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            outline: none;
            box-shadow: 0 0 0 2px #7b181866;
            border-color: #7b1818;
        }

        .password-wrapper {
            position: relative;
        }
        .password-wrapper input {
            padding-right: 40px;
        }
        .toggle-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
            padding: 0;
        }
        .toggle-eye:hover { color: #4b5563; }
        .toggle-eye svg { width: 18px; height: 18px; }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }
        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #7b1818;
            cursor: pointer;
            border-radius: 4px;
            border: 1px solid #d1d5db;
        }
        .remember-row label {
            margin: 0;
            font-size: 0.875rem;
            color: #374151;
            cursor: pointer;
            user-select: none;
        }

        /* Override button to CIMB red */
        .cimb-auth-form-card button[type="submit"] {
            width: 100%;
            background: #7b1818 !important;
            border-color: #7b1818 !important;
            color: #fff !important;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            letter-spacing: 0.01em;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .cimb-auth-form-card button[type="submit"]:hover:not(:disabled) {
            background: #6b1414 !important;
            transform: translateY(-1px);
        }
        .cimb-auth-form-card button[type="submit"]:active:not(:disabled) {
            transform: translateY(0);
        }

        /* Links */
        .cimb-auth-form-card a {
            color: #7b1818;
            font-weight: 500;
            text-decoration: none;
        }
        .cimb-auth-form-card a:hover {
            color: #5a1010;
            text-decoration: underline;
        }

        /* Right footer */
        .cimb-auth-right-footer {
            font-size: 0.8125rem;
            color: #9ca3af;
        }
        .cimb-auth-contact {
            color: #7b1818 !important;
            font-weight: 600;
            text-decoration: none;
        }
        .cimb-auth-contact:hover {
            text-decoration: underline;
        }

        /* Divider line above form */
        .cimb-auth-form-card::before {
            content: '';
            display: block;
            height: 4px;
            background: linear-gradient(90deg, #7b1818, #cc0000, #e84444);
            border-radius: 4px;
            margin-bottom: -8px;
        }

        /* Alerts */
        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 16px;
        }
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }
        .field-error {
            font-size: 0.75rem;
            color: #dc2626;
            margin-top: 4px;
        }
    </style>
</head>
<body>

<div class="cimb-auth-root">
    <!-- Left Panel — CIMB Niaga Branding -->
    <div class="cimb-auth-left">
        <div class="cimb-auth-left-overlay"></div>

        <!-- Decorative shapes -->
        <div class="cimb-deco cimb-deco-1"></div>
        <div class="cimb-deco cimb-deco-2"></div>
        <div class="cimb-deco cimb-deco-3"></div>

        <div class="cimb-auth-left-content">
            <!-- Logo -->
            <a href="/" class="cimb-auth-logo-link">
                <img src="/images/cimb-logo.png" alt="CIMB Niaga" class="cimb-auth-logo">
            </a>

            <!-- Tagline -->
            <div class="cimb-auth-tagline">
                <h2 class="cimb-auth-tagline-title">
                    Solusi Perbankan<br>
                    <span class="cimb-auth-tagline-highlight">Terpercaya</span> untuk Anda
                </h2>
                <p class="cimb-auth-tagline-desc">
                    Kelola keuangan Anda dengan mudah, aman, dan nyaman bersama CIMB Niaga.
                </p>
            </div>

            <!-- Feature badges -->
            <div class="cimb-auth-badges">
                <div class="cimb-badge">
                    <span class="cimb-badge-icon">🔒</span>
                    <span>Keamanan Terjamin</span>
                </div>
                <div class="cimb-badge">
                    <span class="cimb-badge-icon">⚡</span>
                    <span>Transaksi Real-time</span>
                </div>
                <div class="cimb-badge">
                    <span class="cimb-badge-icon">📊</span>
                    <span>Laporan Lengkap</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="cimb-auth-left-footer">
            © 2026 PT Bank CIMB Niaga Tbk. All rights reserved.
        </div>
    </div>

    <!-- Right Panel — Login Form -->
    <div class="cimb-auth-right">
        <!-- Mobile logo -->
        <a href="/" class="cimb-auth-mobile-logo">
            <img src="/images/cimb-logo.png" alt="CIMB Niaga" class="cimb-auth-mobile-logo-img">
        </a>

        <div class="cimb-auth-form-card">
            <div class="cimb-auth-form-header">
                <h1 class="cimb-auth-form-title">Log in to your account</h1>
                <p class="cimb-auth-form-desc">Enter your email and password below to log in</p>
            </div>

            @if(session('failed'))
                <div class="alert alert-danger">{{ session('failed') }}</div>
            @endif

            <form action="/login" method="post">
                @csrf

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" placeholder="email@example.com" value="{{ old('email') }}" autocomplete="email" required>
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <div class="form-group-row">
                        <label for="password" style="margin: 0;">Password</label>
                    </div>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Password" autocomplete="current-password" required>
                        <button type="button" class="toggle-eye" onclick="togglePassword('password', this)" title="Tampilkan/sembunyikan password">
                            <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit">Log in</button>
            </form>

            <div style="text-align: center; font-size: 0.875rem; color: #6b7280; margin-top: -12px;">
                Don't have an account? <a href="/register">Sign up</a>
            </div>
        </div>

        <p class="cimb-auth-right-footer">
            Butuh bantuan? <a href="tel:14041" class="cimb-auth-contact">Hubungi 14041</a>
        </p>
    </div>
</div>

<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.querySelector('svg').style.opacity = isHidden ? '0.5' : '1';
    }
</script>

</body>
</html>
