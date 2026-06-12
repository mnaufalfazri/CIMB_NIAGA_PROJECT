<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - CIMB Niaga</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: #f9f9f9;
            color: #1a1a1a;
        }
        a { text-decoration: none; }

        .btn-primary {
            display: inline-block;
            background: #7b1818;
            color: #fff;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: #5c1212; }
        
        .btn-outline {
            display: inline-block;
            border: 1.5px solid #d1d5db;
            color: #374151;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .btn-outline:hover { background: #f3f4f6; }

        .hero-btn-primary {
            display: inline-block;
            background: #fff;
            color: #7b1818;
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 0.9375rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
            transition: transform 0.15s;
        }
        .hero-btn-primary:hover { transform: translateY(-2px); }

        .hero-btn-secondary {
            display: inline-block;
            background: rgba(255,255,255,0.12);
            color: #fff;
            border: 1.5px solid rgba(255,255,255,0.25);
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 0.9375rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .hero-btn-secondary:hover { background: rgba(255,255,255,0.2); }

        .feature-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 28px 24px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .feature-card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transform: translateY(-4px);
        }
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 16px;
            display: block;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav style="position: sticky; top: 0; z-index: 50; background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.08); padding: 0 32px; display: flex; align-items: center; justify-content: space-between; height: 68px;">
        <!-- Wait, the logo image path from TSX was /images/cimb-logo.png. Login service uses http://localhost:8001. -->
        <!-- I will link directly to the image or provide text if missing -->
        <!-- Just in case image is missing from Login service public dir, add fallback -->
        <div style="font-size: 1.25rem; font-weight: 800; color: #7b1818; display: flex; align-items: center;">
            <span style="background: #7b1818; color: white; padding: 4px 8px; border-radius: 4px; margin-right: 8px;">CIMB</span> NIAGA
        </div>

        <div style="display: flex; gap: 12px; align-items: center;">
            @auth
                <a href="/dashboard" class="btn-primary">Dashboard</a>
            @else
                <a href="/login" class="btn-outline">Log in</a>
                <a href="/register" class="btn-primary">Daftar</a>
            @endauth
        </div>
    </nav>

    <!-- HERO -->
    <section style="background: linear-gradient(135deg, #4a0e0e 0%, #6b1717 45%, #8b1a1a 80%, #7b1818 100%); padding: 100px 32px 80px; position: relative; overflow: hidden;">
        <div style="position: absolute; width: 600px; height: 600px; border-radius: 50%; background: rgba(255,255,255,0.03); top: -200px; right: -150px; pointer-events: none;"></div>
        <div style="position: absolute; width: 400px; height: 400px; border-radius: 50%; background: rgba(255,255,255,0.04); bottom: -150px; left: -80px; pointer-events: none;"></div>
        <div style="position: absolute; right: 8%; top: 50%; transform: translateY(-50%) rotate(45deg); width: 280px; height: 280px; background: rgba(255,255,255,0.04); border-radius: 24px; pointer-events: none;"></div>
        <div style="position: absolute; right: 12%; top: 50%; transform: translateY(-50%) rotate(45deg); width: 180px; height: 180px; background: rgba(204,0,0,0.15); border-radius: 16px; pointer-events: none;"></div>

        <div style="max-width: 720px; margin: 0 auto; position: relative; z-index: 1;">
            <div style="display: inline-block; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); border-radius: 999px; padding: 6px 18px; font-size: 13px; color: rgba(255,255,255,0.85); margin-bottom: 28px; letter-spacing: 0.02em;">
                🏦 Solusi Perbankan Digital Terpercaya
            </div>

            <h1 style="font-size: clamp(2.2rem, 5vw, 3.5rem); font-weight: 800; color: #fff; line-height: 1.15; margin: 0 0 24px; letter-spacing: -0.03em;">
                Kelola Keuangan Anda<br />
                <span style="color: #ff8080;">Lebih Mudah & Aman</span>
            </h1>

            <p style="font-size: 1.125rem; color: rgba(255,255,255,0.72); max-width: 520px; line-height: 1.7; margin: 0 0 40px;">
                Platform manajemen keuangan berbasis CIMB Niaga yang memudahkan Anda memantau mutasi rekening, kekayaan, dan laporan transaksi secara real-time.
            </p>

            <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                @auth
                    <a href="/dashboard" class="hero-btn-primary">Buka Dashboard →</a>
                @else
                    <a href="/login" class="hero-btn-primary">Masuk Sekarang →</a>
                    <a href="/register" class="hero-btn-secondary">Buat Akun</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- STATS BAR -->
    <section style="background: #fff; border-bottom: 1px solid #f0f0f0; padding: 32px;">
        <div style="max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 24px; text-align: center;">
            <div>
                <div style="font-size: 1.75rem; font-weight: 800; color: #7b1818; letter-spacing: -0.02em;">16+ Juta</div>
                <div style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Nasabah Aktif</div>
            </div>
            <div>
                <div style="font-size: 1.75rem; font-weight: 800; color: #7b1818; letter-spacing: -0.02em;">600+</div>
                <div style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Cabang</div>
            </div>
            <div>
                <div style="font-size: 1.75rem; font-weight: 800; color: #7b1818; letter-spacing: -0.02em;">3.800+</div>
                <div style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">ATM & CDM</div>
            </div>
            <div>
                <div style="font-size: 1.75rem; font-weight: 800; color: #7b1818; letter-spacing: -0.02em;">24/7</div>
                <div style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Layanan Digital</div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section style="padding: 80px 32px; background: #f9f9f9;">
        <div style="max-width: 960px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 56px;">
                <div style="font-size: 0.8rem; font-weight: 700; letter-spacing: 0.12em; color: #7b1818; text-transform: uppercase; margin-bottom: 12px;">Fitur Unggulan</div>
                <h2 style="font-size: 2rem; font-weight: 800; margin: 0; letter-spacing: -0.025em;">Semua yang Anda Butuhkan</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px;">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 8px; color: #1a1a1a;">Dashboard Kekayaan</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">Pantau total aset, investasi, dan portofolio keuangan Anda dalam satu tampilan yang komprehensif.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💳</div>
                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 8px; color: #1a1a1a;">Mutasi Rekening</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">Riwayat transaksi lengkap dengan filter canggih — filter berdasarkan tanggal, jenis, atau nominal.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 8px; color: #1a1a1a;">Keamanan Berlapis</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">Dilindungi enkripsi tingkat bank dengan autentikasi dua faktor dan passkey untuk keamanan maksimal.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 8px; color: #1a1a1a;">Real-time Update</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">Data mutasi dan saldo diperbarui secara real-time sehingga Anda selalu mendapat informasi terkini.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 8px; color: #1a1a1a;">Akses Multi-perangkat</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">Gunakan dari browser manapun — desktop, tablet, atau smartphone dengan tampilan yang optimal.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 8px; color: #1a1a1a;">Laporan & Analisis</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">Ekspor laporan transaksi dan analisis tren keuangan untuk perencanaan yang lebih baik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section style="background: linear-gradient(135deg, #6b1717, #9e2020); padding: 72px 32px; text-align: center;">
        <h2 style="font-size: 2rem; font-weight: 800; color: #fff; margin: 0 0 16px; letter-spacing: -0.025em;">Siap Memulai?</h2>
        <p style="color: rgba(255,255,255,0.72); font-size: 1rem; margin: 0 0 36px;">Masuk ke akun Anda atau daftar sekarang untuk mulai mengelola keuangan.</p>
        <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
            @auth
                <a href="/dashboard" class="hero-btn-primary">Buka Dashboard →</a>
            @else
                <a href="/login" class="hero-btn-primary">Log In</a>
                <a href="/register" class="hero-btn-secondary">Daftar Gratis</a>
            @endauth
        </div>
    </section>

    <!-- FOOTER -->
    <footer style="background: #1a0505; padding: 32px; text-align: center;">
        <p style="color: rgba(255,255,255,0.35); font-size: 0.8rem; margin: 0;">
            © <?php echo date('Y'); ?> PT Bank CIMB Niaga Tbk. Terdaftar dan diawasi oleh OJK.
        </p>
    </footer>

</body>
</html>
