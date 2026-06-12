import { router } from '@inertiajs/react';
import { Calendar, FilterX, Search } from 'lucide-react';
import { FormEvent, useEffect, useState } from 'react';
import { DIRECTION_LABELS, TRANSACTION_TYPE_LABELS } from '@/types/wealth';
import { cn } from '@/lib/utils';

interface MutasiFilterProps {
    filters: {
        date_from?: string;
        date_to?: string;
        transaction_type?: string;
        direction?: string;
    };
    className?: string;
}

export function MutasiFilter({ filters, className }: MutasiFilterProps) {
    const [dateFrom, setDateFrom] = useState(filters.date_from || '');
    const [dateTo, setDateTo] = useState(filters.date_to || '');
    const [type, setType] = useState(filters.transaction_type || 'all');
    const [direction, setDirection] = useState(filters.direction || 'all');
    const [isApplying, setIsApplying] = useState(false);

    // Effect to reset isApplying and sync local state when filters change in props
    useEffect(() => {
        setIsApplying(false);
        setDateFrom(filters.date_from || '');
        setDateTo(filters.date_to || '');
        setType(filters.transaction_type || 'all');
        setDirection(filters.direction || 'all');
    }, [filters]);

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        setIsApplying(true);

        const params: Record<string, string> = {};
        if (dateFrom) params.date_from = dateFrom;
        if (dateTo) params.date_to = dateTo;
        if (type && type !== 'all') params.transaction_type = type;
        if (direction && direction !== 'all') params.direction = direction;

        router.get('/wealth/mutasi', params, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleReset = () => {
        setDateFrom('');
        setDateTo('');
        setType('all');
        setDirection('all');
        
        setIsApplying(true);
        router.get('/wealth/mutasi', {}, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const hasActiveFilters = dateFrom || dateTo || type !== 'all' || direction !== 'all';

    return (
        <form onSubmit={handleSubmit} className={cn('flex flex-col gap-4 sm:flex-row sm:items-end', className)}>
            {/* Date Range */}
            <div className="flex-1 space-y-2">
                <label className="text-xs font-medium text-text-secondary">Periode</label>
                <div className="flex items-center gap-2">
                    <div className="relative flex-1">
                        <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <Calendar className="h-4 w-4 text-text-disabled" />
                        </div>
                        <input
                            type="date"
                            value={dateFrom}
                            onChange={(e) => setDateFrom(e.target.value)}
                            onClick={(e) => e.currentTarget.showPicker && e.currentTarget.showPicker()}
                            className="block w-full rounded-[8px] border border-border bg-bg-app pl-10 py-2 text-sm text-text-primary focus:border-primary focus:ring-primary"
                        />
                    </div>
                    <span className="text-text-disabled">-</span>
                    <div className="relative flex-1">
                        <input
                            type="date"
                            value={dateTo}
                            onChange={(e) => setDateTo(e.target.value)}
                            onClick={(e) => e.currentTarget.showPicker && e.currentTarget.showPicker()}
                            className="block w-full rounded-[8px] border border-border bg-bg-app px-3 py-2 text-sm text-text-primary focus:border-primary focus:ring-primary"
                        />
                    </div>
                </div>
            </div>

            {/* Transaction Type */}
            <div className="sm:w-48 space-y-2">
                <label className="text-xs font-medium text-text-secondary">Tipe Transaksi</label>
                <select
                    value={type}
                    onChange={(e) => setType(e.target.value)}
                    className="block w-full rounded-[8px] border border-border bg-bg-app px-3 py-2 text-sm text-text-primary focus:border-primary focus:ring-primary"
                >
                    {Object.entries(TRANSACTION_TYPE_LABELS).map(([key, label]) => (
                        <option key={key} value={key}>
                            {label}
                        </option>
                    ))}
                </select>
            </div>

            {/* Direction */}
            <div className="sm:w-40 space-y-2">
                <label className="text-xs font-medium text-text-secondary">Arah</label>
                <select
                    value={direction}
                    onChange={(e) => setDirection(e.target.value)}
                    className="block w-full rounded-[8px] border border-border bg-bg-app px-3 py-2 text-sm text-text-primary focus:border-primary focus:ring-primary"
                >
                    {Object.entries(DIRECTION_LABELS).map(([key, label]) => (
                        <option key={key} value={key}>
                            {label}
                        </option>
                    ))}
                </select>
            </div>

            {/* Actions */}
            <div className="flex gap-2 pt-2 sm:pt-0">
                <button
                    type="submit"
                    disabled={isApplying}
                    className="flex h-[38px] items-center justify-center gap-2 rounded-[8px] bg-primary px-4 text-sm font-medium text-text-inverse transition-colors hover:bg-primary-hover disabled:opacity-70 shadow-sm"
                >
                    <Search className="h-4 w-4" />
                    <span>Filter</span>
                </button>
                
                {hasActiveFilters && (
                    <button
                        type="button"
                        onClick={handleReset}
                        disabled={isApplying}
                        className="flex h-[38px] w-[38px] items-center justify-center rounded-[8px] border border-border bg-bg-surface text-text-primary transition-colors hover:bg-bg-app"
                        title="Reset Filter"
                    >
                        <FilterX className="h-4 w-4" />
                    </button>
                )}
            </div>
        </form>
    );
}
