import { Head, Link } from '@inertiajs/react';
import AppSidebarLayout from '@/layouts/app/app-sidebar-layout';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { CheckCircle2, XCircle, Plus, List } from 'lucide-react';
import { formatRupiah } from '@/lib/utils';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';

interface ReceiptProps {
    payment: {
        id: number;
        reference_id: string;
        created_at: string;
        biller_category: string;
        customer_number: string;
        nomor_rekening: string;
        amount: number;
        admin_fee: number;
        status: string;
    };
}

export default function PaymentReceipt({ payment }: ReceiptProps) {
    const isSuccess = payment.status === 'completed';

    return (
        <>
            <Head title="Receipt Pembayaran" />

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
                            {isSuccess ? 'Pembayaran Berhasil' : 'Pembayaran Gagal'}
                        </h2>
                        <div className="text-3xl font-bold">
                            {formatRupiah(payment.amount + payment.admin_fee)}
                        </div>
                    </div>

                    <CardContent className="p-0">
                        <div className="divide-y">
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Reference ID</span>
                                <span className="font-bold">{payment.reference_id}</span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Tanggal</span>
                                <span className="font-medium">
                                    {format(new Date(payment.created_at), 'dd MMM yyyy HH:mm:ss', { locale: id })}
                                </span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Layanan (Biller)</span>
                                <Badge variant="outline" className="uppercase">
                                    {payment.biller_category}
                                </Badge>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Nomor Pelanggan</span>
                                <span className="font-bold">{payment.customer_number}</span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Dari Rekening</span>
                                <span className="font-medium">{payment.nomor_rekening}</span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Tagihan</span>
                                <span className="font-medium">{formatRupiah(payment.amount)}</span>
                            </div>
                            <div className="flex justify-between items-center p-4">
                                <span className="text-muted-foreground">Biaya Admin</span>
                                <span className="font-medium">{formatRupiah(payment.admin_fee)}</span>
                            </div>
                            <div className="flex justify-between items-center p-4 bg-slate-50">
                                <span className="font-bold">Total Dibayar</span>
                                <span className="font-bold text-lg text-primary">
                                    {formatRupiah(payment.amount + payment.admin_fee)}
                                </span>
                            </div>
                        </div>
                    </CardContent>

                    <CardFooter className="flex gap-4 justify-center p-6 bg-slate-50 border-t">
                        <Button variant="outline" asChild>
                            <Link href="/payment">
                                <Plus className="mr-2 h-4 w-4" /> Bayar Lagi
                            </Link>
                        </Button>
                        <Button asChild>
                            <Link href="/payment/history">
                                <List className="mr-2 h-4 w-4" /> Riwayat Payment
                            </Link>
                        </Button>
                    </CardFooter>
                </Card>
            </div>
        </>
    );
}




PaymentReceipt.layout = (page: React.ReactNode) => (
    <AppSidebarLayout breadcrumbs={[{ title: 'Pembayaran Tagihan', href: '/payment' }, { title: 'Receipt', href: '#' }]}>
        {page}
    </AppSidebarLayout>
);
