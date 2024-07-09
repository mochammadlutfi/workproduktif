<x-landing-layout>
    <div class="bg-primary">
        <div class="content text-center">
            <div class="pt-5 pb-5">
                <h1 class="h2 fw-bold text-white mb-2">Profil Saya</h1>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content p-3">
                <form method="post" action="{{ route('register') }}">
                    @csrf
                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label" for="field-nama">Nama Lengkap</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                                id="field-nama" name="nama" placeholder="Masukan Nama Lengkap"
                                value="{{ old('nama', isset($data) ? $data->nama : '') }}">
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label" for="field-jk">Jenis Kelamin</label>
                        <div class="col-sm-6">
                            <select class="form-select {{ $errors->has('jk') ? 'is-invalid' : '' }}"
                                id="field-jk" style="width: 100%;" name="jk">
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jk' == 'L') ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="P" {{ old('jk' == 'P') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('jk')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label" for="field-hp">No HP / WA</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control {{ $errors->has('hp') ? 'is-invalid' : '' }}"
                                id="field-hp" name="hp" placeholder="Masukan No Handphone"
                                value="{{ old('hp', isset($data) ? $data->hp : '') }}">
                            <x-input-error :messages="$errors->get('hp')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label" for="field-email">Alamat Email</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                id="field-email" name="email" placeholder="Masukan Alamat Email"
                                value="{{ old('email', isset($data) ? $data->email : '') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label" for="field-alamat">Alamat Lengkap</label>
                        <div class="col-sm-6">
                            <textarea name="alamat" id="field-alamat" rows="4" class="form-control  {{ $errors->has('alamat') ? 'is-invalid' : '' }}">{{ old('alamat', isset($data) ? $data->alamat : '') }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
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