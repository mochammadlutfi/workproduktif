<x-landing-layout>
    <div class="bg-primary">
        <div class="content text-center">
            <div class="py-4">
                <h1 class="h2 fw-bold text-white mb-2">Riwayat Pelatihan</h1>
                <h2 class="h5 fw-medium text-white-75">Jejak Perjalanan Pembelajaran Anda!</h2>
            </div>
        </div>
    </div>
    <div class="content content-full">
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-content p-3">
                        <table class="table table-bordered datatable w-100">
                            <thead>
                                <tr>
                                    <th width="60px">No</th>
                                    <th width="400px">Judul</th>
                                    <th width="200px">Tgl Daftar</th>
                                    {{-- <th width="200px">Tgl Training</th> --}}
                                    <th width="250x">Harga</th>
                                    <th>Pembayaran</th>
                                    <th>Status</th>
                                    <th width="130px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script>
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: "{{ route('user.training') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'training.nama', name: 'training.nama'},
                    {data: 'tgl_daftar', name: 'tgl_daftar'},
                    // {data: 'tgl_training', name: 'tgl_training'},
                    {data: 'harga', name: 'harga'},
                    {data: 'status', name: 'status'},
                    {data: 'training.status', name: 'training.status'},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ]
            });
        </script>
    @endpush
</x-landing-layout>