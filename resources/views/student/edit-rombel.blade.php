@extends('layouts.app', [
'title' => 'Edit Rombel Siswa',
'activePage' => 'student'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'student'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('rombel') }}">Rombel</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form Edit</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- End Breadcumb --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card-wrapper">
                <!-- Form controls -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Form Rombel Siswa</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('student/' . $student->nis) }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nama">Nama siswa</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ $student->nama }}" disabled>
                                        @error('nama')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_rombel">Kode Rombel</label>
                                        <tr>
                                            <th>
                                                <select class="form-control @error('kode_rombel') is-invalid @enderror"
                                                    onchange="simpan_rombel('{{ $student->nis }}')"
                                                    id="rombel-{{ $student->nis }}" name="kode_rombel">
                                                    <option disabled selected>-- Pilih Rombel --</option>
                                                    @foreach ($rombel as $m)
                                                    <option value="{{ $m->kode_rombel }}"
                                                        {{ $m->kode_rombel == $student->kode_rombel ? 'selected' : '' }}>
                                                        {{ $m->kode_rombel }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </th>
                                        </tr>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
        swal("Selamat!", "Rombel siswa berhasil diperbaharui!", "success"); 
    });
}

</script>