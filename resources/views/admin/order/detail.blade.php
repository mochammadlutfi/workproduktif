<x-app-layout>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header border-bottom border-2">
                <h3 class="block-title">Detail Pesanan</h3>
                <div class="block-options">
                    <a class="btn btn-primary" href="{{ route('admin.order.invoice', $data->id) }}">
                        Download Invoice
                    </a>
                    <a class="btn btn-primary" href="{{ route('admin.order.kontrak', $data->id) }}">
                        Download Kontrak
                    </a>
                </div>
            </div>
            <div class="block-content p-3">
                <div class="row">
                    <div class="col-md-6">
                        <x-field-read label="Nomor Pesanan" value="{{ $data->nomor }}"/>
                        <x-field-read label="Tanggal Penggunaan" value="{{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y') }}"/>
                        <x-field-read label="Produk" value="{{ $data->produk->nama }}"/>
                        <x-field-read label="Lama Sewa" value="{{ $data->lama }} Jam"/>
                        <x-field-read label="Jumlah Unit" value="{{ $data->qty }}"/>
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
        </div>
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">Informasi Pembayaran</h3>
                <div class="block-options">
                    <a
                        href="{{ route('admin.payment.create') }}"
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
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        $(function () {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'r" +
                        "ow'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: {
                    url : "{{ route('admin.payment.index') }}",
                    data : function(data){
                        data.booking_id = "{{ $data->id }}";
                    },
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'tgl',
                        name: 'tgl'
                    }, {
                        data: 'jumlah',
                        name: 'jumlah'
                    }, {
                        data: 'status',
                        name: 'status'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    }
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

        
        function updateStatus(id, status, booking_id){
            // console.log(status);
            $.ajax({
                url: "/admin/pembayaran/"+id +"/status",
                type: "POST",
                data : {
                    booking_id : booking_id,
                    status : status,
                    _token : $("meta[name='csrf-token']").attr("content"),
                },
                success: function (response) {
                    // console.log(response);
                    location.reload();
                    var el = document.getElementById('modal-show');
                    $('.datatable').DataTable().ajax.reload();
                    // $("#detailPembayaran").html(response);
                    var myModal = bootstrap.Modal.getOrCreateInstance(el);
                    myModal.hide();
                },
                error: function (error) {
                }
            });
        }

        $("#form-payment").on("submit",function (e) {
            e.preventDefault();
            var fomr = $('form#form-payment')[0];
            var formData = new FormData(fomr);
            let token   = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', token);

            $.ajax({
                url: "{{ route('admin.payment.store') }}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.fail == false) {
                        $('.datatable').DataTable().ajax.reload();
                        var myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-normal'));
                        myModal.hide();
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
    </script>
    @endpush

</x-app-layout>

