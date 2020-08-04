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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="nama_jurusan">Tanggal</label>
                                    <div class="input-daterange datepicker row align-items-center">
                                        <div class="col">
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="ni ni-calendar-grid-58"></i></span>
                                                    </div>
                                                    <input data-column="4" class="form-control datepicker"
                                                        placeholder="Search date" type="text" id="from_date"
                                                        name="from_date" value="{{ old('from_date') }}"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Nama User</th>
                                <th>Nama Aktivitas</th>
                                <th>Waktu</th>
                                <th>Waktu Terakhir</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Nama User</th>
                                <th>Nama Aktivitas</th>
                                <th>Waktu</th>
                                <th>Waktu Terakhir</th>
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
        ajax: { 
            url: '{{ route("table.log-activity") }}',
            // data:{from_date:from_date, to_date:to_date}
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'role', name: 'role', "sClass": "font-weight-bold text-default"},
            {data: 'name', name: 'name', "sClass": "font-weight-bold text-default"},
            {data: 'activity_name', name: 'activity_name'},
            {data: 'created_at', name: 'created_at', "sClass": "text-center"},
            {data: 'waktuTerakhir', name: 'waktuTerakhir', "sClass": "text-center"},
        ],
        "order": [[ 4, 'desc' ]],
    });

    $('#from_date').change(function () {
        table.column($(this).data('column'))
            .search($(this).val())
            .draw();
            
    });

    $('.datepicker').datepicker({
    format: "yyyy-mm-dd"
    });

</script>

@endpush