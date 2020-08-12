@extends('layouts.app', [
'title' => 'Edit Course',
'activePage' => 'course'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'course'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('course') }}">Courses</a></li>
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
                        <h3 class="mb-0">Form Course</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('course/' . $course->kode_mp)  }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_mp">Kode Mata Pelajaran</label>
                                        <input type="text" class="form-control @error('kode_mp') is-invalid @enderror"
                                            id="kode_mp" name="kode_mp" value="{{ $course->kode_mp }}">
                                        @error('kode_mp')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nama_mp">Nama Pelajaran</label>
                                        <input type="text" class="form-control @error('nama_mp') is-invalid @enderror"
                                            id="nama_mp" name="nama_mp" value="{{ $course->nama_mp }}">
                                        @error('nama_mp')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="muatan">Muatan</label>
                                        <select class="form-control" id="muatan" name="muatan">
                                            <option disabled selected>-- Pilih Muatan --</option>
                                            <option value="A" {{ $course->muatan == "A" ? 'selected' : '' }}>
                                                Muatan Nasional</option>
                                            <option value="B" {{ $course->muatan == "B" ? 'selected' : '' }}>
                                                Muatan Kewilayahan</option>
                                            <option value="C" {{ $course->muatan == "C" ? 'selected' : '' }}>
                                                Muatan Peminatan Kejuruan</option>
                                        </select>
                                        @error('semester')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="jumlah_sks">Jumlah SKS</label>
                                        <input type="text"
                                            class="form-control @error('jumlah_sks') is-invalid @enderror"
                                            id="jumlah_sks" name="jumlah_sks" value="{{ $course->jumlah_sks }}">
                                        @error('jumlah_sks')
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