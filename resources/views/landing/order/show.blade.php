<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill py-2 mb-4">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ route('order.index') }}">Pesanan Saya</a>
            <span class="breadcrumb-item active">{{ $data->nomor }}</span>
        </nav>
        <div class="block block-rounded">
            <div class="block-header border-bottom border-2">
                <h3 class="block-title">Detail Pesanan</h3>
                <div class="block-options">
                    {{-- <a class="btn btn-primary" href="{{ route('order.invoice', $data->id) }}">
                        Download Invoice
                    </a> --}}
                    <a class="btn btn-primary" href="{{ $data->kontrak }}">
                        Download Kontrak
                    </a>
                </div>
            </div>
            
            @if ($data->status == 'Pending')
            <div class="block-content text-center p-4">
                <h3>Menunggu Konfirmasi Admin</h3>
                <p>Terimakasih sudah melakukan pemesanan, kami akan segera menghubungi kamu dalam 2x24 Jam</p>
            </div>
            @elseif ($data->status == 'Diterima')
                @if($data->kontrak)
                <div class="block-content text-center p-4">
                    <h3>Menunggu Pembayaran</h3>
                    <p>Mohon selesaikan pembayaran anda ke salah satu no rekening dibawah sebelum tanggal <b>{{ \Carbon\Carbon::parse($data->tgl)->addDay(7)->translatedFormat('d F Y') }}</b></p>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="block block-rounded border border-3">
                                <div class="block-content p-4">
                                    <img src="/images/bca.png" class="img-fluid w-75">
                                    <div class="fs-base">No Rekening</div>
                                    <div class="fs-base fw-bold">4490052475</div>
                                    <div class="fs-sm">A.n  <span class="fw-bold">A Fathur Muhammad Z S Kawerang</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="block block-rounded border border-3">
                                <div class="block-content p-4">
                                    <img src="/images/mandiri.png" class="img-fluid w-75">
                                    <div class="fs-base">No Rekening</div>
                                    <div class="fs-base fw-bold">1300022254687</div>
                                    <div class="fs-sm">A.n  <span class="fw-bold">A Fathur Muhammad Z S Kawerang</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>Jumlah yang minimal harus dibayar sebesar:</p>
                    <h3 class="fs-3">
                        Rp {{ number_format($data->total *0.5,0,',','.') }}
                    </h3>
                    <p>Jika sudah melakukan pembayaran silahkan konfirmasi pembayaran disini</p>
                    <a class="btn btn-primary px-3 rounded-pill" href="{{ route('order.payment', $data->id) }}">
                        Konfirmasi Pembayaran
                    </a>
                </div>
                @else
                <div class="block-content text-center p-4">
                    <h3>Upload Surat Kontrak</h3>
                    <p>Kami telah mengirimkan surat kontrak ke email anda, segera upload surat kontrak yang sudah dilegalisir dibawah ini</p>
                    <form action="{{ route('order.upload', $data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <x-input-field type="file" label="Dokumen Kontrak" name="file" id="file"></x-input-field>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                        Kirim
                        </button>
                    </form>

                </div>
                @endif
            @endif
            @if ($data->status != 'Pending')
            <div class="block-content p-4">
                <div class="row">
                    <div class="col-md-6">
                        <x-field-read label="Nomor Pesanan" value="{{ $data->nomor }}"/>
                        <x-field-read label="Tanggal Penggunaan" value="{{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y') }}"/>
                        <x-field-read label="Produk" value="{{ $data->produk->nama }}"/>
                        <x-field-read label="Lama Sewa" value="{{ $data->lama }} Jam"/>
                        <x-field-read label="Jumlah Unit" value="{{ $data->qty }}"/>
                        <x-field-read label="Lokasi Proyek" value="{{ $data->lokasi }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-field-read label="Total Harga Unit" value="Rp {{ number_format($data->harga_unit,0,',','.') }}"/>
                        <x-field-read label="Total Harga Operator" value="Rp {{ number_format($data->harga_operator,0,',','.') }}"/>
                        <x-field-read label="Total Tagihan" value="Rp {{ number_format($data->total,0,',','.') }}"/>
                        <x-field-read label="Sudah Dibayar" value="Rp {{ number_format($data->dibayar,0,',','.') }}"/>
                        <x-field-read label="Sisa Tagihan" value="Rp {{ number_format($data->total - $data->dibayar,0,',','.') }}"/>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @if ($data->pembayaran->count())
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">Informasi Pembayaran</h3>
                <div class="block-options">
                    <a
                        href="{{ route('order.payment', $data->id) }}"
                        class="btn btn-sm btn-primary">
                        Tambah Pembayaran
                    </a>
                </div>
            </div>
            <div class="block-content p-4">
                <table class="table table-bordered datatable w-100 table-vcenter">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th width="60px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->pembayaran as $d)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->Tgl)->translatedFormat('d F Y') }}</td>
                            <td>Rp. {{ number_format($d->jumlah,0,',','.') }}</td>
                            <td>
                                @if($d->status == 'pending')
                                    <span class="badge bg-danger">Menunggu Konfirmasi</span>
                                @elseif($d->status == 'terima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($d->status == 'tolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('order.payment.show', ['id' => $data->id, 'payment_id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
    @push('scripts')
        <script>

            $(function () {
                $('.datatable').DataTable({
                    dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                });
            });
        </script>
    @endpush
</x-landing-layout>