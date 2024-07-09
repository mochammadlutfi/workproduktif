<x-landing-layout>
    <div class="content">
        <nav class="breadcrumb push rounded-pill px-4 py-2 mb-0">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-item active">Login</span>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center">
                    <h1 class="h3 fw-bold mb-2">Login Sekarang</h1>
                    <h4 class="h5 fw-medium mb-4">Belum Punya Akun ?
                        <a href="{{ route('register') }}">Daftar Sekarang</a>
                    </h4>
                </div>
                <div class="block block-rounded">
                    <div class="block-content">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label" for="val-email">Alamat Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    id="val-email"
                                    name="email"
                                    placeholder="Masukan Email">
                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="val-password">Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="password"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    id="val-password"
                                    name="password"
                                    placeholder="Masukan password">
                                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 d-sm-flex align-items-center push">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value=""
                                            id="login-remember-me"
                                            name="login-remember-me">
                                        <label class="form-check-label" for="login-remember-me">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-sm-end push">
                                    <button type="submit" class="btn btn-lg btn-alt-primary fw-medium">
                                        Login Sekarang
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>