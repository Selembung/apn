@extends('layouts.app', [
'title' => 'Kartu Rencana Studi',
'activePage' => 'krs'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'krs'
])
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-6">

            @include('alerts.alert')

            <div class="card shadow mb-5">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0">Kartu Rencana Studi</h3>
                        </div>
                        {{-- <div class="col-6 text-right">
                            <a href="/krs/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add KRS">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a>
                        </div> --}}
                    </div>
                </div>

                <div class="table-responsive table-hover py-4 px-4">
                    <table class="table align-items-center table-flush" id="datatable">
                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-control-label" for="nama_jurusan">Nama Jurusan</label>
                                    @if (count($major) > 0)
                                    <select data-column="4" class="form-control" id="filter_jurusan" disabled>
                                        <option value="">-- Pilih Jurusan --</option>
                                        @foreach ($major as $key => $m)
                                        <option value="{{ $key }}"
                                            {{ $key == $user[0]->kode_jurusan  ? 'selected' : '' }}>
                                            {{ $m }}</option>
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
                                    <select data-column="3" class="form-control" id="filter_semester" name="semester">
                                        <option value="">-- Pilih Semester --</option>
                                        <option value="1">Semester 1</option>
                                        <option value="2">Semester 2 </option>
                                        <option value="3">Semester 3</option>
                                        <option value="4">Semester 4</option>
                                        <option value="5">Semester 5</option>
                                        <option value="6">Semester 6</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info" id="reset" style="margin-top: 32px">Reset
                                    Filter</button>
                            </div>

                            <thead class="thead-light">
                                <tr>
                                    <th>Kode MP</th>
                                    <th>Mata Pelajaran</th>
                                    <th>SKS</th>
                                    <th>Semester</th>
                                    <th>Jurusan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Kode MP</th>
                                    <th>Mata Pelajaran</th>
                                    <th>SKS</th>
                                    <th>Semester</th>
                                    <th>Jurusan</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </div>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-6">

            @include('alerts.alert')

            <div class="card shadow mb-5">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0">Mata Pelajaran yang dipilih</h3>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-hover py-4 px-4">
                    <div id="list">

                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @push('scripts')
    <script>
        $(function() {
            var table = $('#datatable').DataTable({
                order: [ 3, "asc" ],
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('table.krs') }}",
                columns: [
                    {data: 'kode_mp', name: 'kode_mp'},
                    {data: 'nama_mp', name: 'nama_mp'},
                    {data: 'jumlah_sks', name: 'jumlah_sks'},
                    {data: 'semester', name: 'semester', visible: false},
                    {data: 'kode_jurusan', name: 'kode_jurusan', visible: false},
                    {data: 'action', name: 'action', "sClass": "text-center"},
                ],
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
            tampil_krs();

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
            $("#filter_semester")[0].selectedIndex = 0
        });

    });

    </script>

    <script>
        function tambah_krs(kode_mp) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.post("/krs/tambahKrs",
        {
          kode_mp : kode_mp,
          _token: CSRF_TOKEN
        },
        function(data, status){
        //   alert('berhasil');
        //   location.reload();
          tampil_krs();
        console.log(data);
      });
    }

    function tampil_krs(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.get("/krs/tampilKrs",
        {
          _token : CSRF_TOKEN
        },
        function(data, status){
            $("#list").html(data);
      });

    }

    function hapus_krs(id){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.post("/krs/hapusKrs",
        {
          id : id,
          _token: CSRF_TOKEN
        },
        function(data, status){
          tampil_krs();
      });
    }
    
    </script>

    @endpush