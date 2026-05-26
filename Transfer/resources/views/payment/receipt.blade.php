@extends('layouts.app')
@section('title', 'Receipt Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-widget widget-user-2 shadow">
            <div class="widget-user-header {{ $payment->status === 'completed' ? 'bg-success' : 'bg-danger' }}">
                <div class="text-center">
                    @if($payment->status === 'completed')
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h3 class="widget-user-username font-weight-bold" style="margin-left: 0;">Pembayaran Berhasil</h3>
                    @else
                        <i class="fas fa-times-circle fa-4x mb-3"></i>
                        <h3 class="widget-user-username font-weight-bold" style="margin-left: 0;">Pembayaran Gagal</h3>
                    @endif
                    <h5 class="widget-user-desc" style="margin-left: 0;">Rp {{ number_format($payment->amount + $payment->admin_fee, 0, ',', '.') }}</h5>
                </div>
            </div>
            
            <div class="card-body p-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <span class="nav-link">
                            Reference ID <span class="float-right font-weight-bold text-dark">{{ $payment->reference_id }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Tanggal <span class="float-right text-dark">{{ $payment->created_at->format('d M Y H:i:s') }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Layanan (Biller) <span class="float-right badge badge-info text-uppercase">{{ $payment->biller_category }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Nomor Pelanggan <span class="float-right font-weight-bold text-dark">{{ $payment->customer_number }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Dari Rekening <span class="float-right text-dark">{{ $payment->nomor_rekening }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Tagihan <span class="float-right text-dark">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Biaya Admin <span class="float-right text-dark">Rp {{ number_format($payment->admin_fee, 0, ',', '.') }}</span>
                        </span>
                    </li>
                    <li class="nav-item bg-light">
                        <span class="nav-link">
                            Total Dibayar <span class="float-right font-weight-bold text-primary" style="font-size: 1.1rem;">Rp {{ number_format($payment->amount + $payment->admin_fee, 0, ',', '.') }}</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('payment.create') }}" class="btn btn-outline-primary mr-2"><i class="fas fa-plus mr-1"></i> Bayar Lagi</a>
                <a href="{{ route('payment.history') }}" class="btn btn-primary"><i class="fas fa-list mr-1"></i> Riwayat Payment</a>
            </div>
        </div>
    </div>
</div>
@endsection
