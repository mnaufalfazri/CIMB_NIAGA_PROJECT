import { Head, useForm, usePage, Link } from '@inertiajs/react';
import AppSidebarLayout from '@/layouts/app/app-sidebar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle, CardFooter } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { ArrowLeft, Send } from 'lucide-react';
import { formatRupiah } from '@/lib/utils';

interface ConfirmProps {
    data: {
        biller_category: string;
        customer_number: string;
        amount: number;
        name: string;
        period: string;
    };
    admin_fee: number;
    total: number;
}

export default function PaymentConfirm({ data, admin_fee, total }: ConfirmProps) {
    const { auth } = usePage().props as any;
    const user = auth.user;

    const { post, processing } = useForm({
        biller_category: data.biller_category,
        customer_number: data.customer_number,
        amount: data.amount,
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/payment/execute');
    };

    return (
        <>
            <Head title="Konfirmasi Pembayaran" />

            <div className="max-w-2xl mx-auto p-4 md:p-6 lg:p-8 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Ringkasan Pembayaran</CardTitle>
                        <CardDescription>Mohon periksa kembali detail pembayaran Anda sebelum melanjutkan.</CardDescription>
                    </CardHeader>

                    <CardContent>
                        <div className="space-y-4 rounded-lg border p-4">
                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Layanan (Biller)</span>
                                <div className="col-span-2 font-medium">
                                    <Badge variant="outline" className="uppercase">{data.biller_category}</Badge>
                                </div>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Nomor Pelanggan</span>
                                <span className="col-span-2 font-semibold">{data.customer_number}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Nama Pelanggan</span>
                                <span className="col-span-2 font-semibold uppercase">{data.name}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Periode Tagihan</span>
                                <span className="col-span-2 font-medium">{data.period}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Dari Rekening</span>
                                <div className="col-span-2">
                                    <div className="font-semibold">{user.nomor_rekening}</div>
                                    <div className="text-sm text-muted-foreground">{user.name}</div>
                                </div>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Nominal Tagihan</span>
                                <span className="col-span-2 font-medium">{formatRupiah(data.amount)}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Biaya Admin</span>
                                <span className="col-span-2 font-medium">{formatRupiah(admin_fee)}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b bg-slate-50 -mx-4 px-4">
                                <span className="text-primary font-bold">Total Debit</span>
                                <span className="col-span-2 font-bold text-lg text-primary">{formatRupiah(total)}</span>
                            </div>
                        </div>
                    </CardContent>

                    <CardFooter className="flex gap-2 justify-end">
                        <Button variant="outline" asChild>
                            <Link href="/payment">
                                Batal
                            </Link>
                        </Button>
                        <form onSubmit={submit}>
                            <Button type="submit" disabled={processing}>
                                Konfirmasi & Bayar <Send className="ml-2 h-4 w-4" />
                            </Button>
                        </form>
                    </CardFooter>
                </Card>
            </div>
        </>
    );
}




PaymentConfirm.layout = (page: React.ReactNode) => (
    <AppSidebarLayout breadcrumbs={[{ title: 'Pembayaran Tagihan', href: '/payment' }, { title: 'Konfirmasi', href: '#' }]}>
        {page}
    </AppSidebarLayout>
);
