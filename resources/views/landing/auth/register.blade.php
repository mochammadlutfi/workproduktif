<x-landing-layout>
    <div class="content">
        <nav class="breadcrumb push rounded-pill px-4 py-2 mb-0">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-item active">Pendaftaran</span>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center">
                    <h1 class="h3 fw-bold mb-2">Daftar Akun</h1>
                    <h4 class="h5 fw-medium mb-4">Sudah Punya Akun ?
                        <a href="{{ route('login') }}">Login Disini</a>
                    </h4>
                </div>
                <div class="block block-rounded">
                    <div class="block-content">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <x-input-field type="text" name="nama" id="nama" label="Nama Lengkap"/>
                            <x-input-field type="text" name="email" id="email" label="Alamat Email"/>
                            <x-input-field type="text" name="hp" id="hp" label="No Handphone"/>
                            <x-input-field type="password" name="password" id="password" label="Password"/>
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