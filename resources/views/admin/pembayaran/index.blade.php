<x-app-layout>
    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Data Pembayaran</span>
            <div class="space-x-1">
                <a type="button" class="btn btn-sm btn-primary" href="{{ route('admin.payment.create') }}">
                    <i class="fa fa-plus me-1"></i>
                    Tambah Pembayaran
                </a>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-3">
                <table class="table table-bordered datatable w-100">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Konsumen</th>
                            <th>No Pemesanan</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div
        class="modal"
        id="modal-show"
        tabindex="-1"
        aria-labelledby="modal-show"
        style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-payment"  onsubmit="return false;" enctype="multipart/form-data">
                    <div class="block block-rounded shadow-none mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Detail Pembayaran</h3>
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
                        <div class="block-content fs-sm" id="detailPembayaran">
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
                    processing: true,
                    serverSide: true,
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'r" +
                            "ow'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    ajax: "{{ route('admin.payment.index') }}",
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        }, {
                            data: 'order.user.nama',
                            name: 'order.user.nama'
                        }, {
                            data: 'order.nomor',
                            name: 'order.nomor'
                        }, {
                            data: 'created_at',
                            name: 'created_at'
                        }, {
                            data: 'jumlah',
                            name: 'jumlah'
                        }, {
                            data: 'status',
                            name: 'status'
                        }, {
                            data: 'action',
                            name: 'action'
                        }
                    ]
                });
            });

            $('#field-booking_id').select2({
                dropdownParent: $("#modal-form")
            });

            function addPayment(){
                var modalForm = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-form'));
                modalForm.show();
            }

            function modalShow(id){
                $.ajax({
                    url: "/admin/pembayaran/"+id,
                    type: "GET",
                    dataType: "html",
                    success: function (response) {
                        var el = document.getElementById('modal-show');
                        $("#detailPembayaran").html(response);
                        var myModal = bootstrap.Modal.getOrCreateInstance(el);
                        myModal.show();
                    },
                    error: function (error) {
                    }

                });
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
                            url: "/admin/pembayaran/"+ id +"/delete",
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
                                        window.location.replace("{{ route('admin.payment.index') }}");
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

