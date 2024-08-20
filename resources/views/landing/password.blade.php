<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill py-2 mb-4">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-item active">Ubah Profil</span>
        </nav>
        <div class="block block-rounded">
            <div class="block-content p-3">
                <form method="POST" action="{{ route('profil.password') }}">
                    @csrf
                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label" for="field-password_old">Password Lama</label>
                        <div class="col-sm-6">
                            <input type="password"
                                class="form-control {{ $errors->has('password_old') ? 'is-invalid' : '' }}"
                                id="field-password_old" name="password_old">
                            <x-input-error :messages="$errors->get('password_old')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label" for="field-password">Password Baru</label>
                        <div class="col-sm-6">
                            <input type="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                id="field-password" name="password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label" for="field-password_confirmation ">Konfirmasi
                            Password</label>
                        <div class="col-sm-6">
                            <input type="password"
                                class="form-control {{ $errors->has('password_confirmation ') ? 'is-invalid' : '' }}"
                                id="field-password_confirmation " name="password_confirmation">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                        <div class="col-sm-6 text-sm-end push">
                            <button type="submit" class="btn btn-lg btn-alt-primary fw-medium">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-landing-layout>