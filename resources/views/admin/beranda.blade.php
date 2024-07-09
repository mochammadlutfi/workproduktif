<x-app-layout>

    <div class="content">
        
    </div>
    @push('scripts')
        <script>
            
            $(function () {
                $('.datatable').DataTable({
                    processing: true,
                    serverSide: false,
                    dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                });
            });
        </script>
    @endpush
</x-app-layout>