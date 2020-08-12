@extends('layouts.app', [
'title' => 'Dashboard',
'activePage' => 'dashboard'
])

@section('content')

@include('layouts.headers.cards')

<div class="container-fluid mt--7">
    <div class="row mt-5">
        @if (Auth::check() && Auth::user()->role == 'Admin')
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Jadwal Kegiatan Belajar Mengajar</h3>

                        </div>
                        <div class="col text-right">
                            <span>{{ Carbon\Carbon::now()->translatedFormat('l, n F Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive py-4 px-4">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush" id="datatable">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Hari</th>
                                <th scope="col">Jam</th>
                                <th scope="col">Nama MP</th>
                                <th scope="col">Ruangan</th>
                                <th scope="col">Nama Guru</th>
                                <th scope="col">Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="col">Hari</th>
                                <th scope="col">Jam</th>
                                <th scope="col">Nama MP</th>
                                <th scope="col">Ruangan</th>
                                <th scope="col">Nama Guru</th>
                                <th scope="col">Jurusan</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush

@push('scripts')
<script>
    var table = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('table.kbm') }}",
        columns: [
            {data: 'hari', name: 'hari', "sClass": "font-weight-bold text-center"},
            {data:  'jam_pelajaran', render: function ( data, type, row ) {
            return row.jam_masuk + ' - ' + row.jam_keluar}, "sClass": "font-weight-bold text-center"},
            {data: 'nama_mp', name: 'nama_mp', "sClass": "font-weight-bold text-default"},
            {data: 'kode_jurusan', name: 'kode_jurusan', visible: true, "sClass": "text-center"},
            {data: 'nama_ruangan', name: 'nama_ruangan', "sClass": "font-weight-bold text-center"},
            {data: 'nama', name: 'nama', "sClass": "font-weight-bold text-default"},
            // {data: 'kode_tahun_akademik', name: 'kode_tahun_akademik', "sClass": "font-weight-bold text-default"},
            // {data: 'semester', name: 'semester', visible: false, "sClass": "font-weight-bold text-default"},
            // {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        } 
        
    });
    
    $('#filter_jurusan').change(function () {
        table.column($(this).data('column'))
            .search($(this).val())
            .draw();
    });

    $('#filter_semester').change(function () {
        table.column($(this).data('column'))
            .search($(this).val())
            .draw();
    });

    $('#reset').click(function () {
        table.search('').columns().search('').draw();
        $("#filter_jurusan")[0].selectedIndex = 0
        $("#filter_semester")[0].selectedIndex = 0
    });

</script>

@endpush