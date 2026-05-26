import { Head, Link, usePage } from '@inertiajs/react';
import { dashboard, login } from '@/routes';
import { register } from '@/routes';

export default function Welcome() {
    const { auth } = usePage().props;

    return (
        <>
            <Head title="Selamat Datang" />

            <div style={{
                fontFamily: "'Inter', 'Segoe UI', sans-serif",
                minHeight: '100vh',
                background: '#f9f9f9',
                color: '#1a1a1a',
            }}>

                {/* ── NAVBAR ── */}
                <nav style={{
                    position: 'sticky',
                    top: 0,
                    zIndex: 50,
                    background: 'rgba(255,255,255,0.95)',
                    backdropFilter: 'blur(12px)',
                    borderBottom: '1px solid rgba(0,0,0,0.08)',
                    padding: '0 32px',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'space-between',
                    height: '68px',
                }}>
                    <img src="/images/cimb-logo.png" alt="CIMB Niaga" style={{ height: 120, objectFit: 'contain' }} />

                    <div style={{ display: 'flex', gap: 12, alignItems: 'center' }}>
                        {auth.user ? (
                            <Link href={dashboard()} style={styles.btnPrimary}>
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link href={login()} style={styles.btnOutline}>
                                    Log in
                                </Link>
                                <Link href={register()} style={styles.btnPrimary}>
                                    Daftar
                                </Link>
                            </>
                        )}
                    </div>
                </nav>

                {/* ── HERO ── */}
                <section style={{
                    background: 'linear-gradient(135deg, #4a0e0e 0%, #6b1717 45%, #8b1a1a 80%, #7b1818 100%)',
                    padding: '100px 32px 80px',
                    position: 'relative',
                    overflow: 'hidden',
                }}>
                    {/* Decorative circles */}
                    <div style={{ position: 'absolute', width: 600, height: 600, borderRadius: '50%', background: 'rgba(255,255,255,0.03)', top: -200, right: -150, pointerEvents: 'none' }} />
                    <div style={{ position: 'absolute', width: 400, height: 400, borderRadius: '50%', background: 'rgba(255,255,255,0.04)', bottom: -150, left: -80, pointerEvents: 'none' }} />
                    {/* CIMB logo diamond accent */}
                    <div style={{
                        position: 'absolute',
                        right: '8%',
                        top: '50%',
                        transform: 'translateY(-50%) rotate(45deg)',
                        width: 280,
                        height: 280,
                        background: 'rgba(255,255,255,0.04)',
                        borderRadius: 24,
                        pointerEvents: 'none',
                    }} />
                    <div style={{
                        position: 'absolute',
                        right: '12%',
                        top: '50%',
                        transform: 'translateY(-50%) rotate(45deg)',
                        width: 180,
                        height: 180,
                        background: 'rgba(204,0,0,0.15)',
                        borderRadius: 16,
                        pointerEvents: 'none',
                    }} />

                    <div style={{ maxWidth: 720, margin: '0 auto', position: 'relative', zIndex: 1 }}>
                        <div style={{
                            display: 'inline-block',
                            background: 'rgba(255,255,255,0.12)',
                            border: '1px solid rgba(255,255,255,0.2)',
                            borderRadius: 999,
                            padding: '6px 18px',
                            fontSize: 13,
                            color: 'rgba(255,255,255,0.85)',
                            marginBottom: 28,
                            letterSpacing: '0.02em',
                        }}>
                            🏦 Solusi Perbankan Digital Terpercaya
                        </div>

                        <h1 style={{
                            fontSize: 'clamp(2.2rem, 5vw, 3.5rem)',
                            fontWeight: 800,
                            color: '#fff',
                            lineHeight: 1.15,
                            margin: '0 0 24px',
                            letterSpacing: '-0.03em',
                        }}>
                            Kelola Keuangan Anda<br />
                            <span style={{ color: '#ff8080' }}>Lebih Mudah & Aman</span>
                        </h1>

                        <p style={{
                            fontSize: '1.125rem',
                            color: 'rgba(255,255,255,0.72)',
                            maxWidth: 520,
                            lineHeight: 1.7,
                            margin: '0 0 40px',
                        }}>
                            Platform manajemen keuangan berbasis CIMB Niaga yang memudahkan Anda memantau mutasi rekening, kekayaan, dan laporan transaksi secara real-time.
                        </p>

                        <div style={{ display: 'flex', gap: 14, flexWrap: 'wrap' }}>
                            {auth.user ? (
                                <Link href={dashboard()} style={styles.heroBtnPrimary}>
                                    Buka Dashboard →
                                </Link>
                            ) : (
                                <>
                                    <Link href={login()} style={styles.heroBtnPrimary}>
                                        Masuk Sekarang →
                                    </Link>
                                    <Link href={register()} style={styles.heroBtnSecondary}>
                                        Buat Akun
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </section>

                {/* ── STATS BAR ── */}
                <section style={{
                    background: '#fff',
                    borderBottom: '1px solid #f0f0f0',
                    padding: '32px',
                }}>
                    <div style={{
                        maxWidth: 900,
                        margin: '0 auto',
                        display: 'grid',
                        gridTemplateColumns: 'repeat(auto-fit, minmax(160px, 1fr))',
                        gap: 24,
                        textAlign: 'center',
                    }}>
                        {[
                            { label: 'Nasabah Aktif', value: '16+ Juta' },
                            { label: 'Cabang', value: '600+' },
                            { label: 'ATM & CDM', value: '3.800+' },
                            { label: 'Layanan Digital', value: '24/7' },
                        ].map((s) => (
                            <div key={s.label}>
                                <div style={{ fontSize: '1.75rem', fontWeight: 800, color: '#7b1818', letterSpacing: '-0.02em' }}>{s.value}</div>
                                <div style={{ fontSize: '0.85rem', color: '#6b7280', marginTop: 4 }}>{s.label}</div>
                            </div>
                        ))}
                    </div>
                </section>

                {/* ── FEATURES ── */}
                <section style={{ padding: '80px 32px', background: '#f9f9f9' }}>
                    <div style={{ maxWidth: 960, margin: '0 auto' }}>
                        <div style={{ textAlign: 'center', marginBottom: 56 }}>
                            <div style={{ fontSize: '0.8rem', fontWeight: 700, letterSpacing: '0.12em', color: '#7b1818', textTransform: 'uppercase', marginBottom: 12 }}>
                                Fitur Unggulan
                            </div>
                            <h2 style={{ fontSize: '2rem', fontWeight: 800, margin: 0, letterSpacing: '-0.025em' }}>
                                Semua yang Anda Butuhkan
                            </h2>
                        </div>

                        <div style={{
                            display: 'grid',
                            gridTemplateColumns: 'repeat(auto-fit, minmax(260px, 1fr))',
                            gap: 24,
                        }}>
                            {[
                                {
                                    icon: '📊',
                                    title: 'Dashboard Kekayaan',
                                    desc: 'Pantau total aset, investasi, dan portofolio keuangan Anda dalam satu tampilan yang komprehensif.',
                                },
                                {
                                    icon: '💳',
                                    title: 'Mutasi Rekening',
                                    desc: 'Riwayat transaksi lengkap dengan filter canggih — filter berdasarkan tanggal, jenis, atau nominal.',
                                },
                                {
                                    icon: '🔒',
                                    title: 'Keamanan Berlapis',
                                    desc: 'Dilindungi enkripsi tingkat bank dengan autentikasi dua faktor dan passkey untuk keamanan maksimal.',
                                },
                                {
                                    icon: '⚡',
                                    title: 'Real-time Update',
                                    desc: 'Data mutasi dan saldo diperbarui secara real-time sehingga Anda selalu mendapat informasi terkini.',
                                },
                                {
                                    icon: '📱',
                                    title: 'Akses Multi-perangkat',
                                    desc: 'Gunakan dari browser manapun — desktop, tablet, atau smartphone dengan tampilan yang optimal.',
                                },
                                {
                                    icon: '📈',
                                    title: 'Laporan & Analisis',
                                    desc: 'Ekspor laporan transaksi dan analisis tren keuangan untuk perencanaan yang lebih baik.',
                                },
                            ].map((f) => (
                                <div key={f.title} style={styles.featureCard}>
                                    <div style={styles.featureIcon}>{f.icon}</div>
                                    <h3 style={{ fontSize: '1rem', fontWeight: 700, margin: '0 0 8px', color: '#1a1a1a' }}>{f.title}</h3>
                                    <p style={{ fontSize: '0.875rem', color: '#6b7280', margin: 0, lineHeight: 1.6 }}>{f.desc}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* ── CTA ── */}
                <section style={{
                    background: 'linear-gradient(135deg, #6b1717, #9e2020)',
                    padding: '72px 32px',
                    textAlign: 'center',
                }}>
                    <h2 style={{ fontSize: '2rem', fontWeight: 800, color: '#fff', margin: '0 0 16px', letterSpacing: '-0.025em' }}>
                        Siap Memulai?
                    </h2>
                    <p style={{ color: 'rgba(255,255,255,0.72)', fontSize: '1rem', margin: '0 0 36px' }}>
                        Masuk ke akun Anda atau daftar sekarang untuk mulai mengelola keuangan.
                    </p>
                    <div style={{ display: 'flex', gap: 14, justifyContent: 'center', flexWrap: 'wrap' }}>
                        {auth.user ? (
                            <Link href={dashboard()} style={styles.heroBtnPrimary}>
                                Buka Dashboard →
                            </Link>
                        ) : (
                            <>
                                <Link href={login()} style={styles.heroBtnPrimary}>
                                    Log In
                                </Link>
                                <Link href={register()} style={styles.heroBtnSecondary}>
                                    Daftar Gratis
                                </Link>
                            </>
                        )}
                    </div>
                </section>

                {/* ── FOOTER ── */}
                <footer style={{
                    background: '#1a0505',
                    padding: '32px',
                    textAlign: 'center',
                }}>
                    <img src="/images/cimb-logo.png" alt="CIMB Niaga" style={{ height: 70, objectFit: 'contain', filter: 'brightness(0) invert(1)', opacity: 0.7, marginBottom: 16 }} />
                    <p style={{ color: 'rgba(255,255,255,0.35)', fontSize: '0.8rem', margin: 0 }}>
                        © {new Date().getFullYear()} PT Bank CIMB Niaga Tbk. Terdaftar dan diawasi oleh OJK.
                    </p>
                </footer>

                <style>{`
                    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
                    * { box-sizing: border-box; }
                    a { text-decoration: none; }
                `}</style>
            </div>
        </>
    );
}

const styles: Record<string, React.CSSProperties> = {
    btnPrimary: {
        display: 'inline-block',
        background: '#7b1818',
        color: '#fff',
        padding: '8px 20px',
        borderRadius: 8,
        fontSize: '0.875rem',
        fontWeight: 600,
        transition: 'background 0.2s',
    },
    btnOutline: {
        display: 'inline-block',
        border: '1.5px solid #d1d5db',
        color: '#374151',
        padding: '8px 20px',
        borderRadius: 8,
        fontSize: '0.875rem',
        fontWeight: 500,
    },
    heroBtnPrimary: {
        display: 'inline-block',
        background: '#fff',
        color: '#7b1818',
        padding: '14px 28px',
        borderRadius: 10,
        fontSize: '0.9375rem',
        fontWeight: 700,
        letterSpacing: '-0.01em',
        boxShadow: '0 2px 12px rgba(0,0,0,0.15)',
        transition: 'transform 0.15s',
    },
    heroBtnSecondary: {
        display: 'inline-block',
        background: 'rgba(255,255,255,0.12)',
        color: '#fff',
        border: '1.5px solid rgba(255,255,255,0.25)',
        padding: '14px 28px',
        borderRadius: 10,
        fontSize: '0.9375rem',
        fontWeight: 600,
    },
    featureCard: {
        background: '#fff',
        border: '1px solid #e5e7eb',
        borderRadius: 16,
        padding: '28px 24px',
        transition: 'box-shadow 0.2s, transform 0.2s',
    },
    featureIcon: {
        fontSize: '2rem',
        marginBottom: 16,
        display: 'block',
    },
};
