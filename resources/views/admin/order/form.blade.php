<x-app-layout>
    @push('styles')
    @endpush

    <div class="content">
        <form method="POST" action="{{ route('admin.order.store') }}">
            @csrf
            <div class="content-heading d-flex justify-content-between align-items-center">
                <span>Tambah Pesanan Baru</span>
                <div class="space-x-1">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check me-1"></i>
                        Simpan
                    </button>
                </div>
            </div>
            <div class="block block-rounded">
                <div class="block-content">
                    <div class="row">
                        <div class="col-md-6">
                            <x-select-field name="user_id" id="user_id" label="Konsumen" :options="$user"/>
                            <x-select-field name="produk_id" id="produk_id" label="Produk" :options="$produk"/>
                            <div class="mb-4">
                                <label for="field-lama">Lama Sewa</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="field-lama" name="lama">
                                    <span class="input-group-text">
                                        Jam
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-input-field type="text" name="tgl" id="tgl" label="Tanggal"/>
                            <div class="mb-4">
                                <label>Harga per jam</label>
                                <div class="fw-medium py-2" id="hargaJamShow">Rp 0</div>
                                <input type="hidden" id="hargaJamVal" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $('#field-user_id').select2();
        $('#field-produk_id').select2();

        $("#field-tgl").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            locale : "id",
            defaultDate : new Date(),
            minDate: "today"
        });

        $("#field-produk_id").on("change", function(e){
            var id = $(this).val();
            $.ajax({
                url: "/admin/produk/"+ id,
                type: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);

                    $("#hargaJamShow").text(formatRupiah(response.harga_jam, 'Rp. '));
                    $("#hargaJamVal").val(response.harga_jam);

                    $("#field-lama").attr("min", response.min_sewa);
                    $("#field-lama").val(response.min_sewa);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        })
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

