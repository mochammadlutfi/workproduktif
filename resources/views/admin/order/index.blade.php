<x-app-layout>
    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Data Pesanan</span>
            <div class="space-x-1">
                <a href="{{ route('admin.order.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus me-1"></i>
                    Tambah Pesanan
                </a>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#reportModal">
                    <i class="fa fa-print me-1"></i>
                    Download Report
                </button>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-3">
                <table class="table table-bordered datatable w-100">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>No Pesanan</th>
                            <th>Konsumen</th>
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
                            <td>{{  $d->user->nama }}</td>
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
                                <div class="dropdown">
                                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle"
                                        id="dropdown-default-outline-primary" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-default-outline-primary">
                                        <a class="dropdown-item" href="{{ route('admin.order.show', $d->id)}}">
                                            <i class="si si-note me-1"></i>Detail
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.order.edit', $d->id)}}">
                                            <i class="si si-note me-1"></i>Ubah
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="hapus({{ $d->id}})">
                                            <i class="si si-trash me-1"></i>Hapus
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog rounded">
            <div class="modal-content rounded">
                <form action="{{ route('admin.order.report') }}" method="GET">
                    <div class="block rounded shadow-none mb-0">
                        <div class="block-header bg-body rounded-top">
                            <h3 class="block-title " id="modalFormTitle">Download Report</h3>
                            <div class="block-options">
                                <button type="button" class=" btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <x-input-field type="text" name="tgl" id="tgl" label="Periode Tanggal"/> 
                        </div>
                        <div class="block-content block-content-full block-content-sm text-end border-top">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                              Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Download
                            </button>
                          </div>
                    </div>
                </form>
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
        $("#field-tgl").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            locale : "id",
            defaultDate: [new Date(Date.now() - 7 * 24 * 60 * 60 * 1000), new Date()],
            mode: "range"
        });
        function hapus(id){
            Swal.fire({
                icon : 'warning',
                text: 'Hapus Data?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: `Tidak, Jangan!`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/pelanggan/"+ id +"/delete",
                        type: "DELETE",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function(data) {
                            if(data.fail == false){
                                Swal.fire({
                                    toast : true,
                                    title: "Berhasil",
                                    text: "Data Berhasil Dihapus!",
                                    timer: 1500,
                                    showConfirmButton: false,
                                    icon: 'success',
                                    position : 'top-end'
                                }).then((result) => {
                                    window.location.replace("{{ route('admin.user.index') }}");
                                });
                            }else{
                                Swal.fire({
                                    toast : true,
                                    title: "Gagal",
                                    text: "Data Gagal Dihapus!",
                                    timer: 1500,
                                    showConfirmButton: false,
                                    icon: 'error',
                                    position : 'top-end'
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire({
                                    toast : true,
                                    title: "Gagal",
                                    text: "Terjadi Kesalahan Di Server!",
                                    timer: 1500,
                                    showConfirmButton: false,
                                    icon: 'error',
                                    position : 'top-end'
                                });
                        }
                    });
                }
            })
        }
        </script>
    @endpush

</x-app-layout>

