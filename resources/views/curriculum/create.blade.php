@extends('layouts.app', [
'title' => 'Create Curriculum',
'activePage' => 'curriculum'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'curriculum'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('curriculum') }}">Curriculum</a></li>
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
                        <h3 class="mb-0">Form Curriculum Data</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('curriculum') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_jurusan">Nama Jurusan</label>
                                        @if (count($major) > 0)
                                        <select class="form-control @error('kode_jurusan') is-invalid @enderror"
                                            id="kode_jurusan" name="kode_jurusan">
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
                                        <label class="form-control-label" for="kode_mp">Nama Pelajaran</label>
                                        @if (count($course) > 0)
                                        <select class="form-control @error('kode_mp') is-invalid @enderror" id="kode_mp"
                                            name="kode_mp">
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
                                            <option value="1">Semester 1</option>
                                            <option value="2">Semester 2</option>
                                            <option value="3">Semester 3</option>
                                            <option value="4">Semester 4</option>
                                            <option value="5">Semester 5</option>
                                            <option value="6">Semester 6</option>
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