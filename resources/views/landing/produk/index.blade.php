<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill px-4 py-2 mb-0">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-item active">Semua Kategori</span>
        </nav>
        <div class="row justify-content-center push">
            @foreach ($data as $d)
            <div class="col-3 g-2 col-md-2">
                <a class="block block-link block-rounded block-fx-shadow block-bordered" href="{{ route('produk.kategori', $d->slug)}}">
                    <div class="block-content p-0">
                        <img src="{{ $d->foto }}" class="img-fluid"/>
                    </div>
                    <div class="block-content">
                        <h2 class="fs-base">{{ $d->nama }}</h2>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</x-landing-layout>