@extends('layouts.app', [
'title' => 'Create Course Schedule',
'activePage' => 'course-schedule'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'course-schedule'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('course-schedule') }}">Course Schedule</a></li>
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
                        <h3 class="mb-0">Form Course</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('course-schedule') }}" method="post">
                            @csrf
                            <div class=" row">
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
                                        <label class="form-control-label" for="kode_tahun_akademik">Tahun
                                            Akademik</label>
                                        @if (count($ay) > 0)
                                        <select class="form-control @error('kode_tahun_akademik') is-invalid @enderror"
                                            id="kode_tahun_akademik" name="kode_tahun_akademik">
                                            <option disabled selected>-- Pilih Tahun Akademik --</option>
                                            @foreach ($ay as $id => $academic)
                                            <option value="{{ $id }}">
                                                {{ $academic }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_tahun_akademik')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="alert alert-info alert-important" role="alert">
                                            <strong>Info!</strong> Academic Year not yet available!
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_mp">Nama Pelajaran</label>
                                        @if (count($course) > 0)
                                        <select class="form-control @error('kode_mp') is-invalid @enderror" id="kode_mp"
                                            name="kode_mp">
                                            <option disabled selected>-- Pilih Pelajaran --</option>
                                            @foreach ($course as $id => $c)
                                            <option value="{{ $id }}">{{ $c }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_mp')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="alert alert-info alert-important" role="alert">
                                            <strong>Info!</strong> Courses not yet available!
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="semester">Semester</label>
                                        <select class="form-control" id="semester" name="semester">
                                            <option disabled selected>-- Pilih Semester --</option>
                                            <option value="1">Semester 1</option>
                                            <option value="2">Semester 2</option>
                                            <option value="3">Semester 3</option>
                                            <option value="4">Semester 4</option>
                                            <option value="5">Semester 5</option>
                                            <option value="6">Semester 6</option>
                                        </select>
                                        @error('semester')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="user_id">Nama Guru</label>
                                        @if (count($teacher) > 0)
                                        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id"
                                            name="user_id">
                                            <option disabled selected>-- Pilih Pengajar --</option>
                                            @foreach ($teacher as $id => $u)
                                            <option value="{{ $id }}">{{ $u }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="alert alert-info alert-important" role="alert">
                                            <strong>Info!</strong> Teacher not yet available!
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_ruangan">Ruangan</label>
                                        @if (count($room) > 0)
                                        <select class="form-control @error('kode_ruangan') is-invalid @enderror"
                                            id="kode_ruangan" name="kode_ruangan">
                                            <option disabled selected>-- Pilih Ruangan --</option>
                                            @foreach ($room as $kode => $r)
                                            <option value="{{ $kode }}">{{ $r }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_ruangan')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="alert alert-info alert-important" role="alert">
                                            <strong>Info!</strong> Room not yet available!
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="hari">Hari</label>
                                        <select class="form-control" id="hari" name="hari">
                                            <option disabled selected>-- Pilih Hari --</option>
                                            <option value="Senin">Senin</option>
                                            <option value="Selasa">Selasa</option>
                                            <option value="Rabu">Rabu</option>
                                            <option value="Kamis">Kamis</option>
                                            <option value="Jumat">Jumat</option>
                                            <option value="Sabtu">Sabtu</option>
                                            <option value="Sabtu">Sabtu</option>
                                            <option value="Minggu">Minggu</option>
                                        </select>
                                        @error('hari')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="jam">Jam</label>
                                        @if (count($ch) > 0)
                                        <select class="form-control @error('jam') is-invalid @enderror" id="jam"
                                            name="jam">
                                            <option disabled selected>-- Pilih Jam --</option>
                                            @foreach ($ch as $id => $jam)
                                            <option value="{{ $loop->iteration }}">
                                                {{ $jam->jam_masuk . ' - ' . $jam->jam_keluar }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('jam')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="alert alert-info alert-important" role="alert">
                                            <strong>Info!</strong> Room not yet available!
                                        </div>
                                        @endif
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