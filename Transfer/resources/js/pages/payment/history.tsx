import { Head, Link } from '@inertiajs/react';
import AppSidebarLayout from '@/layouts/app/app-sidebar-layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Check, X } from 'lucide-react';
import { formatRupiah } from '@/lib/utils';
import { format } from 'date-fns';

interface HistoryProps {
    payments: {
        data: any[];
        links: any[];
        current_page: number;
        last_page: number;
    };
}

export default function PaymentHistory({ payments }: HistoryProps) {
    return (
        <>
            <Head title="Riwayat Pembayaran" />

            <div className="max-w-5xl mx-auto p-4 md:p-6 lg:p-8 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Data Riwayat Pembayaran Tagihan</CardTitle>
                    </CardHeader>
                    <CardContent className="p-0">
                        <div className="overflow-x-auto">
                            <table className="w-full text-sm text-left">
                                <thead className="text-xs uppercase bg-slate-50 border-b text-muted-foreground">
                                    <tr>
                                        <th className="px-6 py-3 font-medium">Tanggal</th>
                                        <th className="px-6 py-3 font-medium">Biller</th>
                                        <th className="px-6 py-3 font-medium">Nomor Pelanggan</th>
                                        <th className="px-6 py-3 font-medium">Tagihan</th>
                                        <th className="px-6 py-3 font-medium">Biaya Admin</th>
                                        <th className="px-6 py-3 font-medium">Total</th>
                                        <th className="px-6 py-3 font-medium">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {payments.data.length === 0 ? (
                                        <tr>
                                            <td colSpan={7} className="px-6 py-8 text-center text-muted-foreground">
                                                Belum ada riwayat pembayaran tagihan.
                                            </td>
                                        </tr>
                                    ) : (
                                        payments.data.map((p) => (
                                            <tr key={p.id} className="border-b hover:bg-slate-50/50">
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    {format(new Date(p.created_at), 'dd/MM/yyyy HH:mm')}
                                                </td>
                                                <td className="px-6 py-4">
                                                    <Badge variant="outline" className="uppercase">
                                                        {p.biller_category}
                                                    </Badge>
                                                </td>
                                                <td className="px-6 py-4 font-medium">{p.customer_number}</td>
                                                <td className="px-6 py-4">{formatRupiah(p.amount)}</td>
                                                <td className="px-6 py-4">{formatRupiah(p.admin_fee)}</td>
                                                <td className="px-6 py-4 font-bold text-primary">
                                                    {formatRupiah(p.amount + p.admin_fee)}
                                                </td>
                                                <td className="px-6 py-4">
                                                    {p.status === 'completed' ? (
                                                        <Badge className="bg-green-100 text-green-700 hover:bg-green-100 border-green-200">
                                                            <Check className="mr-1 h-3 w-3" /> Completed
                                                        </Badge>
                                                    ) : p.status === 'failed' ? (
                                                        <Badge variant="destructive" className="bg-red-100 text-red-700 hover:bg-red-100 border-red-200">
                                                            <X className="mr-1 h-3 w-3" /> Failed
                                                        </Badge>
                                                    ) : (
                                                        <Badge variant="outline">{p.status}</Badge>
                                                    )}
                                                </td>
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </table>
                        </div>
                        
                        {/* Pagination Links */}
                        {payments.links && payments.links.length > 3 && (
                            <div className="flex items-center justify-center space-x-1 p-4 border-t bg-slate-50/50">
                                {payments.links.map((link, index) => (
                                    <Link
                                        key={index}
                                        href={link.url || '#'}
                                        className={`px-3 py-1 rounded-md border text-sm ${
                                            link.active
                                                ? 'bg-primary text-primary-foreground border-primary'
                                                : 'bg-background hover:bg-muted'
                                        } ${!link.url ? 'opacity-50 cursor-not-allowed pointer-events-none' : ''}`}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </>
    );
}




PaymentHistory.layout = (page: React.ReactNode) => (
    <AppSidebarLayout breadcrumbs={[{ title: 'Riwayat Pembayaran', href: '/payment/history' }]}>
        {page}
    </AppSidebarLayout>
);
