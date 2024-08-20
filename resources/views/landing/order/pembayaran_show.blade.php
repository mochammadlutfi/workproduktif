<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill py-2 mb-4">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ route('order.index') }}">Pesanan Saya</a>
            <a class="breadcrumb-item" href="{{ route('order.show', $data->order_id) }}">{{ $data->order->nomor }}</a>
            <span class="breadcrumb-item active">Detail Pembayaran</span>
        </nav>
        <div class="block block-rounded">
            <div class="block-content p-3">
                <div class="row">
                    <div class="col-md-6">
                        <x-field-read label="No Pesanan" value="{{ $data->order->nomor }}"/>
                        <x-field-read label="Tanggal Daftar" value="{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}"/>
                        <x-field-read label="Tanggal Pembayaran" value="{{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y') }}"/>
                        <x-field-read label="Tujuan Pembayaran" value="{{ $data->bank }}"/>
                        <x-field-read label="Jumlah Pembayaran" value="Rp {{  number_format($data->jumlah,0,',','.') }}"/>
                            <x-field-read label="A.n Pengirim" value="{{ $data->pengirim }}"/>
                            
                        <x-field-read label="Status">
                            <x-slot name="value">
                                @if($data->status == 'pending')
                                    <span class="badge bg-warning px-3">Pending</span>
                                @elseif($data->status == 'terima')
                                <span class="badge bg-success px-3">Diterima</span>
                                @elseif($data->status == 'tolak')
                                <span class="badge bg-danger px-3">Ditolak</span>
                                @endif
                            </x-slot>
                        </x-field-read>

                    </div>
                    <div class="col-md-6">
                        <a href="{{ $data->bukti }}" data-lightbox="image-1" data-title="My caption">
                            <img src="{{ $data->bukti }}" class="w-25"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
        </script>
    @endpush
</x-landing-layout>