<x-app-layout>
    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Data Peserta {{ $data->nama }}</span>
            <div class="space-x-1">
                <button type="button" class="btn btn-sm btn-primary" onclick="add()">
                    <i class="fa fa-plus me-1"></i>
                    Tambah Peserta
                </button>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-3">
                <table class="table table-bordered datatable w-100">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Tgl Daftar</th>
                            <th>Status</th>
                            <th width="60px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
                    <form id="form-peserta"  onsubmit="return false;" enctype="multipart/form-data">
                        <div class="block block-rounded shadow-none mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Tambah Peserta</h3>
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
                                <div class="mb-4">
                                    <label for="field-user_id">Pengguna</label>
                                    <select class="form-select" id="field-user_id" style="width: 100%;" name="user_id"
                                        data-placeholder="Pilih Pengguna">
                                        @foreach ($user as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="error-user_id">Invalid feedback</div>
                                </div>
                                <div class="mb-4">
                                    <label for="field-status">Status</label>
                                    <select class="form-select" id="field-status" style="width: 100%;" name="status"
                                        data-placeholder="Pilih Status">
                                        <option value="belum bayar">Belum Bayar</option>
                                        <option value="lunas">Lunas</option>
                                        <option value="selesai">Selesai</option>
                                        <option value="batal">Batal</option>
                                    </select>
                                    <div class="invalid-feedback" id="error-status">Invalid feedback</div>
                                </div>
                                <div
                                    class="block-content block-content-full block-content-sm text-end border-top">
                                    <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-alt-primary" id="btn-simpan">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
                    ajax: "{{ route('admin.training.peserta', $data->id) }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'user.nama', name: 'user.nama'},
                        {data: 'user.hp', name: 'user.hp'},
                        {data: 'user.email', name: 'user.email'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'status', name: 'status'},
                        {
                            data: 'action', 
                            name: 'action', 
                            orderable: true, 
                            searchable: true
                        },
                    ]
                });
            });
            
            $("#form-peserta").on("submit",function (e) {
                e.preventDefault();
                var fomr = $('form#form-peserta')[0];
                var formData = new FormData(fomr);
                let token   = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', token);

                $.ajax({
                    url: "{{ route('admin.training.peserta.store', $data->id) }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.fail == false) {
                            location.reload();
                        } else {
                            for (control in response.errors) {
                                $('#field-' + control).addClass('is-invalid');
                                $('#error-' + control).html(response.errors[control]);
                            }
                        }
                    },
                    error: function (error) {
                    }

                });

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
                            url: "/admin/training/"+ id +"/peserta/delete",
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
                                        location.reload();
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

            function add(){
                var modal = document.getElementById('modal-form');
                var modalForm = bootstrap.Modal.getOrCreateInstance(modal);
                modalForm.show();
            }
        </script>
    @endpush

</x-app-layout>

