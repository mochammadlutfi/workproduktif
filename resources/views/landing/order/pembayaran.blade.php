<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill py-2 mb-4">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ route('order.index') }}">Pesanan Saya</a>
            <a class="breadcrumb-item" href="{{ route('order.show', $data->id) }}">{{ $data->nomor }}</a>
            <span class="breadcrumb-item active">Pembayaran</span>
        </nav>
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">Pembayaran Pesanan {{ $data->nomor }}</h3>
                <div class="block-options">
                </div>
            </div>
            <div class="block-content p-4">
                <form method="POST" action="{{ route('order.update', $data->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <x-input-field  type="text" name="tgl" id="tgl" label="Tanggal Transfer"/>
                            <x-select-field name="bank" label="Tujuan Transfer" id="bank" :options="[
                                ['label' => 'Bank BCA', 'value' => 'Bank BCA'],
                                ['label' => 'Bank Mandiri', 'value' => 'Bank Mandiri'],
                            ]"/>
                            <x-input-field  type="text" name="pengirim" id="pengirim" label="Nama Pengirim"/>
                            <x-field-read dir="vertical" label="Total Tagihan" class="mb-4" id="total">
                                <x-slot name="value">
                                    Rp {{ number_format($data->total-$data->dibayar,0,',','.') }}
                                </x-slot>
                            </x-field-read>
                        </div>
                        <div class="col-md-6">
                            <x-field-read dir="vertical" label="Minimal Pembayaran" class="mb-4"  id="min_bayar">
                                <x-slot name="value">
                                    @if($data->status == 'Belum Bayar')
                                    Rp {{ number_format($data->total*.5,0,',','.') }}
                                    @else
                                    Rp {{ number_format($data->total-$data->dibayar,0,',','.') }}
                                    @endif
                                </x-slot>
                            </x-field-read>
                            <x-input-field  name="jumlah" label="Jumlah Bayar" id="jumlah" type="number" value="{{ ($data->status == 'Belum Bayar') ? $data->total*.5 :  $data->total-$data->dibayar }}" />
                            <x-input-field  name="bukti" label="Bukti Bayar" id="bukti" type="file"/>
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

            $(function () {
                $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    ajax: "{{ route('order.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nomor', name: 'nomor'},
                        {data: 'tgl', name: 'tgl'},
                        {data: 'qty', name: 'qty'},
                        {data: 'lama', name: 'lama'},
                        {data: 'status', name: 'status'},
                        {data: 'total', name: 'total'},
                        {
                            data: 'action', 
                            name: 'action', 
                            orderable: true, 
                            searchable: true
                        },
                    ]
                });
            });
        
        $("#field-tgl").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            locale : "id",
            defaultDate : new Date(),
            minDate: "today"
        });
        </script>
    @endpush
</x-landing-layout>