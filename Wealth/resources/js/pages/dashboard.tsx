import { Head, Link, usePage } from '@inertiajs/react';
import { dashboard } from '@/routes';
import { 
    WalletCards, 
    ArrowRightLeft, 
    Send, 
    PlusCircle, 
    CreditCard, 
    PieChart, 
    ShieldCheck, 
    Smartphone,
    Gift
} from 'lucide-react';


export default function Dashboard() {
    const { auth } = usePage().props;
    const user = auth.user;

    const quickActions = [
        {
            title: 'Wealth Dashboard',
            description: 'Lihat ringkasan aset dan portfolio Anda.',
            icon: WalletCards,
            href: '/wealth/dashboard',
            color: 'text-primary',
            bg: 'bg-primary-light',
        },
        {
            title: 'Mutasi Rekening',
            description: 'Pantau arus kas dan riwayat transaksi.',
            icon: ArrowRightLeft,
            href: '/wealth/mutasi',
            color: 'text-success',
            bg: 'bg-success-light',
        },
        {
            title: 'Transfer Dana',
            description: 'Kirim uang ke sesama atau bank lain.',
            icon: Send,
            href: '#',
            color: 'text-info',
            bg: 'bg-info-light',
        },
        {
            title: 'Top Up e-Wallet',
            description: 'Isi saldo GoPay, OVO, Dana, dll.',
            icon: PlusCircle,
            href: '#',
            color: 'text-warning',
            bg: 'bg-warning-light',
        },
    ];

    return (
        <>
            <Head title="Beranda" />
            <div className="flex h-full flex-1 flex-col gap-8 overflow-x-auto p-4 sm:p-6 lg:p-8 max-w-7xl w-full">
                {/* Hero Section */}
                <div className="relative overflow-hidden rounded-[20px] bg-gradient-to-r from-primary to-[#8A1116] p-8 sm:p-12 shadow-lg">
                    {/* Decorative Background Elements */}
                    <div className="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
                    <div className="absolute -bottom-32 left-10 h-64 w-64 rounded-full bg-black/10 blur-3xl pointer-events-none"></div>
                    
                    <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div className="text-white">
                            <h1 className="text-3xl sm:text-4xl font-bold tracking-tight">
                                Selamat datang, {user?.name || 'Nasabah'}!
                            </h1>
                            <p className="mt-3 text-lg text-primary-light max-w-xl leading-relaxed">
                                Kelola keuangan Anda dengan mudah, aman, dan nyaman bersama layanan perbankan digital kami.
                            </p>
                        </div>
                        <div className="shrink-0">
                            <span className="inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-2.5 text-sm font-medium text-white backdrop-blur-sm ring-1 ring-white/30 shadow-sm">
                                <ShieldCheck className="h-5 w-5 text-success-light" />
                                Terlindungi & Aman
                            </span>
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div>
                    <h2 className="text-2xl font-bold text-text-primary mb-6">Akses Cepat</h2>
                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        {quickActions.map((action, index) => (
                            <Link
                                key={index}
                                href={action.href}
                                className="group relative overflow-hidden rounded-[16px] border border-border bg-bg-surface p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-primary/30"
                            >
                                <div className={`mb-5 inline-flex h-14 w-14 items-center justify-center rounded-[12px] ${action.bg} ${action.color} transition-transform duration-300 group-hover:scale-110`}>
                                    <action.icon className="h-7 w-7" />
                                </div>
                                <h3 className="text-lg font-bold text-text-primary mb-2">
                                    {action.title}
                                </h3>
                                <p className="text-sm text-text-secondary leading-relaxed">
                                    {action.description}
                                </p>
                            </Link>
                        ))}
                    </div>
                </div>

                {/* Promo / Summary Section */}
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    {/* Feature 1 */}
                    <div className="rounded-[16px] border border-border bg-bg-surface p-6 shadow-sm flex flex-col">
                        <div className="flex items-center gap-3 mb-6">
                            <div className="flex h-10 w-10 items-center justify-center rounded-[10px] bg-bg-app text-text-primary">
                                <PieChart className="h-5 w-5" />
                            </div>
                            <h2 className="text-lg font-bold text-text-primary">Ringkasan Portofolio</h2>
                        </div>
                        <div className="flex flex-1 items-center justify-center py-6 bg-bg-app rounded-[12px]">
                            <div className="text-center px-6">
                                <p className="text-text-secondary mb-4 text-sm">Cek status aset dan grafik pengeluaran bulanan Anda secara visual.</p>
                                <Link href="/wealth/dashboard" className="inline-flex w-full items-center justify-center rounded-[8px] bg-bg-surface border border-border shadow-sm px-4 py-2.5 text-sm font-semibold text-text-primary hover:bg-primary-light hover:text-primary transition-colors">
                                    Buka Wealth Dashboard
                                </Link>
                            </div>
                        </div>
                    </div>

                    {/* Feature 2 */}
                    <div className="relative overflow-hidden rounded-[16px] border border-border bg-bg-surface p-6 shadow-sm lg:col-span-2">
                        <div className="absolute right-0 top-0 h-full w-2/3 bg-gradient-to-l from-primary-light/50 to-transparent pointer-events-none" />
                        <div className="flex items-center gap-3 mb-6 relative z-10">
                            <div className="flex h-10 w-10 items-center justify-center rounded-[10px] bg-primary/10 text-primary">
                                <Gift className="h-5 w-5" />
                            </div>
                            <h2 className="text-lg font-bold text-text-primary">Penawaran Spesial</h2>
                        </div>
                        <div className="relative z-10 flex flex-col sm:flex-row gap-6 items-start sm:items-center justify-between">
                            <div className="max-w-md">
                                <h3 className="text-2xl font-bold text-primary mb-2">Cashback hingga Rp500.000!</h3>
                                <p className="text-text-secondary text-sm mb-4 leading-relaxed">
                                    Nikmati promo eksklusif untuk setiap pembukaan kartu kredit baru dan transaksi pertama Anda bulan ini menggunakan QRIS. S&K Berlaku.
                                </p>
                                <button className="inline-flex items-center text-sm font-bold text-primary hover:text-primary-hover group">
                                    Lihat Semua Promo 
                                    <span className="ml-1 inline-block transition-transform group-hover:translate-x-1">→</span>
                                </button>
                            </div>
                            <div className="hidden sm:flex shrink-0 h-32 w-32 items-center justify-center rounded-full bg-white shadow-lg border border-primary/10 rotate-12">
                                <Smartphone className="h-14 w-14 text-primary" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Beranda',
            href: dashboard(),
        },
    ],
};
