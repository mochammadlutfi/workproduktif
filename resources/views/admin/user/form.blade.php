<x-app-layout>
    @push('styles')
    @endpush

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">Tambah Konsumen</h3>
            </div>
            <div class="block-content p-4">
                <form method="POST" action="{{ route('admin.user.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <x-input-field type="text" name="nama" id="nama" label="Nama Lengkap"/>
                            <x-input-field type="text" name="jabatan" id="jabatan" label="Jabatan"/>
                            <x-input-field type="text" name="email" id="email" label="Alamat Email"/>
                        </div>
                        <div class="col-md-6">
                            <x-input-field type="text" name="perusahaan" id="perusahaan" label="Perusahaan"/>
                            <x-input-field type="text" name="hp" id="hp" label="No Handphone"/>
                            <x-input-field type="password" name="password" id="password" label="Password"/>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="field-alamat">Alamat Lengkap</label>
                        <textarea name="alamat" id="field-alamat" rows="4" class="form-control  {{ $errors->has('alamat') ? 'is-invalid' : '' }}">{{ old('alamat', isset($data) ? $data->alamat : '') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check me-1"></i>
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="/js/plugins/flatpickr/flatpickr.min.js"></script>
    <script src="/js/plugins/flatpickr/l10n/id.js"></script>
    <script src="/js/plugins/ckeditor5-classic/build/ckeditor.js"></script>
    <script>
        
        $("#field-tgl_lahir").flatpickr({
            altInput: true,
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            locale : "id",
        });
    </script>
    @endpush
</x-app-layout>

