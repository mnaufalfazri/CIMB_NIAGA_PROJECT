@extends('layouts.app')
@section('title', 'Riwayat Transfer')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Filter Riwayat</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('transfer.history') }}" method="GET" class="form-inline">
                    <div class="form-group mr-3 mb-2">
                        <label for="type" class="mr-2">Tipe</label>
                        <select name="type" id="type" class="form-control">
                            <option value="all">Semua Tipe</option>
                            <option value="intra_bank" {{ request('type') == 'intra_bank' ? 'selected' : '' }}>Intra-bank</option>
                            <option value="inter_bank_bifast" {{ request('type') == 'inter_bank_bifast' ? 'selected' : '' }}>Inter-bank BIFAST</option>
                        </select>
                    </div>
                    <div class="form-group mr-3 mb-2">
                        <label for="status" class="mr-2">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="all">Semua Status</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-filter mr-1"></i> Filter</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Riwayat Transfer</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tujuan</th>
                            <th>Nama Penerima</th>
                            <th>Nominal</th>
                            <th>Tipe</th>
                            <th>Biaya</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $t)
                        <tr>
                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $t->receiver_nomor_rekening }}</td>
                            <td>{{ $t->receiver_name }}</td>
                            <td>Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($t->transfer_type == 'intra_bank')
                                    <span class="badge badge-primary">Intra-bank</span>
                                @else
                                    <span class="badge badge-info">Inter-bank</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($t->fee, 0, ',', '.') }}</td>
                            <td>
                                @if($t->status == 'completed')
                                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Completed</span>
                                @elseif($t->status == 'failed')
                                    <span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Failed</span>
                                @else
                                    <span class="badge badge-warning">{{ ucfirst($t->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat transfer.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $transfers->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
