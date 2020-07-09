@extends('layouts.app', [
'title' => 'Create Room',
'activePage' => 'room'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'room'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('room') }}">Room</a></li>
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
                        <h3 class="mb-0">Form Room</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('room') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label " for="kode_ruangan">Kode Ruangan</label>
                                        <input type="text"
                                            class="form-control @error('kode_ruangan') is-invalid @enderror"
                                            id="kode_ruangan" name="kode_ruangan" value="{{ old('kode_ruangan') }}">
                                        @error('kode_ruangan')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="form-control-label" for="_ruangan">Nama Ruangan</label>
                                        <input type="text"
                                            class="form-control  @error('nama_ruangan') is-invalid @enderror"
                                            id="nama_ruangan" name="nama_ruangan" value="{{ old('nama_ruangan') }}">
                                        @error('nama_ruangan')
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