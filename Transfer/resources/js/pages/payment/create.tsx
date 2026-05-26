import { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import AppSidebarLayout from '@/layouts/app/app-sidebar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle, CardFooter } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Zap, Droplets, Wifi, Loader2, ArrowRight } from 'lucide-react';
import { formatRupiah } from '@/lib/utils';
import axios from 'axios';

export default function PaymentCreate() {
    const [step, setStep] = useState(1);
    const [selectedBiller, setSelectedBiller] = useState('');
    const [customerNumber, setCustomerNumber] = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');
    const [billData, setBillData] = useState<any>(null);

    const { data, setData, post, processing } = useForm({
        biller_category: '',
        customer_number: '',
        amount: '',
        name: '',
        period: '',
    });

    const handleSelectBiller = (biller: string) => {
        setSelectedBiller(biller);
        setStep(2);
        setCustomerNumber('');
        setError('');
        setBillData(null);
    };

    const handleCheckBill = async () => {
        if (!customerNumber) {
            setError('Nomor pelanggan wajib diisi');
            return;
        }

        setLoading(true);
        setError('');

        try {
            const response = await axios.post('/payment/check-bill', {
                biller_category: selectedBiller,
                customer_number: customerNumber
            });

            setBillData(response.data);
            setData({
                biller_category: response.data.biller_category,
                customer_number: response.data.customer_number,
                amount: response.data.amount,
                name: response.data.name,
                period: response.data.period,
            });
            setStep(3);
        } catch (err: any) {
            setError(err.response?.data?.message || 'Terjadi kesalahan');
        } finally {
            setLoading(false);
        }
    };

    const getLabel = () => {
        if (selectedBiller === 'pln') return 'ID Pelanggan / Nomor Meter';
        if (selectedBiller === 'pdam') return 'Nomor Pelanggan PDAM';
        return 'Nomor Pelanggan Internet';
    };

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/payment/confirm');
    };

    return (
        <>
            <Head title="Pembayaran Tagihan" />

            <div className="max-w-3xl mx-auto p-4 md:p-6 lg:p-8 space-y-6">
                
                {/* Step 1: Pilih Biller */}
                <Card className={step > 1 ? 'opacity-50' : ''}>
                    <CardHeader>
                        <CardTitle>Langkah 1: Pilih Biller</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div 
                                className={`flex flex-col items-center justify-center p-6 border-2 rounded-xl cursor-pointer transition-all ${
                                    selectedBiller === 'pln' ? 'border-primary bg-primary/5' : 'border-border hover:border-primary/50'
                                }`}
                                onClick={() => handleSelectBiller('pln')}
                            >
                                <Zap className="h-10 w-10 text-yellow-500 mb-3" />
                                <span className="font-semibold text-lg">PLN</span>
                            </div>
                            
                            <div 
                                className={`flex flex-col items-center justify-center p-6 border-2 rounded-xl cursor-pointer transition-all ${
                                    selectedBiller === 'pdam' ? 'border-primary bg-primary/5' : 'border-border hover:border-primary/50'
                                }`}
                                onClick={() => handleSelectBiller('pdam')}
                            >
                                <Droplets className="h-10 w-10 text-blue-500 mb-3" />
                                <span className="font-semibold text-lg">PDAM</span>
                            </div>
                            
                            <div 
                                className={`flex flex-col items-center justify-center p-6 border-2 rounded-xl cursor-pointer transition-all ${
                                    selectedBiller === 'internet' ? 'border-primary bg-primary/5' : 'border-border hover:border-primary/50'
                                }`}
                                onClick={() => handleSelectBiller('internet')}
                            >
                                <Wifi className="h-10 w-10 text-green-500 mb-3" />
                                <span className="font-semibold text-lg">Internet & TV</span>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Step 2: Cek Tagihan */}
                {step >= 2 && (
                    <Card className={step > 2 ? 'opacity-50' : ''}>
                        <CardHeader>
                            <CardTitle>Langkah 2: Cek Tagihan</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-2">
                                <Label htmlFor="customer_number">{getLabel()}</Label>
                                <div className="flex gap-2">
                                    <Input
                                        id="customer_number"
                                        type="text"
                                        placeholder="Masukkan nomor pelanggan"
                                        value={customerNumber}
                                        onChange={(e) => setCustomerNumber(e.target.value)}
                                        className="flex-1"
                                        onKeyDown={(e) => {
                                            if (e.key === 'Enter') handleCheckBill();
                                        }}
                                    />
                                    <Button onClick={handleCheckBill} disabled={loading}>
                                        {loading ? (
                                            <><Loader2 className="mr-2 h-4 w-4 animate-spin" /> Mengecek</>
                                        ) : (
                                            'Cek Tagihan'
                                        )}
                                    </Button>
                                </div>
                                {error && <p className="text-sm text-red-500 mt-2">{error}</p>}
                            </div>
                        </CardContent>
                    </Card>
                )}

                {/* Step 3: Detail Tagihan */}
                {step === 3 && billData && (
                    <Card>
                        <CardHeader>
                            <CardTitle>Langkah 3: Detail Tagihan</CardTitle>
                            <CardDescription>Pastikan detail tagihan sudah benar sebelum melanjutkan pembayaran.</CardDescription>
                        </CardHeader>
                        <form onSubmit={submit}>
                            <CardContent>
                                <div className="space-y-4 rounded-lg border p-4">
                                    <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                        <span className="text-muted-foreground font-medium">Nama Pelanggan</span>
                                        <span className="col-span-2 font-bold">{billData.name}</span>
                                    </div>
                                    <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                        <span className="text-muted-foreground font-medium">Periode</span>
                                        <span className="col-span-2 font-medium">{billData.period}</span>
                                    </div>
                                    {billData.package && (
                                        <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                            <span className="text-muted-foreground font-medium">Paket Layanan</span>
                                            <span className="col-span-2 font-medium">{billData.package}</span>
                                        </div>
                                    )}
                                    <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                        <span className="text-muted-foreground font-medium">Nominal Tagihan</span>
                                        <span className="col-span-2 font-medium">{formatRupiah(billData.amount)}</span>
                                    </div>
                                    <div className="grid grid-cols-3 gap-2 py-2 border-b">
                                        <span className="text-muted-foreground font-medium">Biaya Admin</span>
                                        <span className="col-span-2 font-medium">{formatRupiah(2500)}</span>
                                    </div>
                                    <div className="grid grid-cols-3 gap-2 py-2 bg-slate-50 -mx-4 px-4">
                                        <span className="font-bold">Total Pembayaran</span>
                                        <span className="col-span-2 font-bold text-lg text-primary">
                                            {formatRupiah(Number(billData.amount) + 2500)}
                                        </span>
                                    </div>
                                </div>
                            </CardContent>
                            <CardFooter>
                                <Button type="submit" className="w-full" disabled={processing}>
                                    Bayar Sekarang <ArrowRight className="ml-2 h-4 w-4" />
                                </Button>
                            </CardFooter>
                        </form>
                    </Card>
                )}
            </div>
        </>
    );
}




PaymentCreate.layout = (page: React.ReactNode) => (
    <AppSidebarLayout breadcrumbs={[{ title: 'Pembayaran Tagihan', href: '/payment' }]}>
        {page}
    </AppSidebarLayout>
);
