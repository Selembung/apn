@extends('layouts.app', [
'title' => 'Create Student',
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
                    <li class="breadcrumb-item"><a href="{{ url('student') }}">Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form</li>
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
                        <h3 class="mb-0">Form Student</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('student') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label " for="nis">NIS</label>
                                        <input type="text" class="form-control @error('nis') is-invalid @enderror"
                                            id="nis" name="nis" value="{{ old('nis') }}">
                                        @error('nis')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nama">Nama Siswa</label>
                                        <input type="text" class="form-control  @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_jurusan">Nama Jurusan</label>
                                        @if (count($major) > 0)
                                        <select class="form-control @error('kode_jurusan') is-invalid @enderror"
                                            id="kode_jurusan" name="kode_jurusan">
                                            <option disabled selected>-- Pilih Jurusan --</option>
                                            @foreach ($major as $id => $m)
                                            <option value="{{ $id }}">{{ $m }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_jurusan')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="alert alert-info alert-important" role="alert">
                                            <strong>Info!</strong> Majors not yet available!
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email</label>
                                        <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}">
                                        @error('email')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_tahun_akademik">Tahun
                                            Akademik</label>
                                        @if (count($academic) > 0)
                                        <select class="form-control @error('kode_tahun_akademik') is-invalid @enderror"
                                            id="kode_tahun_akademik" name="kode_tahun_akademik">
                                            <option disabled selected>-- Pilih Tahun Akademik --</option>
                                            @foreach ($academic as $id => $m)
                                            <option value="{{ $id }}">{{ $m }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_tahun_akademik')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="alert alert-info alert-important" role="alert">
                                            <strong>Info!</strong> Majors not yet available!
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="semester_aktif">Semester Aktif</label>
                                        <select class="form-control" id="semester_aktif" name="semester_aktif">
                                            <option disabled selected>-- Pilih Semester --</option>
                                            <option value="1">Semester 1</option>
                                            <option value="2">Semester 2</option>
                                            <option value="3">Semester 3</option>
                                            <option value="4">Semester 4</option>
                                            <option value="5">Semester 5</option>
                                            <option value="6">Semester 6</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="password">Password</label>
                                        <input type="password"
                                            class="form-control  @error('password') is-invalid @enderror" id="password"
                                            name="password" value="{{ old('password') }}">
                                @error('password')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="alamat">Alamat</label>
                            <input type="text" class="form-control  @error('alamat') is-invalid @enderror" id="alamat"
                                name="alamat" value="{{ old('alamat') }}">
                            @error('alamat')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>


@endsection