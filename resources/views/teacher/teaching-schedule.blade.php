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
                            <h3 class="mb-0">Jadwal Mengajar</h3>
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
                                <th>Semester</th>
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
                                <th>Semester</th>
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
    $('#datatable tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );

    $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('table.teachingSchedule') }}",
        columns: [
            {data: 'hari', name: 'hari', "sClass": "font-weight-bold text-default"},
            {data: 'jam', render: function ( data, type, row ) {
            return row.jam_masuk + ' - ' + row.jam_keluar;}},
            {data: 'nama_mp', name: 'courses.nama_mp'},
            {data: 'semester', name: 'semester'},
            {data: 'nama_ruangan', name: 'rooms.nama_ruangan'},
            {data: 'nama_jurusan', name: 'majors.nama_jurusan'},
            {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        } 
        
    });
</script>

@endpush