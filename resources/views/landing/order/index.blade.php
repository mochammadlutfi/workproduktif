<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill py-2 mb-4">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-item active">Pesanan Saya</span>
        </nav>
        <div class="block block-rounded">
            <div class="block-content p-4">
                <table class="table table-bordered datatable w-100">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>No Pesanan</th>
                            <th>Tanggal</th>
                            <th>Unit</th>
                            <th>Lama</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th width="60px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td>{{  $loop->index+1 }}</td>
                            <td>{{  $d->nomor }}</td>
                            <td>{{  \Carbon\Carbon::parse($d->tgl)->translatedFormat('d F Y') }}</td>
                            <td>{{  $d->qty }}</td>
                            <td>
                                {{  $d->lama }} Jam <br/>
                                ({{ $d->durasi }})
                            </td>
                            <td>
                                @if($d->status == "Pending")
                                <span class="badge bg-warning">Menunggu</span>
                                @elseif($d->status == 'Diterima')
                                <span class="badge bg-primary">Diproses</span>
                                @elseif($d->status == 'Berlangsung')
                                <span class="badge bg-primary">Berlangsung</span>
                                @elseif($d->status == 'Selesai')
                                <span class="badge bg-success">Selesai</span>
                                @elseif($d->status == 'Ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>Rp {{  number_format($d->total,0,'.', ',') }}</td>
                            <td>
                                <a href="{{ route('order.show', $d->id)}}" class="btn btn-primary">
                                Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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