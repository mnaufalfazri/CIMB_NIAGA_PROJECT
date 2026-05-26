@extends('layouts.app')
@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Riwayat Pembayaran Tagihan</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Biller</th>
                            <th>Nomor Pelanggan</th>
                            <th>Tagihan</th>
                            <th>Biaya Admin</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $p)
                        <tr>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td><span class="badge badge-info text-uppercase">{{ $p->biller_category }}</span></td>
                            <td>{{ $p->customer_number }}</td>
                            <td>Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($p->admin_fee, 0, ',', '.') }}</td>
                            <td class="font-weight-bold text-primary">Rp {{ number_format($p->amount + $p->admin_fee, 0, ',', '.') }}</td>
                            <td>
                                @if($p->status == 'completed')
                                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Completed</span>
                                @elseif($p->status == 'failed')
                                    <span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Failed</span>
                                @else
                                    <span class="badge badge-warning">{{ ucfirst($p->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat pembayaran tagihan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $payments->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
