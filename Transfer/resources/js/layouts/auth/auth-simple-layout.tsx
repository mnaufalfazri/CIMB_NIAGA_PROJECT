import { Link } from '@inertiajs/react';
import { home } from '@/routes';
import type { AuthLayoutProps } from '@/types';

export default function AuthSimpleLayout({
    children,
    title,
    description,
}: AuthLayoutProps) {
    return (
        <div className="cimb-auth-root">
            {/* Left Panel — CIMB Niaga Branding */}
            <div className="cimb-auth-left">
                <div className="cimb-auth-left-overlay" />

                {/* Decorative shapes */}
                <div className="cimb-deco cimb-deco-1" />
                <div className="cimb-deco cimb-deco-2" />
                <div className="cimb-deco cimb-deco-3" />

                <div className="cimb-auth-left-content">
                    {/* Logo */}
                    <Link href={home()} className="cimb-auth-logo-link">
                        <img
                            src="/images/cimb-logo.png"
                            alt="CIMB Niaga"
                            className="cimb-auth-logo"
                        />
                    </Link>

                    {/* Tagline */}
                    <div className="cimb-auth-tagline">
                        <h2 className="cimb-auth-tagline-title">
                            Solusi Perbankan<br />
                            <span className="cimb-auth-tagline-highlight">Terpercaya</span> untuk Anda
                        </h2>
                        <p className="cimb-auth-tagline-desc">
                            Kelola keuangan Anda dengan mudah, aman, dan nyaman bersama CIMB Niaga.
                        </p>
                    </div>

                    {/* Feature badges */}
                    <div className="cimb-auth-badges">
                        <div className="cimb-badge">
                            <span className="cimb-badge-icon">🔒</span>
                            <span>Keamanan Terjamin</span>
                        </div>
                        <div className="cimb-badge">
                            <span className="cimb-badge-icon">⚡</span>
                            <span>Transaksi Real-time</span>
                        </div>
                        <div className="cimb-badge">
                            <span className="cimb-badge-icon">📊</span>
                            <span>Laporan Lengkap</span>
                        </div>
                    </div>
                </div>

                {/* Footer */}
                <div className="cimb-auth-left-footer">
                    © {new Date().getFullYear()} PT Bank CIMB Niaga Tbk. All rights reserved.
                </div>
            </div>

            {/* Right Panel — Login Form */}
            <div className="cimb-auth-right">
                {/* Mobile logo */}
                <Link href={home()} className="cimb-auth-mobile-logo">
                    <img
                        src="/images/cimb-logo.png"
                        alt="CIMB Niaga"
                        className="cimb-auth-mobile-logo-img"
                    />
                </Link>

                <div className="cimb-auth-form-card">
                    <div className="cimb-auth-form-header">
                        <h1 className="cimb-auth-form-title">{title}</h1>
                        {description && (
                            <p className="cimb-auth-form-desc">{description}</p>
                        )}
                    </div>

                    {children}
                </div>

                <p className="cimb-auth-right-footer">
                    Butuh bantuan?{' '}
                    <a href="tel:14041" className="cimb-auth-contact">
                        Hubungi 14041
                    </a>
                </p>
            </div>

            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

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
                    transform: translateY(-50%);
                    border-radius: 30px;
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

                /* Override button to CIMB red */
                .cimb-auth-form-card button[type="submit"] {
                    background: #7b1818 !important;
                    border-color: #7b1818 !important;
                    color: #fff !important;
                    font-weight: 600;
                    letter-spacing: 0.01em;
                    transition: background 0.2s, transform 0.1s;
                }
                .cimb-auth-form-card button[type="submit"]:hover:not(:disabled) {
                    background: #6b1414 !important;
                    transform: translateY(-1px);
                }
                .cimb-auth-form-card button[type="submit"]:active:not(:disabled) {
                    transform: translateY(0);
                }

                /* Override focus ring color */
                .cimb-auth-form-card input:focus-visible {
                    outline: none;
                    box-shadow: 0 0 0 2px #7b181866;
                    border-color: #7b1818;
                }

                /* Label color */
                .cimb-auth-form-card label {
                    color: #374151;
                    font-weight: 500;
                }

                /* Links */
                .cimb-auth-form-card a {
                    color: #7b1818;
                    font-weight: 500;
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
            `}</style>
        </div>
    );
}
