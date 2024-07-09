<x-landing-layout>
    <div class="bg-white">
        <div class="content content-full">
            <nav class="breadcrumb push rounded-pill py-2 mb-4">
                <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
                <a class="breadcrumb-item" href="{{ route('produk.kategori', $data->kategori->slug) }}">{{ $data->kategori->nama}}</a>
                <span class="breadcrumb-item active">{{ $data->nama}}</span>
            </nav>
            <div class="row">
                <div class="col-md-8">
                    <h1 class="fs-2 fw-bold">{{ $data->nama }}</h1>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <img src="{{ $data->foto }}" class="img-fluid"/>
                        </div>
                        <div class="col-md-8">
                            <h2 class="fs-lg fw-bold">{{ $data->model }}</h2>
                            <p class="text-muted">{{ $data->deskripsi }}</p>
                        </div>
                    </div>
                    <div class="row g-0 mb-4 text-center">
                        <div class="col-md-4">
                            <div class="fs-sm">
                                Harga Sewa Per Jam
                            </div>
                            <div class="fs-4 fw-bold">
                                {{ $data->harga_jam }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fs-sm">
                                Minimum Sewa
                            </div>
                            <div class="fs-4 fw-bold">
                                {{ $data->min_sewa }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fs-sm">
                                Harian Operator
                            </div>
                            <div class="fs-4 fw-bold">
                                {{ $data->harga_operator }}
                            </div>
                        </div>
                    </div>
                    @if($data->spesifikasi)
                    <h3 class="fs-4 mb-3">Spesifikasi Alat</h3>
                    <table class="table table-bordered">
                        @foreach (json_decode($data->spesifikasi) as $s)
                                <tr>
                                    <td>{{ $s->label }}</td>
                                    <td>{{ $s->value }}</td>
                                </tr>                       
                        @endforeach
                    </table>     
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded border border-3 shadow-sm">
                        <div class="block-content p-3">
                            @if(auth()->guard('web')->user())
                            <button type="button" class="btn btn-primary btn-lg w-100" onclick="openModal()">
                                Sewa Sekarang
                            </button>
                            @else
                            <a class="btn btn-primary btn-lg w-100" href="{{ route('login') }}">
                                Sewa Sekarang
                            </a>
                            @endif
                        </div>
                        <div class="block-content p-3 border-top border-3">
                            <div class="fs-base fw-bold">Alat berat lainya</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openModal(){
                alert('sadas')
            }
        </script>
    @endpush
</x-landing-layout>