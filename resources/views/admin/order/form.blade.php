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
                        </div>
                        <div class="col-md-6">
                            <x-input-field type="text" name="tgl" id="tgl" label="Tanggal"/>
                            <div class="mb-4" data-select2-id="6">
                                <label class="form-label" for="field-produk_id">Produk
                                </label>
                                <select class="form-control select2-hidden-accessible" id="field-produk_id"
                                    name="produk_id" data-select2-id="field-produk_id" tabindex="-1" aria-hidden="true">
                                    <option value="" data-select2-id="4">Pilih</option>
                                    <option value="1" data-select2-id="7">Mini Excavator, 5 Ton, Kobelco</option>
                                </select><span
                                    class="select2 select2-container select2-container--default select2-container--below"
                                    dir="ltr" data-select2-id="3" style="width: 562px;"><span class="selection"><span
                                            class="select2-selection select2-selection--single" role="combobox"
                                            aria-haspopup="true" aria-expanded="false" tabindex="0"
                                            aria-disabled="false"
                                            aria-labelledby="select2-field-produk_id-container"><span
                                                class="select2-selection__rendered"
                                                id="select2-field-produk_id-container" role="textbox"
                                                aria-readonly="true" title="Mini Excavator, 5 Ton, Kobelco">Mini
                                                Excavator, 5 Ton, Kobelco</span><span class="select2-selection__arrow"
                                                role="presentation"><b
                                                    role="presentation"></b></span></span></span><span
                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <div id="error-produk_id" class="text-danger"></div>

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

