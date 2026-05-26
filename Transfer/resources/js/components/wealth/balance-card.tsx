import { useEffect, useRef, useState } from 'react';
import { cn } from '@/lib/utils';

interface BalanceCardProps {
    title: string;
    amount: number;
    currency?: string;
    variant?: 'primary' | 'income' | 'expense';
    icon: React.ReactNode;
    subtitle?: string;
    className?: string;
}

function formatRupiah(amount: number): string {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount);
}

function useCountUp(target: number, duration = 1200): number {
    const [count, setCount] = useState(0);
    const startRef = useRef<number | null>(null);
    const frameRef = useRef<number>(0);

    useEffect(() => {
        const animate = (timestamp: number) => {
            if (!startRef.current) startRef.current = timestamp;
            const elapsed = timestamp - startRef.current;
            const progress = Math.min(elapsed / duration, 1);
            // Ease-out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            setCount(Math.round(target * eased));
            if (progress < 1) {
                frameRef.current = requestAnimationFrame(animate);
            }
        };
        frameRef.current = requestAnimationFrame(animate);
        return () => cancelAnimationFrame(frameRef.current);
    }, [target, duration]);

    return count;
}

const variantStyles = {
    primary: {
        card: 'bg-primary border-primary-hover',
        title: 'text-primary-light',
        amount: 'text-text-inverse',
        iconBg: 'bg-primary-hover text-text-inverse',
        glow: 'shadow-lg shadow-primary/20',
    },
    income: {
        card: 'bg-bg-surface border-border',
        title: 'text-text-secondary',
        amount: 'text-success',
        iconBg: 'bg-success-light text-success',
        glow: 'shadow-sm',
    },
    expense: {
        card: 'bg-bg-surface border-border',
        title: 'text-text-secondary',
        amount: 'text-error',
        iconBg: 'bg-error-light text-error',
        glow: 'shadow-sm',
    },
};

export function BalanceCard({
    title,
    amount,
    variant = 'primary',
    icon,
    subtitle,
    className,
}: BalanceCardProps) {
    const animatedAmount = useCountUp(amount);
    const styles = variantStyles[variant];

    return (
        <div
            className={cn(
                'relative overflow-hidden rounded-2xl border p-6 transition-all duration-300 hover:-translate-y-1',
                styles.card,
                styles.glow,
                className,
            )}
        >
            {/* Background shimmer */}
            <div className="pointer-events-none absolute inset-0 bg-gradient-to-tr from-white/[0.02] to-transparent" />

            <div className="relative flex items-start justify-between gap-4">
                <div className="flex-1 min-w-0">
                    <p className={cn('text-sm font-medium tracking-wide uppercase', styles.title)}>
                        {title}
                    </p>
                    <p className={cn('mt-2 text-2xl font-bold tabular-nums leading-tight truncate', styles.amount)}>
                        {formatRupiah(animatedAmount)}
                    </p>
                    {subtitle && (
                        <p className="mt-1 text-xs opacity-80">{subtitle}</p>
                    )}
                </div>
                <div className={cn('flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-xl', styles.iconBg)}>
                    {icon}
                </div>
            </div>
        </div>
    );
}

export { formatRupiah };
