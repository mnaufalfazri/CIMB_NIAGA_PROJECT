import { Head, useForm, usePage, Link } from '@inertiajs/react';
import AppSidebarLayout from '@/layouts/app/app-sidebar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle, CardFooter } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { ArrowLeft, Send } from 'lucide-react';
import { formatRupiah } from '@/lib/utils';
import { useState } from 'react';

interface ConfirmProps {
    data: {
        transfer_type: string;
        bank_tujuan?: string;
        receiver_nomor_rekening: string;
        receiver_name: string;
        amount: number;
        description: string;
    };
    fee: number;
    total: number;
}

export default function TransferConfirm({ data, fee, total }: ConfirmProps) {
    const { auth } = usePage().props as any;
    const user = auth.user;

    const { post, processing } = useForm({
        transfer_type: data.transfer_type,
        receiver_nomor_rekening: data.receiver_nomor_rekening,
        receiver_name: data.receiver_name,
        amount: data.amount,
        fee: fee,
        description: data.description || '',
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/transfer/execute');
    };

    return (
        <>
            <Head title="Konfirmasi Transfer" />

            <div className="max-w-2xl mx-auto p-4 md:p-6 lg:p-8 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Ringkasan Transfer</CardTitle>
                        <CardDescription>Mohon periksa kembali detail transfer Anda sebelum melanjutkan.</CardDescription>
                    </CardHeader>

                    <CardContent>
                        <div className="space-y-4 rounded-lg border p-4">
                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Tipe Transfer</span>
                                <div className="col-span-2 font-medium">
                                    {data.transfer_type === 'intra_bank' ? (
                                        <Badge>Intra-bank (Sesama CIMB)</Badge>
                                    ) : (
                                        <Badge variant="secondary">Inter-bank (BIFAST)</Badge>
                                    )}
                                </div>
                            </div>

                            {data.transfer_type === 'inter_bank_bifast' && (
                                <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                    <span className="text-muted-foreground font-medium">Bank Tujuan</span>
                                    <span className="col-span-2 font-semibold">{data.bank_tujuan || '-'}</span>
                                </div>
                            )}

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Dari Rekening</span>
                                <div className="col-span-2">
                                    <div className="font-semibold">{user.nomor_rekening}</div>
                                    <div className="text-sm text-muted-foreground">{user.name}</div>
                                </div>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Ke Rekening</span>
                                <span className="col-span-2 font-semibold">{data.receiver_nomor_rekening}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Nama Penerima</span>
                                <span className="col-span-2 font-semibold uppercase">{data.receiver_name}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Nominal</span>
                                <span className="col-span-2 font-semibold">{formatRupiah(data.amount)}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                <span className="text-muted-foreground font-medium">Biaya Transfer</span>
                                <span className="col-span-2 font-semibold">{formatRupiah(fee)}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2 border-b bg-slate-50 -mx-4 px-4">
                                <span className="text-primary font-bold">Total Debit</span>
                                <span className="col-span-2 font-bold text-lg text-primary">{formatRupiah(total)}</span>
                            </div>

                            <div className="grid grid-cols-3 gap-2 py-2">
                                <span className="text-muted-foreground font-medium">Keterangan</span>
                                <span className="col-span-2 font-medium">{data.description || '-'}</span>
                            </div>
                        </div>
                    </CardContent>

                    <CardFooter className="flex gap-2 justify-end">
                        <Button variant="outline" asChild>
                            <Link href="/transfer">
                                <ArrowLeft className="mr-2 h-4 w-4" /> Kembali
                            </Link>
                        </Button>
                        <form onSubmit={submit}>
                            <Button type="submit" disabled={processing}>
                                Konfirmasi & Transfer <Send className="ml-2 h-4 w-4" />
                            </Button>
                        </form>
                    </CardFooter>
                </Card>
            </div>
        </>
    );
}




TransferConfirm.layout = (page: React.ReactNode) => (
    <AppSidebarLayout breadcrumbs={[{ title: 'Transfer Dana', href: '/transfer' }, { title: 'Konfirmasi', href: '#' }]}>
        {page}
    </AppSidebarLayout>
);
