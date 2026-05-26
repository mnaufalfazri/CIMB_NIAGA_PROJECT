@extends('layouts.app')
@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Ringkasan Pembayaran</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 40%">Layanan (Biller)</th>
                            <td>
                                <span class="badge badge-info text-uppercase">{{ $data['biller_category'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Nomor Pelanggan</th>
                            <td><strong>{{ $data['customer_number'] }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <td>{{ $data['name'] }}</td>
                        </tr>
                        <tr>
                            <th>Periode Tagihan</th>
                            <td>{{ $data['period'] }}</td>
                        </tr>
                        <tr>
                            <th>Dari Rekening (Anda)</th>
                            <td>{{ session('user')['nomor_rekening'] }}<br><small class="text-muted">{{ session('user')['name'] }}</small></td>
                        </tr>
                        <tr>
                            <th>Nominal Tagihan</th>
                            <td>Rp {{ number_format($data['amount'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Biaya Admin</th>
                            <td>Rp {{ number_format($admin_fee, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-light">
                            <th>Total Debit</th>
                            <td class="text-primary font-weight-bold" style="font-size: 1.2rem;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
                <form action="{{ route('payment.execute') }}" method="POST" id="confirmForm">
                    @csrf
                    <!-- Pass data along -->
                    <input type="hidden" name="biller_category" value="{{ $data['biller_category'] }}">
                    <input type="hidden" name="customer_number" value="{{ $data['customer_number'] }}">
                    <input type="hidden" name="amount" value="{{ $data['amount'] }}">
                    
                    <a href="{{ route('payment.create') }}" class="btn btn-default mr-2">Batal</a>
                    <button type="button" class="btn btn-primary" id="btnConfirm">Konfirmasi & Bayar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#btnConfirm').click(function() {
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            text: "Total Rp {{ number_format($total, 0, ',', '.') }} akan didebit dari rekening Anda. Lanjutkan?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#7D1B28',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Bayar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
                $('#confirmForm').submit();
            }
        });
    });
</script>
@endpush
