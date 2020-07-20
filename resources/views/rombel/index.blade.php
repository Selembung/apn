@extends('layouts.app', [
'title' => 'Rombel',
'activePage' => 'rombel'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'student'
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
                            <h3 class="mb-0">Rombel</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/rombel/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add rombel">
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
                                <th>Kode Rombel</th>
                                <th>Nama Rombel</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode Rombel</th>
                                <th>Nama Rombel</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card shadow mb-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0">Siswa & Rombel</h3>
                        </div>
                        <div class="col-6 text-right">
                            {{-- <a href="/rombel/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add rombel">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a> --}}
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="table-responsive table-hover px-3 ">
                            {{-- <form class="form-inline  pb-2 float-right" method="get" action="{{url('rombel')}}">
                            <input class="form-control mr-sm-2" type="text" name="q" placeholder="Kata Kunci"
                                aria-label="Search">
                            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Cari</button>
                            </form> --}}
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-hover px-3 pt-3 pb-3">
                    {{-- <form action="{{ url('/rombel/search') }}" method="get" id="form-pencarian">
                    <div class="form-group">
                        <label for="example-search-input" class="form-control-label">Search</label>
                        <input type="text" name="keyword" class="form-control" value="{{ old('keyword') }}"
                            autocomplete="off">
                    </div>
                    </form> --}}
                    {{-- <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari siswa"
                            autocomplete="off" />
                    </div> --}}
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-control-label" for="rombel">Rombel</label>
                            @if (count($rombel) > 0)
                            <select data-column="2" class="form-control" id="filter_rombel" name="rombel">
                                <option value=" " selected>-- Pilih Rombel --</option>
                                @foreach ($rombel as $m)
                                <option value="{{ $m->kode_rombel }}"
                                    {{ $m->kode_rombel == $list[0]->kode_rombel ? 'selected' : '' }}>
                                    {{ $m->kode_rombel }}
                                </option>
                                @endforeach
                            </select>
                            @else
                            <div class="alert alert-info alert-important" role="alert">
                                <strong>Info!</strong> Majors not yet available!
                            </div>
                            @endif
                        </div>
                    </div>
                    <table class="table align-items-center table-flush" id="datatable-student">
                        <thead class="thead-light">
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Rombel</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            {{-- @foreach ($list as $s)
                            <tr>
                                <th>{{ $s->nis }}</th>
                            <th>{{ $s->nama }}</th>
                            <th>
                                <select class="form-control @error(' rombel') is-invalid @enderror"
                                    onchange="simpan_rombel('{{ $s->nis }}')" id="rombel-{{ $s->nis }}" name="rombel">
                                    <option disabled selected>-- Pilih Rombel --</option>
                                    @foreach ($rombel as $m)
                                    <option value="{{ $m->kode_rombel }}"
                                        {{ $m->kode_rombel == $s->kode_rombel ? 'selected' : '' }}>
                                        {{ $m->kode_rombel }}
                                    </option>
                                    @endforeach
                                </select>
                            </th>
                            </tr>
                            @endforeach --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Rombel</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="float-right">
                        {{-- {{ $list->links() }} --}}
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
        ajax: "{{ route('table.rombel') }}",
        columns: [
            {data: 'kode_rombel', name: 'kode_rombel', "sClass": "font-weight-bold text-default"},
            {data: 'nama_rombel', name: 'nama_rombel', "sClass": "font-weight-bold text-default"},
            {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        } 
    });

    </script>

    <script>
        var table = $('#datatable-student').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('table.rombel-siswa') }}",
        columns: [
            {data: 'nis', name: 'nis', "sClass": "font-weight-bold text-default"},
            {data: 'nama', name: 'nama', "sClass": "font-weight-bold text-default"},
            {data: 'kode_rombel', name: 'kode_rombel', "sClass": "text-center", "defaultContent": "-"},
            {data: 'action', name: 'action', "sClass": "text-center"},
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        } 
    });

    $('#filter_rombel').change(function () {
        table.column($(this).data('column'))
            .search($(this).val())
            .draw();
    });

    </script>

    <script>
        function simpan_rombel(nis) {
        var rombel = $('#rombel-' + nis).val();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.post("/student/update_rombel/update",
        {
            nis : nis,
            rombel : rombel,
            _token: CSRF_TOKEN
        },

        function(data, status){
        //   alert('sukses')   
        });
    }

    </script>

    {{-- <script>
        $(document).ready(function(){

        fetch_customer_data();

        function fetch_customer_data(query = '')
        {
            $.ajax({
                url:"{{ route('rombel.search') }}",
    method:'GET',
    data:{query:query},
    dataType:'json',
    success:function(data)
    {
    $('tbody.list').html(data.table_data);
    // $('#total_records').text(data.total_data);
    }
    })
    }
    $(document).on('keyup', '#search', function(){
    var query = $(this).val();
    fetch_customer_data(query);
    });
    });
    </script> --}}

    @endpush