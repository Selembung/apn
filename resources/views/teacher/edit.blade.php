@extends('layouts.app', [
'title' => 'Edit Teacher',
'activePage' => 'teacher'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'teacher'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('teacher') }}">Teacher</a></li>
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
                        <h3 class="mb-0">Form Teacher</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('teacher/' . $teacher->nig) }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nig">NIG</label>
                                        <input type="text" class="form-control @error('nig') is-invalid @enderror"
                                            id="nig" name="nig" value="{{ $teacher->nig }}">
                                        @error('nig')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_guru">Kode Guru</label>
                                        <input type="text" class="form-control @error('kode_guru') is-invalid @enderror"
                                            id="kode_guru" name="kode_guru" value="{{ $teacher->kode_guru }}">
                                        @error('kode_guru')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nama">Nama Guru</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ $teacher->nama }}">
                                        @error('nama')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="no_telepon">No. Telepon</label>
                                        <input type="text"
                                            class="form-control @error('no_telepon') is-invalid @enderror"
                                            id="no_telepon" name="no_telepon" value="{{ $teacher->no_telepon }}">
                                        @error('no_telepon')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">E-mail</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ $teacher->email }}">
                                        @error('email')
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