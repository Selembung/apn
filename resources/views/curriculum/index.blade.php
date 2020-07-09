@extends('layouts.app', [
'title' => 'Curriculum',
'activePage' => 'curriculum'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'curriculum'
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
                            <h3 class="mb-0">Curriculum</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/curriculum/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add curriculum">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-hover px-3 pt-3 pb-3">
                    <table class="table align-items-center table-flush" id="datatable">
                        <div class="form-group">
                            <label class="form-control-label" for="kode_jurusan">Jurusan</label>
                            <div class="input-group mb-4">
                                @if (count($major) > 0)
                                <select data-column="0" class="form-control" id="filter_jurusan">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($major as $key => $m)
                                    <option value="{{ ($key) }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-info" id="reset">Reset
                                    Filter</button>
                                @else
                                <div class="alert alert-info alert-important" role="alert">
                                    <strong>Info!</strong> Majors not yet available!
                                </div>
                                @endif
                            </div>
                        </div>
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Jurusan</th>
                                <th>Kode MP</th>
                                <th>Nama MP</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode Jurusan</th>
                                <th>Kode MP</th>
                                <th>Nama MP</th>
                                <th>SKS</th>
                                <th>Semester</th>
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
    var table = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('table.curriculum') }}",
        columns: [
            {data: 'kode_jurusan', name: 'kode_jurusan', "sClass": "font-weight-bold text-default"},
            {data: 'kode_mp', name: 'kode_mp', "sClass": "text-center"},    
            {data: 'nama_mp', name: 'nama_mp'},
            {data: 'jumlah_sks', name: 'jumlah_sks', "sClass": "text-center"},
            {data: 'semester', name: 'semester', "sClass": "text-center"},
            {data: 'action', name: 'action', "sClass": "text-center"},
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

    $('#reset').click(function () {
        table.column($(this).data(''))
            .search($(this).val())
            .draw();
            $("#filter_jurusan")[0].selectedIndex = 0
    });

</script>

@endpush