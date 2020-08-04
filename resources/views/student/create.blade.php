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
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label " for="nisn">NISN</label>
                                        <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                            id="nisn" name="nisn" value="{{ old('nisn') }}">
                                        @error('nisn')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nama">Nama Siswa</label>
                                        <input type="text" class="form-control  @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text"
                                            class="form-control  @error('tempat_lahir') is-invalid @enderror"
                                            id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                        @error('tempat_lahir')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-control-label" for="tanggal_lahir">Tanggal
                                        Lahir</label>
                                    <div class="input-daterange datepicker row align-items-center">
                                        <div class="col">
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="ni ni-calendar-grid-58"></i></span>
                                                    </div>
                                                    <input
                                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                        placeholder="Pilih Tanggal Lahir" type="text"
                                                        name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                                </div>
                                                @error('tanggal_lahir')
                                                <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="jenis_kelamin">Jenis
                                            Kelamin</label>
                                        <div class="pt-2">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="jenis_kelamin" name="jenis_kelamin"
                                                    class="custom-control-input @error('jenis_kelamin') is-invalid @enderror"
                                                    value="L"
                                                    {{ old('jenis_kelamin') == "L" ? 'checked=' .'"'.'checked'.'"' : '' }}>
                                                <label class="custom-control-label" for="jenis_kelamin">Laki -
                                                    laki</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="jenis_kelamin2" name="jenis_kelamin"
                                                    class="custom-control-input @error('jenis_kelamin') is-invalid @enderror"
                                                    value="P"
                                                    {{ old('jenis_kelamin') == "P" ? 'checked=' .'"'.'checked'.'"' : '' }}>
                                                <label class="custom-control-label"
                                                    for="jenis_kelamin2">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="agama">Agama</label>
                                        <select class="form-control @error('agama') is-invalid @enderror" id="agama"
                                            name="agama">
                                            <option disabled selected>-- Pilih Agama --</option>
                                            <option value="Islam" {{ old('agama') == "Islam" ? 'selected' : '' }}>
                                                Islam</option>
                                            <option value="Protestan"
                                                {{ old('agama') == "Protestan" ? 'selected' : '' }}>
                                                Protestan</option>
                                            <option value="Katolik" {{ old('agama') == "Katolik" ? 'selected' : '' }}>
                                                Katolik</option>
                                            <option value="Hindu" {{ old('agama') == "Hindu" ? 'selected' : '' }}>Hindu
                                            </option>
                                            <option value="Budha" {{ old('agama') == "Budha" ? 'selected' : '' }}>Budha
                                            </option>
                                            <option value="Khong Hu Cu"
                                                {{ old('agama') == "Khong Hu Cu" ? 'selected' : '' }}>
                                                Khong Hu Cu</option>
                                            <option value="Lainnya" {{ old('agama') == "Lainnya" ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                        @error('agama')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
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
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-control-label" for="alamat">Alamat</label>
                                        <input type="text" class="form-control  @error('alamat') is-invalid @enderror"
                                            id="alamat" name="alamat" value="{{ old('alamat') }}">
                                        @error('alamat')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_jurusan">Nama Jurusan</label>
                                        @if (count($major) > 0)
                                        <select class="form-control @error('kode_jurusan') is-invalid @enderror"
                                            id="kode_jurusan" name="kode_jurusan">
                                            <option disabled selected>-- Pilih Jurusan --</option>
                                            @foreach ($major as $id => $m)
                                            <option value="
                                            {{ $id }}" {{ old('kode_jurusan') == $id ? 'selected' : '' }}>
                                                {{ $m }}</option>
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
                                        <label class="form-control-label" for="kode_tahun_akademik">Tahun
                                            Akademik</label>
                                        @if (count($academic) > 0)
                                        <select class="form-control @error('kode_tahun_akademik') is-invalid @enderror"
                                            id="kode_tahun_akademik" name="kode_tahun_akademik">
                                            <option disabled selected>-- Pilih Tahun Akademik --</option>
                                            @foreach ($academic as $id => $m)
                                            <option value="{{ $id }}"
                                                {{ old('kode_tahun_akademik') == $id ? 'selected' : '' }}>{{ $m }}
                                            </option>
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
                                        <label class="form-control-label" for="semester_aktif">Semester
                                            Aktif</label>
                                        <select class="form-control" id="semester_aktif" name="semester_aktif">
                                            <option disabled selected>-- Pilih Semester --</option>
                                            <option value="1" {{ old('semester_aktif') == "1" ? 'selected' : '' }}>
                                                Semester 1</option>
                                            <option value="2" {{ old('semester_aktif') == "2" ? 'selected' : '' }}>
                                                Semester 2</option>
                                            <option value="3" {{ old('semester_aktif') == "3" ? 'selected' : '' }}>
                                                Semester 3</option>
                                            <option value="4" {{ old('semester_aktif') == "4" ? 'selected' : '' }}>
                                                Semester 4</option>
                                            <option value="5" {{ old('semester_aktif') == "5" ? 'selected' : '' }}>
                                                Semester 5</option>
                                            <option value="6" {{ old('semester_aktif') == "6" ? 'selected' : '' }}>
                                                Semester 6</option>
                                        </select>
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