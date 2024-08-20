<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill py-2 mb-4">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-item active">Ubah Profil</span>
        </nav>
        <div class="block block-rounded">
            <div class="block-content p-4">
                <form method="post" action="{{ route('profil.edit') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <x-input-field type="text" name="nama" id="nama" label="Nama Lengkap" value="{{ $data->nama }}"/>
                            <x-input-field type="text" name="perusahaan" id="perusahaan" label="Perusahaan" value="{{ $data->perusahaan }}"/>
                            <x-input-field type="text" name="jabatan" id="jabatan" label="Jabatan" value="{{ $data->jabatan }}"/>
                            <x-input-field type="text" name="email" id="email" label="Alamat Email" value="{{ $data->email }}"/>

                        </div>
                        <div class="col-md-6">
                            <x-input-field type="text" name="telp" id="telp" label="No Telpon" value="{{ $data->hp }}"/>
                            <div class="mb-4">
                                <label for="field-alamat">Alamat Lengkap</label>
                                <textarea name="alamat" id="field-alamat" rows="4" class="form-control  {{ $errors->has('alamat') ? 'is-invalid' : '' }}">{{ old('alamat', isset($data) ? $data->alamat : '') }}</textarea>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-landing-layout>