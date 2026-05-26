import { Head, Link } from '@inertiajs/react';
import AppSidebarLayout from '@/layouts/app/app-sidebar-layout';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { CheckCircle2, XCircle, Plus, List } from 'lucide-react';
import { formatRupiah } from '@/lib/utils';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';

interface ReceiptProps {
    transfer: {
        id: number;
        reference_id: string;
        created_at: string;
        transfer_type: string;
        receiver_nomor_rekening: string;
        receiver_name: string;
        amount: number;
        fee: number;
        status: string;
        description: string;
    };
}

export default function TransferReceipt({ transfer }: ReceiptProps) {
    const isSuccess = transfer.status === 'completed';

    return (
        <>
            <Head title="Receipt Transfer" />

            <div className="max-w-2xl mx-auto p-4 md:p-6 lg:p-8 space-y-6">
                <Card className="overflow-hidden">
                    <div className={`p-6 text-center text-white ${isSuccess ? 'bg-green-600' : 'bg-red-600'}`}>
                        <div className="flex justify-center mb-4">
                            {isSuccess ? (
                                <CheckCircle2 className="h-16 w-16" />
                            ) : (
                                <XCircle className="h-16 w-16" />
                            )}
                        </div>
                        <h2 className="text-2xl font-bold mb-2">
                            {isSuccess ? 'Transfer Berhasil' : 'Transfer Gagal'}
                        </h2>
                        <div className="text-3xl font-bold">
                            {formatRupiah(transfer.amount)}
                        </div>
                    </div>

                    <CardContent className="p-0">
                        <div className="divide-y">
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Reference ID</span>
                                <span className="font-bold">{transfer.reference_id}</span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Tanggal</span>
                                <span className="font-medium">
                                    {format(new Date(transfer.created_at), 'dd MMM yyyy HH:mm:ss', { locale: id })}
                                </span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Tipe Transfer</span>
                                <Badge variant={transfer.transfer_type === 'intra_bank' ? 'default' : 'secondary'}>
                                    {transfer.transfer_type === 'intra_bank' ? 'Intra-bank' : 'Inter-bank (BIFAST)'}
                                </Badge>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Ke Rekening</span>
                                <span className="font-medium">{transfer.receiver_nomor_rekening}</span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Nama Penerima</span>
                                <span className="font-bold uppercase">{transfer.receiver_name}</span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Nominal</span>
                                <span className="font-medium">{formatRupiah(transfer.amount)}</span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Biaya Admin</span>
                                <span className="font-medium">{formatRupiah(transfer.fee)}</span>
                            </div>
                            <div className="flex justify-between items-center p-4 bg-slate-50">
                                <span className="font-bold">Total</span>
                                <span className="font-bold text-lg text-primary">
                                    {formatRupiah(transfer.amount + transfer.fee)}
                                </span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Keterangan</span>
                                <span className="font-medium">{transfer.description || '-'}</span>
                            </div>
                        </div>
                    </CardContent>

                    <CardFooter className="flex gap-4 justify-center p-6 bg-slate-50 border-t">
                        <Button variant="outline" asChild>
                            <Link href="/transfer">
                                <Plus className="mr-2 h-4 w-4" /> Transfer Lagi
                            </Link>
                        </Button>
                        <Button asChild>
                            <Link href="/transfer/history">
                                <List className="mr-2 h-4 w-4" /> Riwayat Transfer
                            </Link>
                        </Button>
                    </CardFooter>
                </Card>
            </div>
        </>
    );
}




TransferReceipt.layout = (page: React.ReactNode) => (
    <AppSidebarLayout breadcrumbs={[{ title: 'Transfer Dana', href: '/transfer' }, { title: 'Receipt', href: '#' }]}>
        {page}
    </AppSidebarLayout>
);
