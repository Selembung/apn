@extends('layouts.app', [
'title' => 'Room',
'activePage' => 'room'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'room'
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
                            <h3 class="mb-0">Room</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/room/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add Room">
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
                                <th>Kode Ruangan</th>
                                <th>Nama Ruangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode Ruangan</th>
                                <th>Nama Ruangan</th>
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
        ajax: "{{ route('table.room') }}",
        columns: [
            {data: 'kode_ruangan', name: 'kode_ruangan', "sClass": "font-weight-bold text-default"},
            {data: 'nama_ruangan', name: 'nama_ruangan'},
            {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        } 
    });
</script>

@endpush