import { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import AppSidebarLayout from '@/layouts/app/app-sidebar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle, CardFooter } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { ArrowRight, Loader2 } from 'lucide-react';
import axios from 'axios';

export default function TransferCreate() {
    const { data, setData, post, processing, errors } = useForm({
        transfer_type: 'intra_bank',
        bank_tujuan: '',
        receiver_nomor_rekening: '',
        receiver_name: '',
        amount: '',
        description: '',
    });

    const [accountLoading, setAccountLoading] = useState(false);
    const [accountError, setAccountError] = useState('');
    const [amountDisplay, setAmountDisplay] = useState('');

    const handleAmountChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        let value = e.target.value.replace(/[^,\d]/g, '');
        let split = value.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        setAmountDisplay(rupiah);
        setData('amount', value);
    };

    const handleRekeningChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
        const rek = e.target.value;
        setData('receiver_nomor_rekening', rek);

        if (data.transfer_type === 'inter_bank_bifast') return;

        if (rek.length === 13) {
            setAccountLoading(true);
            setAccountError('');
            setData('receiver_name', '');
            
            try {
                const response = await axios.post('/transfer/validate-account', { nomor_rekening: rek });
                if (response.data.exists) {
                    setData('receiver_name', response.data.name);
                } else {
                    setAccountError('Rekening tidak ditemukan');
                }
            } catch (error) {
                setAccountError('Gagal memvalidasi rekening');
            } finally {
                setAccountLoading(false);
            }
        } else {
            setData('receiver_name', '');
            setAccountError('');
        }
    };

    const handleTransferTypeChange = (type: string) => {
        setData(data => ({
            ...data,
            transfer_type: type,
            bank_tujuan: type === 'intra_bank' ? '' : data.bank_tujuan,
            receiver_name: type === 'inter_bank_bifast' ? '' : data.receiver_name,
        }));
        if (type === 'inter_bank_bifast') {
            setAccountError('');
        }
    };

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/transfer/confirm');
    };

    return (
        <>
            <Head title="Transfer Dana" />
            
            <div className="max-w-2xl mx-auto p-4 md:p-6 lg:p-8 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Form Transfer</CardTitle>
                        <CardDescription>Pilih tipe transfer dan isi detail tujuan.</CardDescription>
                    </CardHeader>
                    
                    <form onSubmit={submit}>
                        <CardContent className="space-y-6">
                            <div className="space-y-3">
                                <Label>Tipe Transfer</Label>
                                <div className="flex flex-col space-y-2">
                                    <label className="flex items-center space-x-3 p-3 border rounded-md cursor-pointer hover:bg-slate-50">
                                        <input 
                                            type="radio" 
                                            name="transfer_type" 
                                            value="intra_bank"
                                            checked={data.transfer_type === 'intra_bank'}
                                            onChange={() => handleTransferTypeChange('intra_bank')}
                                            className="h-4 w-4 text-primary border-gray-300 focus:ring-primary"
                                        />
                                        <span className="text-sm font-medium">Intra-bank (Sesama CIMB) - Bebas Biaya</span>
                                    </label>
                                    <label className="flex items-center space-x-3 p-3 border rounded-md cursor-pointer hover:bg-slate-50">
                                        <input 
                                            type="radio" 
                                            name="transfer_type" 
                                            value="inter_bank_bifast"
                                            checked={data.transfer_type === 'inter_bank_bifast'}
                                            onChange={() => handleTransferTypeChange('inter_bank_bifast')}
                                            className="h-4 w-4 text-primary border-gray-300 focus:ring-primary"
                                        />
                                        <span className="text-sm font-medium">Inter-bank (BIFAST) - Biaya Rp 2.500</span>
                                    </label>
                                </div>
                            </div>

                            {data.transfer_type === 'inter_bank_bifast' && (
                                <div className="space-y-2">
                                    <Label htmlFor="bank_tujuan">Bank Tujuan</Label>
                                    <Select 
                                        value={data.bank_tujuan} 
                                        onValueChange={(value) => setData('bank_tujuan', value)}
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Pilih Bank" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="BCA">BCA</SelectItem>
                                            <SelectItem value="BNI">BNI</SelectItem>
                                            <SelectItem value="BRI">BRI</SelectItem>
                                            <SelectItem value="Mandiri">Mandiri</SelectItem>
                                            <SelectItem value="BSI">BSI</SelectItem>
                                            <SelectItem value="BTPN">BTPN</SelectItem>
                                            <SelectItem value="CIMB Niaga Syariah">CIMB Niaga Syariah</SelectItem>
                                        </SelectContent>
                                    </Select>
                                    {errors.bank_tujuan && <p className="text-sm text-red-500">{errors.bank_tujuan}</p>}
                                </div>
                            )}

                            <div className="space-y-2">
                                <Label htmlFor="receiver_nomor_rekening">Nomor Rekening Tujuan</Label>
                                <Input
                                    id="receiver_nomor_rekening"
                                    type="text"
                                    maxLength={13}
                                    placeholder="Masukkan 13 digit rekening"
                                    value={data.receiver_nomor_rekening}
                                    onChange={handleRekeningChange}
                                    required
                                    className={accountError ? 'border-red-500' : ''}
                                />
                                {accountLoading && (
                                    <p className="text-sm text-muted-foreground flex items-center gap-2">
                                        <Loader2 className="h-3 w-3 animate-spin" /> Mengecek rekening...
                                    </p>
                                )}
                                {accountError && <p className="text-sm text-red-500">{accountError}</p>}
                                {errors.receiver_nomor_rekening && <p className="text-sm text-red-500">{errors.receiver_nomor_rekening}</p>}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="receiver_name">Nama Penerima</Label>
                                <Input
                                    id="receiver_name"
                                    type="text"
                                    value={data.receiver_name}
                                    onChange={(e) => setData('receiver_name', e.target.value)}
                                    readOnly={data.transfer_type === 'intra_bank'}
                                    required
                                    className={data.transfer_type === 'intra_bank' ? 'bg-slate-50' : ''}
                                />
                                {errors.receiver_name && <p className="text-sm text-red-500">{errors.receiver_name}</p>}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="amount_display">Nominal Transfer</Label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-muted-foreground">
                                        Rp
                                    </div>
                                    <Input
                                        id="amount_display"
                                        type="text"
                                        className="pl-10"
                                        placeholder="0"
                                        value={amountDisplay}
                                        onChange={handleAmountChange}
                                        required
                                    />
                                </div>
                                {errors.amount && <p className="text-sm text-red-500">{errors.amount}</p>}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="description">Keterangan (Opsional)</Label>
                                <Input
                                    id="description"
                                    type="text"
                                    placeholder="Catatan transfer..."
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                />
                            </div>

                        </CardContent>
                        <CardFooter>
                            <Button 
                                type="submit" 
                                className="w-full" 
                                disabled={processing || (data.transfer_type === 'intra_bank' && !data.receiver_name)}
                            >
                                Lanjutkan <ArrowRight className="ml-2 h-4 w-4" />
                            </Button>
                        </CardFooter>
                    </form>
                </Card>
            </div>
        </>
    );
}

TransferCreate.layout = (page: React.ReactNode) => (
    <AppSidebarLayout breadcrumbs={[{ title: 'Transfer Dana', href: '/transfer' }]}>
        {page}
    </AppSidebarLayout>
);
