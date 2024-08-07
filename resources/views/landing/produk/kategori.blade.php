<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill py-2 mb-4">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-item active">{{ $kategori->nama}}</span>
        </nav>
        <div class="row g-2">
            @foreach ($data as $d)
            <div class="col-md-6">
                <div class="block rounded block-fx-shadow">
                    <div class="block-content p-3">
                        <div class="row g-2">
                            <div class="col-4">
                                <img src="{{ $d->foto }}" class="img-fluid"/>
                            </div>
                            <div class="col-8">
                                <h2 class="fs-lg fw-bold mb-0">{{ $d->nama }}</h2>
                                <h3 class="fs-base">{{ $d->model }}</h3>
                                <div class="row g-2 text-center mb-3">
                                    <div class="col-md-4">
                                        <div class="fs-xs">
                                            Harga Sewa /Jam
                                        </div>
                                        <div class="fs-5 fw-bold">
                                            Rp {{  number_format($d->harga_jam,0,',','.') }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fs-xs">
                                            Minimum Sewa 
                                        </div>
                                        <div class="fs-5 fw-bold">
                                            {{ $d->min_sewa }} Jam
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fs-xs">
                                            Harian Operator
                                        </div>
                                        <div class="fs-5 fw-bold">
                                            Rp {{  number_format($d->operator_hari,0,',','.') }}
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('produk.show', ['kategori' => $d->kategori->slug, 'slug' => $d->slug]) }}" class="btn btn-primary w-100">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-landing-layout>