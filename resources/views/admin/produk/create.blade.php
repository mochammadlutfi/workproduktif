<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="/js/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/js/plugins/flatpickr/flatpickr.min.css">
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
    @endpush

    <div class="content">
        <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="content-heading d-flex justify-content-between align-items-center">
                <span>{{ isset($data) ? 'Edit Training' : 'Tambah Training' }}</span>
                <div class="space-x-1">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check me-1"></i>
                        Simpan
                    </button>
                </div>
            </div>
            <div class="block block-rounded">
                <div class="block-content">
                    <div class="row">
                        <div class="col-6">
                            <div class="img-uploader mb-4">
                                <label>Foto</label>
                                <img id="preview" src="#" alt="Foto" style="display:none;"/>
                                <input type="file" class="form-control" accept="image" name="foto" @error('image') is-invalid @enderror id="selectImage">
                            </div>
                            <x-input-field type="text" id="nama" name="nama" label="Nama" :required="true"/>
                        </div>
                        <div class="col-6">
                            <x-input-field type="text" id="model" name="model" label="Model" :required="true"/>
                            <x-select-field id="kategori" label="Kategori" name="kategori_id"
                            :options="$kategori"
                            />
                            <div class="mb-4">
                                <label for="field-deskripsi">Deskripsi</label>
                                <textarea class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                                    id="field-deskripsi" rows="5" name="deskripsi">{{ old('deskripsi') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-input-field type="text" id="harga_jam" name="harga_jam" label="Harga Per Jam" :required="true"/>
                            <x-input-field type="text" id="min_sewa" name="min_sewa" label="Minimal Sewa" :required="true"/>
                            <x-input-field type="text" id="harga_harian" name="harga_harian" label="Harga Harian" :required="true"/>
                        </div>
                        <div class="col-md-6">
                        <x-input-field type="text" id="harga_mingguan" name="harga_mingguan" label="Harga Mingguan" :required="true"/>
                        <x-input-field type="text" id="harga_bulanan" name="harga_bulanan" label="Harga Bulanan" :required="true"/>
                        <x-input-field type="text" id="harga_operator" name="harga_operator" label="Harga Operator Harian" :required="true"/>
                        </div>
                    </div>
                    <table class="table table-bordered" id="spek">
                        <thead>
                            <tr>
                                <th>Label</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="spek[0][label]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="spek[0][nilai]">
                                </td>
                                <td colspan="3">
                                    {{-- <button class="btn btn-danger w-100" type="button" id="btn-add">
                                        <i class="fa fa-times"></i>
                                    </button> --}}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <button class="btn btn-primary w-100" type="button" onclick="add_row()">
                                        <i class="fa fa-plus"></i>
                                        Tambah Spesifikasi
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
    </div>


    @push('scripts')
    <script src="/js/plugins/select2/js/select2.full.min.js"></script>
    <script src="/js/plugins/flatpickr/flatpickr.min.js"></script>
    <script src="/js/plugins/flatpickr/l10n/id.js"></script>
    <script>

        selectImage.onchange = evt => {
            preview = document.getElementById('preview');
            preview.style.display = 'block';
            const [file] = selectImage.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }

        $('#field-kategori').select2();

        $('#field-jadwal').select2({
            multiple : true,
        });
        
        $(".tgl").flatpickr({
            altInput: true,
            altFormat: "j F Y H:i",
            dateFormat: "Y-m-d H:i",
            locale : "id",
            enableTime: true,
            time_24hr: true
        });

        
        $("#field-tgl_daftar").flatpickr({
            altInput: true,
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            locale : "id",
            mode: "range"
        });

        
        $("#field-tgl_training").flatpickr({
            altInput: true,
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            locale : "id",
            mode: "range"
        });


        $(".time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        function add_row()
        {
            $rowno= ($("#spek tbody tr").length == 1) ? 0 : 1;
            $rowno=$rowno+1;
            $row = "<tr id='row"+$rowno+"' class='bb'>";
            $row += `<td><input type="text" class="form-control" name="spek[${ $rowno }][label]"></td>`;
            $row += `<td><input type="text" class="form-control" name="spek[${ $rowno }][value]"></td>`;
            $row += `<td><button type="button" class="btn btn-danger w-100" onclick=delete_row('row${ $rowno }')><i class="fa fa-times"></i></button></td>`;
            $row += "</tr>"
            $("#spek tbody tr:last").after($row);
        }
        function delete_row(rowno)
        {
            $('#'+rowno).remove();
        }

    </script>
    @endpush
</x-app-layout>

