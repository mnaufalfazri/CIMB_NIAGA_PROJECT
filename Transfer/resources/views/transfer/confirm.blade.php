@extends('layouts.app')
@section('title', 'Konfirmasi Transfer')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Ringkasan Transfer</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 40%">Tipe Transfer</th>
                            <td>
                                @if($data['transfer_type'] == 'intra_bank')
                                    <span class="badge badge-primary">Intra-bank (Sesama CIMB)</span>
                                @else
                                    <span class="badge badge-info">Inter-bank (BIFAST)</span>
                                @endif
                            </td>
                        </tr>
                        @if($data['transfer_type'] == 'inter_bank_bifast')
                        <tr>
                            <th>Bank Tujuan</th>
                            <td><strong>{{ $data['bank_tujuan'] ?? '-' }}</strong></td>
                        </tr>
                        @endif
                        <tr>
                            <th>Dari Rekening</th>
                            <td>{{ session('user')['nomor_rekening'] }}<br><small class="text-muted">{{ session('user')['name'] }}</small></td>
                        </tr>
                        <tr>
                            <th>Ke Rekening</th>
                            <td>{{ $data['receiver_nomor_rekening'] }}</td>
                        </tr>
                        <tr>
                            <th>Nama Penerima</th>
                            <td><strong>{{ $data['receiver_name'] }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nominal</th>
                            <td>Rp {{ number_format($data['amount'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Biaya Transfer</th>
                            <td>Rp {{ number_format($fee, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-light">
                            <th>Total Debit</th>
                            <td class="text-primary font-weight-bold" style="font-size: 1.2rem;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $data['description'] ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
                <form action="{{ route('transfer.execute') }}" method="POST" id="confirmForm">
                    @csrf
                    <!-- Pass data along -->
                    <input type="hidden" name="transfer_type" value="{{ $data['transfer_type'] }}">
                    <input type="hidden" name="receiver_nomor_rekening" value="{{ $data['receiver_nomor_rekening'] }}">
                    <input type="hidden" name="receiver_name" value="{{ $data['receiver_name'] }}">
                    <input type="hidden" name="amount" value="{{ $data['amount'] }}">
                    <input type="hidden" name="fee" value="{{ $fee }}">
                    <input type="hidden" name="description" value="{{ $data['description'] }}">
                    
                    <a href="{{ route('transfer.create') }}" class="btn btn-default mr-2">Kembali</a>
                    <button type="button" class="btn btn-primary" id="btnConfirm">Konfirmasi & Transfer</button>
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
            title: 'Konfirmasi Transfer',
            text: "Pastikan data transfer sudah benar. Lanjutkan?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#7D1B28',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan',
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
