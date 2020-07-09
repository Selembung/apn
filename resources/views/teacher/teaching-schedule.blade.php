@extends('layouts.app', [
'title' => 'Teaching Schedule',
'activePage' => 'teachingSchedule'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'teachingSchedule'
])

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">

            @include('alerts.alert')

            <div class="card shadow mb-5">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0">Teaching Schedule</h3>
                        </div>
                        {{-- <div class="col-6 text-right">
                            <a href="/teaching-schedule/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add Teaching Schedule">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a>
                        </div> --}}
                    </div>
                </div>

                <div class="table-responsive table-hover px-3 pt-3 pb-3">
                    <table class="table align-items-center table-flush" id="datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Mata Pelajaran</th>
                                <th>Ruangan</th>
                                <th>Jurusan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Mata Pelajaran</th>
                                <th>Ruangan</th>
                                <th>Jurusan</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('table.teachingSchedule') }}",
        columns: [
            {data: 'hari', name: 'hari', "sClass": "font-weight-bold text-default"},
            {data: 'jam', render: function ( data, type, row ) {
            return row.jam_masuk + ' - ' + row.jam_keluar;}},
            {data: 'nama_mp', name: 'kode_mp'},
            {data: 'nama_ruangan', name: 'kode_ruangan'},
            {data: 'nama_jurusan', name: 'kode_jurusan'},
            {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        } 
    });
</script>

@endpush