@extends('layouts.app', [
'title' => 'Course',
'activePage' => 'course'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'course'
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
                            <h3 class="mb-0">Courses</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/course/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add Course">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-hover py-4 px-4">
                    <table class="table align-items-center table-flush" id="datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode MP</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Jumlah SKS</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode MP</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Jumlah SKS</th>
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
        ajax: "{{ route('table.course') }}",
        columns: [
            {data: 'kode_mp', name: 'kode_mp', "sClass": "font-weight-bold text-default"},
            {data: 'nama_mp', name: 'nama_mp'},
            {data: 'jumlah_sks', name: 'jumlah_sks', "sClass": "text-center"},
            {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        } 
    });

</script>

@endpush