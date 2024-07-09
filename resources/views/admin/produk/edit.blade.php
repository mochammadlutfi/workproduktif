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
        <form method="POST" action="{{ route('admin.training.update',  $data->id) }}" enctype="multipart/form-data">
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
                        <div class="col-8">
                            <div class="mb-4">
                                <label for="field-nama">Nama Training</label>
                                <input type="text" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                                    id="field-nama" name="nama" placeholder="Masukan Nama Training" value="{{ old('nama', $data->nama) }}">
                                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label for="field-lokasi">Lokasi</label>
                                <input type="text" class="form-control {{ $errors->has('lokasi') ? 'is-invalid' : '' }}"
                                    id="field-lokasi" name="lokasi" placeholder="Masukan Lokasi Training" value="{{ old('lokasi', $data->lokasi) ?? '' }}">
                                <x-input-error :messages="$errors->get('tempat')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label for="field-deskripsi">Deskripsi</label>
                                <textarea class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                                    id="field-deskripsi" name="deskripsi"
                                    placeholder="Masukan deskripsi">{{ old('deskripsi', $data->deskripsi) }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>
                            <div class="mb-3">
                                <label>Dokumen Silabus</label>
                                <img id="preview" src="#" alt="dokumen" class="img-fluid mb-2" style="display:none;"/>
                                <input type="file" class="form-control" name="document" @error('document') is-invalid @enderror id="selectDocument">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-4">
                                <label for="field-jadwal">Kuota</label>
                                <input type="number" name="slot" class="form-control  {{ $errors->has('slot') ? 'is-invalid' : '' }}" value="{{ old('slot', $data->slot) }}">
                                <x-input-error :messages="$errors->get('slot')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label for="field-tgl_daftar">Tgl Pendaftaran</label>
                                <input type="text" class="form-control {{ $errors->has('tgl_daftar') ? 'is-invalid' : '' }}"
                                    id="field-tgl_daftar" name="tgl_daftar" placeholder="Masukan Tanggal Daftar" value="{{ old('tgl_daftar', $data->tgl_daftar) ?? '' }}">
                                <x-input-error :messages="$errors->get('tgl_daftar')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label for="field-tgl_training">Tgl Training</label>
                                <input type="text" class="form-control {{ $errors->has('tgl_training') ? 'is-invalid' : '' }}"
                                    id="field-tgl_training" name="tgl_training" placeholder="Masukan Tanggal Training" value="{{ old('tgl_training', $data->tgl_training) ?? '' }}">
                                <x-input-error :messages="$errors->get('tgl_training')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label for="field-harga">Harga</label>
                                <input type="number" name="harga" class="form-control  {{ $errors->has('harga') ? 'is-invalid' : '' }}" value="{{ old('harga', $data->harga) }}">
                                <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label for="field-status">Status</label>
                                <select class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                    id="field-status" style="width: 100%;" name="status" data-placeholder="Pilih Status">
                                    <option value="draft">Draft</option>
                                    <option value="buka">Dibuka</option>
                                    <option value="penuh">Penuh</option>
                                    <option value="tutup">Tutup</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label for="field-kategori">Kategori</label>
                                <select class="form-select {{ $errors->has('kategori') ? 'is-invalid' : '' }}"
                                    id="field-kategori" style="width: 100%;" name="kategori" data-placeholder="Pilih Kategori">
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                            </div>
                            <div class="mb-3">
                                <label>Foto</label>
                                <img id="preview" src="{{ ($data->foto) ? $data->foto : "#" }}" alt="Foto" class="img-fluid mb-2" style="{{ ($data->foto) ? "display:block;" : "display:none;" }}"/>
                                <input type="file" class="form-control" name="foto" @error('image') is-invalid @enderror id="selectImage">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    @push('scripts')
    <script src="/js/plugins/select2/js/select2.full.min.js"></script>
    <script src="/js/plugins/flatpickr/flatpickr.min.js"></script>
    <script src="/js/plugins/flatpickr/l10n/id.js"></script>
    <script src="/js/plugins/ckeditor5-classic/build/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
    <script>
        
        selectImage.onchange = evt => {
            preview = document.getElementById('preview');
            preview.style.display = 'block';
            const [file] = selectImage.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }

        ClassicEditor
        .create( document.querySelector('#field-deskripsi'))
        .catch( error => {
            console.error( error );
        } );
        
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


    </script>
    @endpush
</x-app-layout>

