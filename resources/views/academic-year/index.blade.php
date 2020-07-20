@extends('layouts.app', [
'title' => 'Academic Year',
'activePage' => 'academic-year'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'academic-year'
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
                            <h3 class="mb-0">Academic Years</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ url('academic-year/create') }}"
                                class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                                data-original-title="Add academic year">
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
                                <th>Kode Tahun Akademik</th>
                                <th>Tahun Akademik</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode Tahun Akademik</th>
                                <th>Tahun Akademik</th>
                                <th>Status</th>
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
        ajax: "{{ route('table.academic-year') }}",
        columns: [
            {data: 'kode_tahun_akademik', name: 'kode_tahun_akademik'},
            {data: 'tahun_akademik', name: 'tahun_akademik'},
            {data: 'status', name: 'status',  
            render: function(data) { 
                if(data === 'Aktif') {
                    return '<span class="badge badge-dot mr-4"><i class="bg-success"></i>' + data + '</span>' 
                }
                else {
                    return '<span class="badge badge-dot mr-4"><i class="bg-danger"></i>' + data + '</span>' 
                }
              },
            },
            {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        } 
    });
</script>

@endpush