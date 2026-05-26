@extends('layouts.app')
@section('title', 'Pembayaran Tagihan')

@push('styles')
<style>
    .biller-card {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 2px solid transparent;
    }
    .biller-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .biller-card.active {
        border-color: #7D1B28;
        background-color: #fdf5f6;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Langkah 1: Pilih Biller</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light biller-card" data-biller="pln">
                            <div class="card-body">
                                <i class="fas fa-bolt fa-3x text-warning mb-2"></i>
                                <h5>PLN</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light biller-card" data-biller="pdam">
                            <div class="card-body">
                                <i class="fas fa-tint fa-3x text-info mb-2"></i>
                                <h5>PDAM</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light biller-card" data-biller="internet">
                            <div class="card-body">
                                <i class="fas fa-wifi fa-3x text-success mb-2"></i>
                                <h5>Internet & TV</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline" id="step2" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Langkah 2: Cek Tagihan</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label id="lblCustomerNumber">Nomor Pelanggan</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" id="customer_number" placeholder="Masukkan nomor">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary btn-flat" id="btnCheckBill">Cek Tagihan</button>
                        </span>
                    </div>
                    <small id="billError" class="form-text text-danger mt-2" style="display:none;"></small>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline" id="step3" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Langkah 3: Detail Tagihan</h3>
            </div>
            <form action="{{ route('payment.confirm') }}" method="POST">
                @csrf
                <input type="hidden" name="biller_category" id="hidden_biller">
                <input type="hidden" name="customer_number" id="hidden_customer">
                <input type="hidden" name="amount" id="hidden_amount">
                <input type="hidden" name="name" id="hidden_name">
                <input type="hidden" name="period" id="hidden_period">
                
                <div class="card-body p-0">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width: 40%">Nama Pelanggan</th>
                                <td id="resName" class="font-weight-bold"></td>
                            </tr>
                            <tr>
                                <th>Periode</th>
                                <td id="resPeriod"></td>
                            </tr>
                            <tr id="rowPackage" style="display:none;">
                                <th>Paket Layanan</th>
                                <td id="resPackage"></td>
                            </tr>
                            <tr>
                                <th>Nominal Tagihan</th>
                                <td id="resAmount"></td>
                            </tr>
                            <tr>
                                <th>Biaya Admin</th>
                                <td>Rp 2.500</td>
                            </tr>
                            <tr class="bg-light">
                                <th>Total Pembayaran</th>
                                <td id="resTotal" class="text-primary font-weight-bold" style="font-size: 1.2rem;"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">Bayar Sekarang <i class="fas fa-arrow-right ml-1"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let selectedBiller = '';

    $('.biller-card').click(function() {
        $('.biller-card').removeClass('active');
        $(this).addClass('active');
        
        selectedBiller = $(this).data('biller');
        let label = selectedBiller === 'pln' ? 'ID Pelanggan / Nomor Meter' : 
                   (selectedBiller === 'pdam' ? 'Nomor Pelanggan PDAM' : 'Nomor Pelanggan Internet');
                   
        $('#lblCustomerNumber').text(label);
        $('#step2').slideDown();
        $('#step3').slideUp();
        $('#customer_number').val('');
        $('#billError').hide();
    });

    $('#btnCheckBill').click(function() {
        let custNumber = $('#customer_number').val();
        if (!custNumber) {
            $('#billError').text('Nomor pelanggan wajib diisi').show();
            return;
        }

        let btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading');
        $('#billError').hide();
        $('#step3').slideUp();

        $.ajax({
            url: '{{ route('payment.check-bill') }}',
            type: 'POST',
            data: {
                biller_category: selectedBiller,
                customer_number: custNumber
            },
            success: function(response) {
                btn.prop('disabled', false).text('Cek Tagihan');
                
                // Fill data
                $('#hidden_biller').val(response.biller_category);
                $('#hidden_customer').val(response.customer_number);
                $('#hidden_amount').val(response.amount);
                $('#hidden_name').val(response.name);
                $('#hidden_period').val(response.period);

                $('#resName').text(response.name);
                $('#resPeriod').text(response.period);
                $('#resAmount').text(formatRupiah(response.amount));
                
                let total = parseInt(response.amount) + 2500;
                $('#resTotal').text(formatRupiah(total));

                if (response.package) {
                    $('#rowPackage').show();
                    $('#resPackage').text(response.package);
                } else {
                    $('#rowPackage').hide();
                }

                $('#step3').slideDown();
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Cek Tagihan');
                let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan';
                $('#billError').text(msg).show();
            }
        });
    });
</script>
@endpush
