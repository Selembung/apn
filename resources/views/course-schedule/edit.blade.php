@extends('layouts.app', [
'title' => 'Edit Course Schedule',
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
                    <li class="breadcrumb-item"><a href="{{ url('course-schedule') }}">Course Schedules</a></li>
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
                        <h3 class="mb-0">Form Course Schedule</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('course-schedule/' . $courseSchedule->id)  }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_jurusan">Nama Jurusan</label>
                                        @if (count($major) > 0)
                                        <select class="form-control @error('kode_jurusan') is-invalid @enderror"
                                            id="kode_jurusan" name="kode_jurusan">
                                            @foreach ($major as $id => $m)
                                            <option value="{{ $id }}"
                                                {{ $id == $courseSchedule->kode_jurusan ? 'selected' : '' }}>{{ $m }}
                                            </option>
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
                                            @foreach ($ay as $id => $academic)
                                            <option value="{{ $id }}"
                                                {{ $id == $courseSchedule->kode_tahun_akademik ? 'selected' : '' }}>
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
                                            @foreach ($course as $id => $c)
                                            <option value="{{ $id }}"
                                                {{ $id == $courseSchedule->kode_mp ? 'selected' : '' }}>{{ $c }}
                                            </option>
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
                                            <option value="1" {{ $courseSchedule->semester == 1 ? 'selected' : '' }}>
                                                Semester 1</option>
                                            <option value="2" {{ $courseSchedule->semester == 2 ? 'selected' : '' }}>
                                                Semester 2</option>
                                            <option value="3" {{ $courseSchedule->semester == 3 ? 'selected' : '' }}>
                                                Semester 3</option>
                                            <option value="4" {{ $courseSchedule->semester == 4 ? 'selected' : '' }}>
                                                Semester 4</option>
                                            <option value="5" {{ $courseSchedule->semester == 5 ? 'selected' : '' }}>
                                                Semester 5</option>
                                            <option value="6" {{ $courseSchedule->semester == 6 ? 'selected' : '' }}>
                                                Semester 6</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="user_id">Nama Guru</label>
                                        @if (count($teacher) > 0)
                                        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id"
                                            name="user_id">
                                            @foreach ($teacher as $id => $u)
                                            <option value="{{ $id }}"
                                                {{ $id == $courseSchedule->user_id ? 'selected' : '' }}>
                                                {{ $u }}</option>
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
                                            @foreach ($room as $kode => $r)
                                            <option value="{{ $kode }}"
                                                {{ $kode == $courseSchedule->kode_ruangan ? 'selected' : '' }}>{{ $r }}
                                            </option>
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
                                            <option value="Senin"
                                                {{ $courseSchedule->hari == "Senin" ? 'selected' : '' }}>Senin</option>
                                            <option value="Selasa"
                                                {{ $courseSchedule->hari == "Selasa" ? 'selected' : '' }}>Selasa
                                            </option>
                                            <option value="Rabu"
                                                {{ $courseSchedule->hari == "Rabu" ? 'selected' : '' }}>Rabu</option>
                                            <option value="Kamis"
                                                {{ $courseSchedule->hari == "Kamis" ? 'selected' : '' }}>Kamis</option>
                                            <option value="Jumat"
                                                {{ $courseSchedule->hari == "Jumat" ? 'selected' : '' }}>Jumat</option>
                                            <option value="Sabtu"
                                                {{ $courseSchedule->hari == "Sabtu" ? 'selected' : '' }}>Sabtu</option>
                                            <option value="Minggu"
                                                {{ $courseSchedule->hari == "Minggu" ? 'selected' : '' }}>Minggu
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="jam">Jam</label>
                                        @if (count($ch) > 0)
                                        <select class="form-control @error('jam') is-invalid @enderror" id="jam"
                                            name="jam">
                                            @foreach ($ch as $id => $jam)
                                            <option value="{{ $loop->iteration }}" {{ $id = $loop->iteration }}
                                                {{ $id == $courseSchedule->jam ? 'selected' : '' }}>
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