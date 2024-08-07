<x-app-layout>
    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Detail Pembayaran</span>
            <div class="space-x-1">
                @if ($data->status == 'pending')
                <button type="button" class="btn btn-primary" onclick="updateStatus('terima')">
                    <i class="fa fa-check"></i>
                    Terima
                </button>
                <button type="button" class="btn btn-danger" onclick="updateStatus('tolak')">
                    <i class="fa fa-times"></i>
                    Tolak
                </button>
                @endif
            </div>
        </div>
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

function updateStatus(status){
                var text = '';
                if(status == 'terima'){
                    text = 'Terima pembayaran?';
                }else{
                    text = 'Tolak pembayaran?';
                }

                Swal.fire({
                    icon : 'warning',
                    text: text,
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: `Tidak`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.payment.status', $data->id)}}",
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data : {
                                status : status
                            },
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
                });
            }
        </script>
    @endpush

</x-app-layout>

