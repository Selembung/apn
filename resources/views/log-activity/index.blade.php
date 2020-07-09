@extends('layouts.app', [
'title' => 'Log Aktivitas',
'activePage' => 'logActivity'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'logActivity'
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
                            <h3 class="mb-0">Log Aktivitas</h3>
                        </div>
                        {{-- <div class="col-6 text-right">
                            <a href="/log-activity/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add Log Aktivitas">
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
                                <th>No</th>
                                <th>Role</th>
                                <th>Nama User</th>
                                <th>Nama Aktivitas</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Nama User</th>
                                <th>Nama Aktivitas</th>
                                <th>Waktu</th>
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
    var table = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('table.log-activity') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'role', name: 'role', "sClass": "font-weight-bold text-default"},
            {data: 'name', name: 'name', "sClass": "font-weight-bold text-default"},
            {data: 'activity_name', name: 'activity_name'},
            {data: 'created_at', name: 'created_at'},
        ],
        "order": [[ 4, 'desc' ]],
    });

</script>

@endpush