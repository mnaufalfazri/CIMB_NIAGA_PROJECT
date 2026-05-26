import { cn } from '@/lib/utils';
import type { Transaction } from '@/types/wealth';
import { formatRupiah } from '@/components/wealth/balance-card';
import {
    ArrowDownLeft,
    ArrowUpRight,
    CheckCircle2,
    Clock,
    XCircle,
    RotateCcw,
} from 'lucide-react';

interface TransactionTableProps {
    transactions: Transaction[];
    className?: string;
}

const directionConfig = {
    credit: {
        label: 'Masuk',
        badge: 'bg-success-light text-success ring-1 ring-success-light',
        icon: ArrowDownLeft,
        amountClass: 'text-success',
        prefix: '+',
    },
    debit: {
        label: 'Keluar',
        badge: 'bg-error-light text-error ring-1 ring-error-light',
        icon: ArrowUpRight,
        amountClass: 'text-error',
        prefix: '-',
    },
};

const statusConfig = {
    success: {
        icon: CheckCircle2,
        className: 'text-success',
        label: 'Sukses',
    },
    pending: {
        icon: Clock,
        className: 'text-warning',
        label: 'Pending',
    },
    failed: {
        icon: XCircle,
        className: 'text-error',
        label: 'Gagal',
    },
    reversed: {
        icon: RotateCcw,
        className: 'text-text-secondary',
        label: 'Reversed',
    },
};

const typeLabels: Record<string, string> = {
    transfer: 'Transfer',
    payment: 'Pembayaran',
    topup: 'Top Up',
    withdraw: 'Penarikan',
    deposit: 'Setoran',
    admin_fee: 'Biaya Admin',
    initial: 'Saldo Awal',
    refund: 'Refund',
    reversal: 'Reversal',
};

function formatDate(dateStr: string): { date: string; time: string } {
    const d = new Date(dateStr);
    return {
        date: d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }),
        time: d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
    };
}

export function TransactionTable({ transactions, className }: TransactionTableProps) {
    if (transactions.length === 0) {
        return (
            <div className={cn('flex flex-col items-center justify-center py-16 text-center', className)}>
                <div className="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-bg-app border border-border">
                    <ArrowDownLeft className="h-8 w-8 text-text-disabled" />
                </div>
                <p className="text-lg font-medium text-text-primary">Tidak ada transaksi</p>
                <p className="mt-1 text-sm text-text-secondary">Belum ada riwayat transaksi untuk filter yang dipilih.</p>
            </div>
        );
    }

    return (
        <div className={cn('w-full overflow-x-auto', className)}>
            <table className="w-full border-collapse text-sm">
                <thead>
                    <tr className="border-b border-border">
                        <th className="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-text-secondary">
                            Tanggal
                        </th>
                        <th className="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-text-secondary">
                            Keterangan
                        </th>
                        <th className="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-text-secondary">
                            Tipe
                        </th>
                        <th className="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-text-secondary">
                            Nominal
                        </th>
                        <th className="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-text-secondary">
                            Saldo Setelah
                        </th>
                        <th className="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-text-secondary">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody className="divide-y divide-border">
                    {transactions.map((tx) => {
                        const dir = directionConfig[tx.direction];
                        const DirIcon = dir.icon;
                        const status = statusConfig[tx.status];
                        const StatusIcon = status.icon;
                        const { date, time } = formatDate(tx.created_at);

                        return (
                            <tr
                                key={tx.id}
                                className="group transition-colors duration-150 hover:bg-bg-app"
                            >
                                {/* Date */}
                                <td className="whitespace-nowrap px-4 py-3.5">
                                    <div className="text-text-primary">{date}</div>
                                    <div className="text-xs text-text-secondary">{time}</div>
                                </td>

                                {/* Description */}
                                <td className="px-4 py-3.5">
                                    <div className="flex items-center gap-2">
                                        <div className={cn('flex h-7 w-7 shrink-0 items-center justify-center rounded-full', dir.badge)}>
                                            <DirIcon className="h-3.5 w-3.5" />
                                        </div>
                                        <div>
                                            <p className="max-w-[220px] truncate font-medium text-text-primary">
                                                {tx.description ?? typeLabels[tx.transaction_type] ?? tx.transaction_type}
                                            </p>
                                            {tx.counterparty_name && (
                                                <p className="text-xs text-text-secondary">{tx.counterparty_name}</p>
                                            )}
                                        </div>
                                    </div>
                                </td>

                                {/* Type badge */}
                                <td className="px-4 py-3.5 text-center">
                                    <span className="inline-flex items-center rounded-md bg-bg-surface px-2 py-0.5 text-xs font-medium text-text-secondary ring-1 ring-border">
                                        {typeLabels[tx.transaction_type] ?? tx.transaction_type}
                                    </span>
                                </td>

                                {/* Amount */}
                                <td className={cn('whitespace-nowrap px-4 py-3.5 text-right font-semibold tabular-nums', dir.amountClass)}>
                                    {dir.prefix} {formatRupiah(Number(tx.amount))}
                                </td>

                                {/* Balance After */}
                                <td className="whitespace-nowrap px-4 py-3.5 text-right font-medium tabular-nums text-text-primary">
                                    {formatRupiah(Number(tx.balance_after))}
                                </td>

                                {/* Status */}
                                <td className="px-4 py-3.5 text-center">
                                    <div className="flex items-center justify-center gap-1.5">
                                        <StatusIcon className={cn('h-4 w-4', status.className)} />
                                        <span className={cn('text-xs font-medium', status.className)}>
                                            {status.label}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        );
                    })}
                </tbody>
            </table>
        </div>
    );
}
