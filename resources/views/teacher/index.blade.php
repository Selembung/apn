@extends('layouts.app', [
'title' => 'Teacher',
'activePage' => 'teacher'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'teacher'
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
                            <h3 class="mb-0">Guru</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/teacher/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add teacher">
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
                                <th>NIG</th>
                                <th>Nama Guru</th>
                                <th>Kode Guru</th>
                                <th>No. Telepon</th>
                                <th>E-mail</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>NIG</th>
                                <th>Nama Guru</th>
                                <th>Kode Guru</th>
                                <th>No. Telepon</th>
                                <th>E-mail</th>
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
        ajax: "{{ route('table.teacher') }}",
        columns: [
            {data: 'nig', name: 'nig', "sClass": "font-weight-bold text-default"},
            {data: 'nama', name: 'nama'},
            {data: 'kode_guru', name: 'kode_guru'},
            {data: 'no_telepon', name: 'no_telepon'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        } 
    });
</script>

@endpush