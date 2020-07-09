@extends('layouts.app', [
'title' => 'Course Schedule',
'activePage' => 'course-schedule'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'course-schedule'
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
                            <a href="/course-schedule/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add Course Schedule">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-hover py-4 px-4">
                    <table class="table align-items-center table-flush" id="datatable">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="nama_jurusan">Nama Jurusan</label>
                                    @if (count($major) > 0)
                                    <select data-column="5" class="form-control" id="filter_jurusan">
                                        <option value="">-- Pilih Jurusan --</option>
                                        @foreach ($major as $key => $m)
                                        <option value="{{ ($m) }}">{{ $m }}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <div class="alert alert-info alert-important" role="alert">
                                        <strong>Info!</strong> Majors not yet available!
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="semester">Semester</label>
                                    <select data-column="6" class="form-control" id="filter_semester" name="semester">
                                        <option value="">-- Pilih Semester --</option>
                                        <option value="1">Semester 1</option>
                                        <option value="2">Semester 2</option>
                                        <option value="3">Semester 3</option>
                                        <option value="4">Semester 4</option>
                                        <option value="5">Semester 5</option>
                                        <option value="6">Semester 6</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-info" id="reset" style="margin-top: 32px">Reset
                                    Filter</button>
                            </div>

                            <thead class="thead-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Ruangan</th>
                                    <th>Guru</th>
                                    {{-- <th>Tahun Akademik</th> --}}
                                    <th>Jurusan</th>
                                    <th>Semester</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Ruangan</th>
                                    <th>Guru</th>
                                    {{-- <th>Tahun Akademik</th> --}}
                                    <th>Jurusan</th>
                                    <th>Semester</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </div>
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
        ajax: "{{ route('table.course-schedule') }}",
        columns: [
            {data: 'hari', name: 'hari'},
            {data:  'jam_pelajaran', render: function ( data, type, row ) {
            return row.jam_masuk + ' - ' + row.jam_keluar;}},
            {data: 'nama_mp', name: 'nama_mp', "sClass": "font-weight-bold text-default"},
            {data: 'nama_ruangan', name: 'nama_ruangan', "sClass": "font-weight-bold text-default"},
            {data: 'nama', name: 'nama', "sClass": "font-weight-bold text-default"},
            // {data: 'kode_tahun_akademik', name: 'kode_tahun_akademik', "sClass": "font-weight-bold text-default"},
            {data: 'nama_jurusan', name: 'nama_jurusan', visible: false, "sClass": "font-weight-bold text-default"},
            {data: 'semester', name: 'semester', visible: false, "sClass": "font-weight-bold text-default"},
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

    $('#filter_semester').change(function () {
        table.column($(this).data('column'))
            .search($(this).val())
            .draw();
    });

    $('#reset').click(function () {
        table.search('').columns().search('').draw();
        $("#filter_jurusan")[0].selectedIndex = 0
        $("#filter_semester")[0].selectedIndex = 0
    });

   

</script>

@endpush