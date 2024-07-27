<x-app-layout>
    @push('styles')
    @endpush

    <div class="content">
            <div class="content-heading d-flex justify-content-between align-items-center">
                <span>Tambah Pemabayaran Baru</span>
            </div>
            <div class="block block-rounded">
                <div class="block-content">
                    <form method="POST" action="{{ route('admin.payment.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <x-select-field  name="user_id" label="Konsumen" id="user_id" :options="[]"/>
                                <x-select-field  name="order_id" label="No Pesanan" id="order_id" :options="[]"/>
                                <x-input-field  type="text" name="tgl" id="tgl" label="Tanggal Transfer"/>
                                <x-select-field name="bank" label="Tujuan Transfer" id="bank" :options="[
                                    ['label' => 'Bank BCA', 'value' => 'Bank BCA'],
                                    ['label' => 'Bank Mandiri', 'value' => 'Bank Mandiri'],
                                ]"/>
                                <x-input-field  type="text" name="pengirim" id="pengirim" label="Nama Pengirim"/>
                            </div>
                            <div class="col-md-6">
                                <x-field-read dir="vertical" label="Total Tagihan" class="mb-4" id="total">
                                    <x-slot name="value">
                                        Rp. 0
                                    </x-slot>
                                </x-field-read>
                                <x-field-read dir="vertical" label="Minimal Pembayaran" class="mb-4"  id="min_bayar" value="Rp. 0"/>
                                <x-input-field  name="jumlah" label="Jumlah Bayar" id="jumlah" type="number"/>
                                <x-input-field  name="bukti" label="Bukti Bayar" id="bukti" type="file"/>
                                <x-select-field name="status" label="Status" id="status" :options="[
                                    ['label' => 'Pending', 'value' => 'pending'],
                                    ['label' => 'Terima', 'value' => 'terima'],
                                    ['label' => 'Tolak', 'value' => 'tolak'],
                                ]"/>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
    </div>

    @push('scripts')
    <script>

        $('#field-user_id').select2({
            ajax: {
                url: "{{ route('admin.user.select') }}",
                type: 'POST',
                dataType: 'JSON',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $('#field-order_id').select2({
            ajax: {
                url: "{{ route('admin.order.select') }}",
                type: 'POST',
                dataType: 'JSON',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        user_id : $('#field-user_id').val()
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        
        $("#field-tgl").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            locale : "id",
            defaultDate : new Date(),
            minDate: "today"
        });


        $("#field-user_id").on("change", function(e){
            e.preventDefault();
            var id = $(this).val();
            $("#field-order_id").trigger('clear');
            if(id){
                $("#field-order_id").prop("disabled", false);
            }else{
                $("#field-order_id").prop( "disabled", true );
            }
        });

        

        $("#field-order_id").on("change", function(e){
            e.preventDefault();
            var id = $(this).val();
            $.ajax({
                url: `/admin/pemesanan/${id}/json`,
                type: "GET",
                success: function (response) {
                    // console.log(response);

                    var tagihan = response.total - response.dibayar;
                    var min = response.total*0.5;
                    $('#show-total').html(formatRupiah(tagihan, 'Rp. '));
                    $('#show-min_bayar').html(formatRupiah(min, 'Rp. '));
                    $("#field-jumlah").attr('min', min);
                    $("#field-jumlah").attr('max', tagihan);
                },
                error: function (error) {
                }

            });
        });
        
        $('#field-jumlah').on('input', function() {
            var max = $(this).attr('max');
            if (parseInt($(this).val()) > parseInt(max)) {
                $(this).val(max);
            }
        });
        function formatRupiah(angka, prefix){
            var number_string = angka.toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }
    </script>
    @endpush
</x-app-layout>

