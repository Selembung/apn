@extends('layouts.app', [
'title' => 'Create Major',
'activePage' => 'major'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'major'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('major') }}">Major</a></li>
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
                        <h3 class="mb-0">Form Major</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('major') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label " for="kode_jurusan">Kode Jurusan</label>
                                        <input type="text"
                                            class="form-control @error('kode_jurusan') is-invalid @enderror"
                                            id="kode_jurusan" name="kode_jurusan" value="{{ old('kode_jurusan') }}">
                                        @error('kode_jurusan')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="form-control-label" for="_jurusan">Nama Jurusan</label>
                                        <input type="text"
                                            class="form-control  @error('nama_jurusan') is-invalid @enderror"
                                            id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan') }}">
                                        @error('nama_jurusan')
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