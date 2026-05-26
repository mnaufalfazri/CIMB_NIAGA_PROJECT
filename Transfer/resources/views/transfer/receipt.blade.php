@extends('layouts.app')
@section('title', 'Receipt Transfer')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-widget widget-user-2 shadow">
            <div class="widget-user-header {{ $transfer->status === 'completed' ? 'bg-success' : 'bg-danger' }}">
                <div class="text-center">
                    @if($transfer->status === 'completed')
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h3 class="widget-user-username font-weight-bold" style="margin-left: 0;">Transfer Berhasil</h3>
                    @else
                        <i class="fas fa-times-circle fa-4x mb-3"></i>
                        <h3 class="widget-user-username font-weight-bold" style="margin-left: 0;">Transfer Gagal</h3>
                    @endif
                    <h5 class="widget-user-desc" style="margin-left: 0;">Rp {{ number_format($transfer->amount, 0, ',', '.') }}</h5>
                </div>
            </div>
            
            <div class="card-body p-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <span class="nav-link">
                            Reference ID <span class="float-right font-weight-bold text-dark">{{ $transfer->reference_id }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Tanggal <span class="float-right text-dark">{{ $transfer->created_at->format('d M Y H:i:s') }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Tipe Transfer <span class="float-right badge {{ $transfer->transfer_type === 'intra_bank' ? 'badge-primary' : 'badge-info' }}">{{ $transfer->transfer_type === 'intra_bank' ? 'Intra-bank' : 'Inter-bank (BIFAST)' }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Ke Rekening <span class="float-right text-dark">{{ $transfer->receiver_nomor_rekening }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Nama Penerima <span class="float-right font-weight-bold text-dark">{{ $transfer->receiver_name }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Nominal <span class="float-right text-dark">Rp {{ number_format($transfer->amount, 0, ',', '.') }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Biaya Admin <span class="float-right text-dark">Rp {{ number_format($transfer->fee, 0, ',', '.') }}</span>
                        </span>
                    </li>
                    <li class="nav-item bg-light">
                        <span class="nav-link">
                            Total <span class="float-right font-weight-bold text-primary" style="font-size: 1.1rem;">Rp {{ number_format($transfer->amount + $transfer->fee, 0, ',', '.') }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Keterangan <span class="float-right text-dark">{{ $transfer->description ?: '-' }}</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('transfer.create') }}" class="btn btn-outline-primary mr-2"><i class="fas fa-plus mr-1"></i> Transfer Lagi</a>
                <a href="{{ route('transfer.history') }}" class="btn btn-primary"><i class="fas fa-list mr-1"></i> Riwayat Transfer</a>
            </div>
        </div>
    </div>
</div>
@endsection
