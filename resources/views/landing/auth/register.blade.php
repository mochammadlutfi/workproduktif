<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill px-4 py-2 mb-0">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-item active">Pendaftaran</span>
        </nav>
        <div class="row justify-content-center mt-2">
            <div class="col-md-8">
                <div class="block block-rounded">
                    <div class="block-content">
                        <div class="text-center">
                            <h1 class="h3 fw-bold mb-2">Daftar Akun</h1>
                            <h4 class="h5 fw-medium mb-4">Sudah Punya Akun ?
                                <a href="{{ route('login') }}">Login Disini</a>
                            </h4>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
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
                            
                            <div class="mb-4">
                                <button type="submit" class="btn btn-lg btn-primary fw-medium w-100">
                                    Daftar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>