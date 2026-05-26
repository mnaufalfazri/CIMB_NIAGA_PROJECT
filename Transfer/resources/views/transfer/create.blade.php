@extends('layouts.app')
@section('title', 'Transfer Dana')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Form Transfer</h3>
            </div>
            <form action="{{ route('transfer.confirm') }}" method="POST" id="transferForm">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Tipe Transfer</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="type_intra" name="transfer_type" value="intra_bank" checked>
                            <label for="type_intra" class="custom-control-label">Intra-bank (Sesama CIMB) - Bebas Biaya</label>
                        </div>
                        <div class="custom-control custom-radio mt-2">
                            <input class="custom-control-input" type="radio" id="type_inter" name="transfer_type" value="inter_bank_bifast">
                            <label for="type_inter" class="custom-control-label">Inter-bank (BIFAST) - Biaya Rp 2.500</label>
                        </div>
                    </div>

                    <div class="form-group" id="bankTujuanGroup" style="display: none;">
                        <label for="bank_tujuan">Bank Tujuan</label>
                        <select class="form-control" id="bank_tujuan" name="bank_tujuan">
                            <option value="">Pilih Bank</option>
                            <option value="BCA">BCA</option>
                            <option value="BNI">BNI</option>
                            <option value="BRI">BRI</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BSI">BSI</option>
                            <option value="BTPN">BTPN</option>
                            <option value="CIMB Niaga Syariah">CIMB Niaga Syariah</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="receiver_nomor_rekening">Nomor Rekening Tujuan</label>
                        <input type="text" class="form-control" id="receiver_nomor_rekening" name="receiver_nomor_rekening" placeholder="Masukkan 13 digit rekening" maxlength="13" required>
                        <small id="accountLoading" class="form-text text-muted" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Mengecek rekening...</small>
                        <small id="accountError" class="form-text text-danger" style="display:none;">Rekening tidak ditemukan</small>
                    </div>

                    <div class="form-group">
                        <label for="receiver_name">Nama Penerima</label>
                        <input type="text" class="form-control" id="receiver_name" name="receiver_name" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="amount_display">Nominal Transfer</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control" id="amount_display" placeholder="0" required>
                            <input type="hidden" id="amount" name="amount">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Keterangan (Opsional)</label>
                        <textarea class="form-control" id="description" name="description" rows="2" placeholder="Catatan transfer..."></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSubmit">Lanjutkan <i class="fas fa-arrow-right ml-1"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle Tipe Transfer change
        $('input[name="transfer_type"]').change(function() {
            if ($('#type_inter').is(':checked')) {
                $('#bankTujuanGroup').slideDown();
                // Reset validation state for interbank (we assume any 13 digit is valid and name can be manually typed for mock)
                $('#receiver_name').prop('readonly', false).val('');
                $('#bank_tujuan').prop('required', true);
            } else {
                $('#bankTujuanGroup').slideUp();
                $('#receiver_name').prop('readonly', true).val('');
                $('#bank_tujuan').prop('required', false);
            }
        });

        // Format Rupiah Input
        $('#amount_display').on('input', function() {
            let value = $(this).val().replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            $(this).val(rupiah);
            
            // Set hidden pure number
            $('#amount').val(value);
        });

        // AJAX Validation
        $('#receiver_nomor_rekening').on('input', function() {
            let rek = $(this).val();
            
            // Only validate if intra bank
            if ($('#type_inter').is(':checked')) return;

            if (rek.length === 13) {
                $('#accountLoading').show();
                $('#accountError').hide();
                $('#receiver_name').val('');
                
                $.ajax({
                    url: '{{ route('transfer.validate-account') }}',
                    type: 'POST',
                    data: { nomor_rekening: rek },
                    success: function(response) {
                        $('#accountLoading').hide();
                        if (response.exists) {
                            $('#receiver_name').val(response.name);
                            $('#receiver_nomor_rekening').removeClass('is-invalid').addClass('is-valid');
                        } else {
                            $('#accountError').show();
                            $('#receiver_nomor_rekening').addClass('is-invalid');
                        }
                    },
                    error: function() {
                        $('#accountLoading').hide();
                        $('#accountError').text('Gagal memvalidasi rekening').show();
                        $('#receiver_nomor_rekening').addClass('is-invalid');
                    }
                });
            } else {
                $('#receiver_name').val('');
                $('#receiver_nomor_rekening').removeClass('is-valid is-invalid');
                $('#accountError').hide();
            }
        });
        
        // Prevent submit if name is empty
        $('#transferForm').submit(function(e) {
            if (!$('#receiver_name').val()) {
                e.preventDefault();
                Toast.fire({
                    icon: 'warning',
                    title: 'Mohon lengkapi nama penerima'
                });
            }
        });
    });
</script>
@endpush
