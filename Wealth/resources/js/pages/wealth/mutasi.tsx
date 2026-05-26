import { Head, Link } from '@inertiajs/react';
import { 
    ArrowLeft, 
    Download, 
    FileText,
    ChevronLeft,
    ChevronRight,
    ChevronsLeft,
    ChevronsRight
} from 'lucide-react';
import { MutasiProps } from '@/types/wealth';
import { TransactionTable } from '@/components/wealth/transaction-table';
import { MutasiFilter } from '@/components/wealth/mutasi-filter';
import { cn } from '@/lib/utils';

export default function Mutasi({ account, transactions, filters }: MutasiProps) {
    if (!account || !transactions) {
        return (
            <>
                <Head title="Mutasi Rekening" />
                <div className="flex h-[calc(100vh-8rem)] items-center justify-center p-4">
                    <div className="text-center">
                        <FileText className="mx-auto h-12 w-12 text-text-disabled" />
                        <h2 className="mt-4 text-xl font-semibold text-text-primary">Data Tidak Tersedia</h2>
                        <p className="mt-2 text-text-secondary">Silakan periksa kembali nanti.</p>
                        <Link href="/wealth/dashboard" className="mt-6 inline-flex items-center text-sm font-medium text-primary hover:text-primary-hover">
                            <ArrowLeft className="mr-2 h-4 w-4" />
                            Kembali ke Dashboard
                        </Link>
                    </div>
                </div>
            </>
        );
    }

    const { data, current_page, last_page, total, from, to, links } = transactions;

    return (
        <>
            <Head title="Mutasi Rekening" />
            
            <div className="mx-auto max-w-7xl p-4 sm:p-6 lg:p-8">
                {/* Header Section */}
                <div className="mb-8">
                    <Link href="/wealth/dashboard" className="inline-flex items-center text-sm font-medium text-text-secondary hover:text-text-primary mb-4 transition-colors">
                        <ArrowLeft className="mr-1.5 h-4 w-4" />
                        Dashboard
                    </Link>
                    
                    <div className="flex flex-col gap-4 sm:flex-row sm:items-end justify-between">
                        <div>
                            <h1 className="text-3xl font-bold tracking-tight text-text-primary">Mutasi Rekening</h1>
                            <p className="mt-1 text-text-secondary">
                                {account.nomor_rekening} • {account.account_type_label}
                            </p>
                        </div>
                        
                        <button className="inline-flex items-center justify-center gap-2 rounded-xl border border-border bg-bg-surface px-4 py-2.5 text-sm font-medium text-text-primary transition-colors hover:bg-bg-app shadow-sm">
                            <Download className="h-4 w-4" />
                            Unduh Mutasi
                        </button>
                    </div>
                </div>

                {/* Main Content Area */}
                <div className="rounded-[12px] border border-border bg-bg-surface overflow-hidden shadow-sm">
                    
                    {/* Filters */}
                    <div className="border-b border-border bg-bg-surface p-5">
                        <MutasiFilter filters={filters} />
                    </div>

                    {/* Table */}
                    <TransactionTable transactions={data} />

                    {/* Pagination */}
                    {total > 0 && (
                        <div className="flex flex-col items-center justify-between gap-4 border-t border-border bg-bg-surface px-6 py-4 sm:flex-row">
                            <div className="text-sm text-text-secondary">
                                Menampilkan <span className="font-medium text-text-primary">{from}</span> hingga <span className="font-medium text-text-primary">{to}</span> dari <span className="font-medium text-text-primary">{total}</span> transaksi
                            </div>
                            
                            <div className="flex items-center gap-1">
                                {/* Using Inertia Links for pagination ensures smooth SPA transitions */}
                                {links.map((link, i) => {
                                    // Process Laravel's pagination link labels
                                    let label = link.label;
                                    let icon = null;
                                    
                                    if (label.includes('Previous')) {
                                        icon = <ChevronLeft className="h-4 w-4" />;
                                        label = '';
                                    } else if (label.includes('Next')) {
                                        icon = <ChevronRight className="h-4 w-4" />;
                                        label = '';
                                    }

                                    return link.url ? (
                                        <Link
                                            key={i}
                                            href={link.url}
                                            preserveScroll
                                            className={cn(
                                                "relative inline-flex min-w-[2.25rem] items-center justify-center rounded-lg px-2 py-1.5 text-sm font-medium transition-colors",
                                                link.active 
                                                    ? "bg-primary text-text-inverse shadow-sm" 
                                                    : "text-text-secondary hover:bg-bg-app hover:text-text-primary",
                                                !label && "px-1.5"
                                            )}
                                            dangerouslySetInnerHTML={!icon ? { __html: label } : undefined}
                                        >
                                            {icon}
                                        </Link>
                                    ) : (
                                        <span
                                            key={i}
                                            className={cn(
                                                "relative inline-flex min-w-[2.25rem] items-center justify-center rounded-lg px-2 py-1.5 text-sm font-medium text-text-disabled",
                                                !label && "px-1.5"
                                            )}
                                        >
                                            {icon || <span dangerouslySetInnerHTML={{ __html: label }} />}
                                        </span>
                                    );
                                })}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
