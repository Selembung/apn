@extends('layouts.app', [
'title' => 'Course Hour',
'activePage' => 'course-hour'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'course-hour'
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
                            <h3 class="mb-0">Course Hours</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/course-hour/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add Course Hour">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-hover px-3 pt-3 pb-3">
                    <table class="table align-items-center table-flush" id="datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Jam Pelajaran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Jam Pelajaran</th>
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
        ajax: "{{ route('table.course-hour') }}",
        columns: [
            {data: 'id_jam', name: 'id_jam', "sClass": "font-weight-bold text-default"},
            // {data: 'jam_masuk', name: 'jam_masuk'},
            // {data: 'jam_keluar', name: 'jam_keluar'},
            {data:  'jam_pelajaran', render: function ( data, type, row ) {
            return row.jam_masuk + ' - ' + row.jam_keluar;}},
            {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        } 
    });
</script>

@endpush