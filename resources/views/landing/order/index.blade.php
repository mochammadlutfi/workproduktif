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
                    </tbody>
                </table>
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
        </script>
    @endpush
</x-landing-layout>