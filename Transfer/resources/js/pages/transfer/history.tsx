import { Head, Link, useForm, usePage } from '@inertiajs/react';
import AppSidebarLayout from '@/layouts/app/app-sidebar-layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Filter, Check, X } from 'lucide-react';
import { formatRupiah } from '@/lib/utils';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';

interface HistoryProps {
    transfers: {
        data: any[];
        links: any[];
        current_page: number;
        last_page: number;
    };
}

export default function TransferHistory({ transfers }: HistoryProps) {
    const { url } = usePage();
    const queryParams = new URLSearchParams(url.split('?')[1]);
    
    const { data, setData, get } = useForm({
        type: queryParams.get('type') || 'all',
        status: queryParams.get('status') || 'all',
    });

    const submitFilter = (e: React.FormEvent) => {
        e.preventDefault();
        get('/transfer/history');
    };

    return (
        <>
            <Head title="Riwayat Transfer" />

            <div className="max-w-5xl mx-auto p-4 md:p-6 lg:p-8 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Filter Riwayat</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={submitFilter} className="flex flex-col sm:flex-row gap-4 items-end">
                            <div className="space-y-2 w-full sm:w-48">
                                <label className="text-sm font-medium">Tipe</label>
                                <Select value={data.type} onValueChange={(val) => setData('type', val)}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Semua Tipe" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="all">Semua Tipe</SelectItem>
                                        <SelectItem value="intra_bank">Intra-bank</SelectItem>
                                        <SelectItem value="inter_bank_bifast">Inter-bank BIFAST</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            <div className="space-y-2 w-full sm:w-48">
                                <label className="text-sm font-medium">Status</label>
                                <Select value={data.status} onValueChange={(val) => setData('status', val)}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Semua Status" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="all">Semua Status</SelectItem>
                                        <SelectItem value="completed">Completed</SelectItem>
                                        <SelectItem value="failed">Failed</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            <Button type="submit" className="w-full sm:w-auto">
                                <Filter className="mr-2 h-4 w-4" /> Filter
                            </Button>
                        </form>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Data Riwayat Transfer</CardTitle>
                    </CardHeader>
                    <CardContent className="p-0">
                        <div className="overflow-x-auto">
                            <table className="w-full text-sm text-left">
                                <thead className="text-xs uppercase bg-slate-50 border-b text-muted-foreground">
                                    <tr>
                                        <th className="px-6 py-3 font-medium">Tanggal</th>
                                        <th className="px-6 py-3 font-medium">Tujuan</th>
                                        <th className="px-6 py-3 font-medium">Nama Penerima</th>
                                        <th className="px-6 py-3 font-medium">Nominal</th>
                                        <th className="px-6 py-3 font-medium">Tipe</th>
                                        <th className="px-6 py-3 font-medium">Biaya</th>
                                        <th className="px-6 py-3 font-medium">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {transfers.data.length === 0 ? (
                                        <tr>
                                            <td colSpan={7} className="px-6 py-8 text-center text-muted-foreground">
                                                Belum ada riwayat transfer.
                                            </td>
                                        </tr>
                                    ) : (
                                        transfers.data.map((t) => (
                                            <tr key={t.id} className="border-b hover:bg-slate-50/50">
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    {format(new Date(t.created_at), 'dd/MM/yyyy HH:mm')}
                                                </td>
                                                <td className="px-6 py-4">{t.receiver_nomor_rekening}</td>
                                                <td className="px-6 py-4 font-medium">{t.receiver_name}</td>
                                                <td className="px-6 py-4">{formatRupiah(t.amount)}</td>
                                                <td className="px-6 py-4">
                                                    <Badge variant={t.transfer_type === 'intra_bank' ? 'default' : 'secondary'}>
                                                        {t.transfer_type === 'intra_bank' ? 'Intra-bank' : 'Inter-bank'}
                                                    </Badge>
                                                </td>
                                                <td className="px-6 py-4">{formatRupiah(t.fee)}</td>
                                                <td className="px-6 py-4">
                                                    {t.status === 'completed' ? (
                                                        <Badge className="bg-green-100 text-green-700 hover:bg-green-100 border-green-200">
                                                            <Check className="mr-1 h-3 w-3" /> Completed
                                                        </Badge>
                                                    ) : t.status === 'failed' ? (
                                                        <Badge variant="destructive" className="bg-red-100 text-red-700 hover:bg-red-100 border-red-200">
                                                            <X className="mr-1 h-3 w-3" /> Failed
                                                        </Badge>
                                                    ) : (
                                                        <Badge variant="outline">{t.status}</Badge>
                                                    )}
                                                </td>
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </table>
                        </div>
                        
                        {/* Pagination Links */}
                        {transfers.links && transfers.links.length > 3 && (
                            <div className="flex items-center justify-center space-x-1 p-4 border-t bg-slate-50/50">
                                {transfers.links.map((link, index) => (
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




TransferHistory.layout = (page: React.ReactNode) => (
    <AppSidebarLayout breadcrumbs={[{ title: 'Riwayat Transfer', href: '/transfer/history' }]}>
        {page}
    </AppSidebarLayout>
);
