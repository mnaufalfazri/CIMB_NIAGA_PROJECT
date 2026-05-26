import { Head, Link } from '@inertiajs/react';
import { 
    WalletCards, 
    ArrowUpRight, 
    ArrowDownLeft, 
    ArrowRightLeft, 
    History,
    CreditCard,
    ShieldCheck
} from 'lucide-react';
import { BalanceCard, formatRupiah } from '@/components/wealth/balance-card';
import { DashboardProps } from '@/types/wealth';

export default function Dashboard({ 
    account, 
    totalBalance, 
    incomeThisMonth, 
    expenseThisMonth, 
    recentTransactions 
}: DashboardProps) {
    if (!account) {
        return (
            <>
                <Head title="Wealth Dashboard" />
                <div className="flex h-[calc(100vh-8rem)] items-center justify-center p-4">
                    <div className="text-center">
                        <div className="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-bg-surface border border-border">
                            <WalletCards className="h-10 w-10 text-text-disabled" />
                        </div>
                        <h2 className="mt-6 text-2xl font-semibold text-text-primary">Belum Ada Rekening</h2>
                        <p className="mt-2 text-text-secondary max-w-md mx-auto">
                            Anda belum memiliki rekening aktif. Rekening akan dibuat secara otomatis saat registrasi Anda disetujui.
                        </p>
                    </div>
                </div>
            </>
        );
    }

    return (
        <>
            <Head title="Wealth Dashboard" />
            
            <div className="mx-auto max-w-6xl p-4 sm:p-6 lg:p-8">
                {/* Header */}
                <div className="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight text-text-primary">Wealth Dashboard</h1>
                        <p className="mt-1 flex items-center gap-2 text-text-secondary">
                            <ShieldCheck className="h-4 w-4 text-success" />
                            {account.account_type_label} • {account.nomor_rekening}
                        </p>
                    </div>
                    <Link 
                        href="/wealth/mutasi" 
                        className="inline-flex items-center justify-center gap-2 rounded-[8px] bg-primary px-5 py-2.5 text-sm font-semibold text-text-inverse transition-all hover:bg-primary-hover shadow-sm"
                    >
                        <ArrowRightLeft className="h-4 w-4" />
                        Mutasi Rekening
                    </Link>
                </div>

                {/* KPI Cards */}
                <div className="grid gap-6 md:grid-cols-3">
                    <BalanceCard
                        title="Total Saldo"
                        amount={totalBalance}
                        icon={<WalletCards />}
                        variant="primary"
                        subtitle="Saldo aktif saat ini"
                        className="md:col-span-1"
                    />
                    <BalanceCard
                        title="Pemasukan (Bulan Ini)"
                        amount={incomeThisMonth}
                        icon={<ArrowDownLeft />}
                        variant="income"
                        className="md:col-span-1"
                    />
                    <BalanceCard
                        title="Pengeluaran (Bulan Ini)"
                        amount={expenseThisMonth}
                        icon={<ArrowUpRight />}
                        variant="expense"
                        className="md:col-span-1"
                    />
                </div>

                {/* Account Details & Recent Transactions Grid */}
                <div className="mt-8 grid gap-6 lg:grid-cols-3">
                    
                    {/* Account Info Card */}
                    <div className="rounded-[12px] border border-border bg-bg-surface p-6 lg:col-span-1 shadow-sm">
                        <div className="flex items-center gap-3 mb-6">
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-bg-app text-text-primary">
                                <CreditCard className="h-5 w-5" />
                            </div>
                            <h2 className="text-lg font-semibold text-text-primary">Detail Rekening</h2>
                        </div>
                        
                        <div className="space-y-4">
                            <div>
                                <p className="text-xs font-medium text-text-secondary uppercase tracking-wider">Nama Pemilik</p>
                                <p className="mt-1 font-medium text-text-primary">{account.user_name || '-'}</p>
                            </div>
                            <div className="h-px bg-divider" />
                            <div>
                                <p className="text-xs font-medium text-text-secondary uppercase tracking-wider">Nomor Rekening</p>
                                <p className="mt-1 font-mono text-lg text-text-primary tracking-wider">{account.nomor_rekening}</p>
                            </div>
                            <div className="h-px bg-divider" />
                            <div className="flex justify-between">
                                <div>
                                    <p className="text-xs font-medium text-text-secondary uppercase tracking-wider">Status</p>
                                    <span className="mt-1.5 inline-flex items-center rounded-full bg-success-light px-2.5 py-0.5 text-xs font-medium text-success ring-1 ring-success-light">
                                        {account.status_label || 'Aktif'}
                                    </span>
                                </div>
                                <div>
                                    <p className="text-xs font-medium text-text-secondary uppercase tracking-wider">Mata Uang</p>
                                    <p className="mt-1 font-medium text-text-primary">{account.currency}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Recent Transactions List */}
                    <div className="rounded-[12px] border border-border bg-bg-surface lg:col-span-2 overflow-hidden flex flex-col shadow-sm">
                        <div className="flex items-center justify-between border-b border-border p-6">
                            <div className="flex items-center gap-3">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-bg-app text-text-primary">
                                    <History className="h-5 w-5" />
                                </div>
                                <h2 className="text-lg font-semibold text-text-primary">Transaksi Terakhir</h2>
                            </div>
                            <Link href="/wealth/mutasi" className="text-sm font-medium text-primary hover:text-primary-hover">
                                Lihat Semua
                            </Link>
                        </div>
                        
                        <div className="flex-1 overflow-auto p-0">
                            {recentTransactions.length > 0 ? (
                                <ul className="divide-y divide-border">
                                    {recentTransactions.map((tx) => {
                                        const isCredit = tx.direction === 'credit';
                                        const Icon = isCredit ? ArrowDownLeft : ArrowUpRight;
                                        
                                        return (
                                            <li key={tx.id} className="flex items-center justify-between p-4 hover:bg-bg-app transition-colors">
                                                <div className="flex items-center gap-4">
                                                    <div className={`flex h-10 w-10 shrink-0 items-center justify-center rounded-full ${
                                                        isCredit ? 'bg-success-light text-success' : 'bg-error-light text-error'
                                                    }`}>
                                                        <Icon className="h-5 w-5" />
                                                    </div>
                                                    <div>
                                                        <p className="font-medium text-text-primary truncate max-w-[200px] sm:max-w-xs">
                                                            {tx.description || tx.transaction_type}
                                                        </p>
                                                        <p className="text-xs text-text-secondary mt-0.5">
                                                            {new Date(tx.created_at).toLocaleDateString('id-ID', { 
                                                                day: 'numeric', month: 'short', year: 'numeric',
                                                                hour: '2-digit', minute: '2-digit'
                                                            })}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div className="text-right ml-4 shrink-0">
                                                    <p className={`font-semibold tabular-nums ${
                                                        isCredit ? 'text-success' : 'text-error'
                                                    }`}>
                                                        {isCredit ? '+' : '-'} {formatRupiah(Number(tx.amount))}
                                                    </p>
                                                </div>
                                            </li>
                                        );
                                    })}
                                </ul>
                            ) : (
                                <div className="flex h-full min-h-[200px] flex-col items-center justify-center p-6 text-center">
                                    <History className="mb-3 h-8 w-8 text-text-disabled" />
                                    <p className="text-text-secondary">Belum ada transaksi</p>
                                </div>
                            )}
                        </div>
                    </div>

                </div>
            </div>
        </>
    );
}
