<x-landing-layout>
    <div class="bg-image" style="background-image: url('/images/front.jpg');">
        <div class="bg-black-50">
            <div class="position-relative d-flex align-items-center">
                <div class="content content-full">
                    <div class="row g-6 w-100 py-3 overflow-hidden">
                        <div class="col-md-4 order-md-last py-4 d-md-flex align-items-md-center justify-content-md-end">
                            <img class="img-fluid" src="/images/front.png" alt="Hero Promo">
                        </div>
                        <div class="col-md-8 py-4 d-flex align-items-center">
                            <div class="text-center text-white text-md-start">
                                <h3 class="mb-2 fw-medium">Selamat Datang</h3>
                                <h1 class="fw-bold fs-2 mb-3">
                                    Cari Rental Alat Berat Online?
                                </h1>
                                <a class="btn btn-primary py-3 px-4" href="#catalog">
                                    <i class="fa fa-arrow-right opacity-50 me-1"></i> Cari Alat Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-body-light">
        
        <div class="content content-full">
            <div class="pt-5 pb-5">
                <div class="position-relative">
                    <h2 class="fw-bold text-center mb-2">
                        Pilihan Rental Beragam Alat Berat
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center push">
                @foreach ($kategori as $d)
                <div class="col-4 col-md-2">
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
    </div>
</x-landing-layout>