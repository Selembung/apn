@extends('layouts.app', [
'title' => 'Edit Rombel',
'activePage' => 'rombel'
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
                        <h3 class="mb-0">Form Rombel</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('rombel/' . $rombel->kode_rombel) }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_rombel">Kode Rombel</label>
                                        <input type="text"
                                            class="form-control @error('kode_rombel') is-invalid @enderror"
                                            id="kode_rombel" name="kode_rombel" value="{{ $rombel->kode_rombel }}">
                                        @error('kode_rombel')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nama_rombel">Nama Rombel</label>
                                        <input type="text"
                                            class="form-control @error('nama_rombel') is-invalid @enderror"
                                            id="nama_rombel" name="nama_rombel" value="{{ $rombel->nama_rombel }}">
                                        @error('nama_rombel')
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