<x-landing-layout>
    <div class="bg-white">
        <div class="content content-full">
            <nav class="breadcrumb push rounded-pill py-2 mb-4">
                <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
                <a class="breadcrumb-item" href="{{ route('produk.kategori', $data->kategori->slug) }}">{{ $data->kategori->nama}}</a>
                <span class="breadcrumb-item active">{{ $data->nama}}</span>
            </nav>
            <div class="row">
                <div class="col-md-8">
                    <h1 class="fs-2 fw-bold">{{ $data->nama }}</h1>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <img src="{{ $data->foto }}" class="img-fluid"/>
                        </div>
                        <div class="col-md-8">
                            <h2 class="fs-lg fw-bold">{{ $data->model }}</h2>
                            <p class="text-muted">{{ $data->deskripsi }}</p>
                        </div>
                    </div>
                    <h3 class="fs-4 mb-3">Harga Alat</h3>
                    <table class="table table-bordered">
                        <tr>
                            <td>Minimal Sewa</td>
                            <td class="fw-bold">{{ $data->min_sewa }} Jam</td>
                        </tr>
                        <tr>
                            <td>Harga Sewa Unit / Jam</td>
                            <td class="fw-bold"> Rp {{  number_format($data->harga_jam,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <td>Harga Sewa Unit/ Hari</td>
                            <td class="fw-bold"> Rp {{  number_format($data->harga_harian,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <td>Harga Operator(Driver) / Jam</td>
                            <td class="fw-bold">Rp {{  number_format($data->operator_jam,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <td>Harga Operator (Driver)/ Hari</td>
                            <td class="fw-bold">Rp {{  number_format($data->operator_hari,0,',','.') }}</td>
                        </tr>
                    </table>
                    @if($data->spesifikasi)
                    <h3 class="fs-4 mb-3">Spesifikasi Alat</h3>
                    <table class="table table-bordered">
                        @foreach (json_decode($data->spesifikasi) as $s)
                                <tr>
                                    <td>{{ $s->label }}</td>
                                    <td>{{ $s->value }}</td>
                                </tr>                       
                        @endforeach
                    </table>     
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded border border-3 shadow-sm">
                        <div class="block-content p-3">
                            @if(auth()->guard('web')->user())
                            <button type="button" class="btn btn-primary btn-lg w-100" onclick="openModal()">
                                Sewa Sekarang
                            </button>
                            @else
                            <a class="btn btn-primary btn-lg w-100" href="{{ route('login') }}">
                                Sewa Sekarang
                            </a>
                            @endif
                        </div>
                        <div class="block-content p-3 border-top border-3">
                            <div class="fs-base fw-bold">Alat berat lainya</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="modal"
        id="modal-form"
        aria-labelledby="modal-form"
        style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myForm" method="POST" action="{{ route('order.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="field-id" name="produk_id" value="{{ $data->id }}"/>
                    <input type="hidden" id="field-harga_operator" name="harga_operator"/>
                    <input type="hidden" id="field-harga_unit" name="harga_unit"/>
                    <input type="hidden" id="field-total" name="total"/>
                    <div class="block block-rounded shadow-none mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Sewa Sekarang</h3>
                            <div class="block-options">
                                <button
                                    type="button"
                                    class="btn-block-option"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm">
                            <div class="row mb-4">
                                <div class="col-md-5 d-flex my-auto">
                                    <label for="field-lama">Tanggal Penggunaan</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" class="form-control" id="field-tgl" name="tgl" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-5 d-flex my-auto">
                                    <label for="field-lama">Lama Sewa</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="number" class="form-control" onchange="calculate()" min="{{ $data->min_sewa}}" value="{{ $data->min_sewa}}" id="field-lama" name="lama">
                                        <span class="input-group-text">
                                            Jam
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-5 d-flex my-auto">
                                    <label for="showHari">Lama Sewa Hari</label>
                                </div>
                                <div class="col-md-7">
                                    <span id="showHari"></span>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-5 d-flex my-auto">
                                    <label for="field-qty">Jumlah Unit</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="number" class="form-control" onchange="calculate()" min="1" value="1" id="field-qty" name="qty">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-5 d-flex my-auto">
                                    <label for="field-qty">Harga / Unit</label>
                                </div>
                                <div class="col-md-7">
                                    <div id="showHargaUnit">Rp {{ number_format($data->harga_harian,0,',','.') }}</div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-5 d-flex my-auto">
                                    <label for="field-qty">Harga Operator/Unit</label>
                                </div>
                                <div class="col-md-7">
                                    <div id="showHargaOperator">Rp {{ number_format($data->harga_harian,0,',','.') }}</div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-5 d-flex my-auto">
                                    <label for="field-qty">Subtotal</label>
                                </div>
                                <div class="col-md-7">
                                    <div id="showSubTotal">Rp {{ number_format($data->harga_harian,0,',','.') }}</div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-5 d-flex my-auto">
                                    <label for="field-qty">Lokasi Project</label>
                                </div>
                                <div class="col-md-7">
                                    <textarea class="form-control" id="field-lokasi" name="lokasi"></textarea>
                                </div>
                            </div>
                        </div>
                        <div
                            class="block-content block-content-full block-content-sm text-end border-top">
                            <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary" id="btn-simpan">
                                Pesan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const produk = {!! json_encode($data) !!};

            function openModal(){
                const form = document.getElementById('modal-form');

                calculate();
                var modalForm = bootstrap.Modal.getOrCreateInstance(form);
                
                modalForm.show();
            }

            function calculate(){
                var qty = $("#field-qty").val();
                var lama = $("#field-lama").val();
                const hargaUnit = hitungHargaUnit(lama);
                const hargaOperator = hitungHargaOperator(lama);
                const total = (hargaUnit + hargaOperator) * qty;

                const hari = lama / 12;
                const jam = lama % 12;
                const showHari = ~~hari+ ' Hari ';
                const showJam =  (jam > 0) ? jam + ' Jam' : '';

                $("#field-harga_operator").val(hargaOperator);
                $("#field-harga_unit").val(hargaUnit);
                $("#field-total").val(total);

                $("#showHargaUnit").html(formatRupiah(hargaUnit, 'Rp. '));
                $("#showHargaOperator").html(formatRupiah(hargaOperator, 'Rp. '));
                $("#showSubTotal").html(formatRupiah(total, 'Rp. '));

                $("#showHari").html(showHari + showJam);
            }

            function hitungHargaOperator(lama){
                sisa = lama % 12;

                hari = (lama - sisa) / 12;

                harga_hari = hari*produk.operator_hari;
                harga_jam = sisa*produk.operator_jam;

                total = harga_hari + harga_jam;

                return total;
            }

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

            function hitungHargaUnit(lama){
                sisa = lama % 12;

                hari = (lama - sisa) / 12;

                harga_hari = hari*produk.harga_harian;
                harga_jam = sisa*produk.harga_harian;

                total = harga_hari + harga_jam;

                return total;
            }
        </script>
    @endpush
</x-landing-layout>