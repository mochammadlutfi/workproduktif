<x-app-layout>
    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Produk</span>
            <div class="space-x-1">
                <a href="{{ route('admin.produk.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus me-1"></i>
                    Tambah Produk
                </a>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-3">
                <table class="table table-bordered datatable w-100">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th width="400px">Nama</th>
                            <th width="230px">Model</th>
                            <th width="200px">Kategori</th>
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
                    ajax: "{{ route('admin.produk.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama'},
                        {data: 'model', name: 'model'},
                        {data: 'kategori.nama', name: 'kategori.nama'},
                        {
                            data: 'action', 
                            name: 'action', 
                            orderable: true, 
                            searchable: true
                        },
                    ]
                });
            });
            
        $("#modal-status").on("submit",function (e) {
            e.preventDefault();
            var fomr = $('form#form-status')[0];
            var formData = new FormData(fomr);
            let token   = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', token);

            $.ajax({
                url: "/admin/Produk/status",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.fail == false) {
                        $('.datatable').DataTable().ajax.reload();
                        const el = document.getElementById('modal-status');
                        var myModal = bootstrap.Modal.getOrCreateInstance(el);
                        myModal.hide();
                        fomr.reset();
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

        function edit(id, status){

            $("#field-id").val(id);
            $("#field-status").val(status);

            const el = document.getElementById('modal-status');
            const modalForm = bootstrap.Modal.getOrCreateInstance(el);
            modalForm.show();
        }
        
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
                        url: "/admin/produk/"+ id +"/delete",
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
        </script>
    @endpush

</x-app-layout>

