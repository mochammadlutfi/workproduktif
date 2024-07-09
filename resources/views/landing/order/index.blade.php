<x-landing-layout>
    <div class="content content-full">
        <nav class="breadcrumb push rounded-pill py-2 mb-4">
            <a class="breadcrumb-item" href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-item active">Semua Kategori</span>
        </nav>
        <div class="block block-rounded">
            <div class="block-content p-4">
                <table class="table" id="datatables">

                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>

        </script>
    @endpush
</x-landing-layout>