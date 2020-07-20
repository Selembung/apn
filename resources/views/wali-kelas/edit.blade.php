@extends('layouts.app', [
'title' => 'Edit Wali Kelas',
'activePage' => 'wakel'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'wakel'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('wali-kelas') }}">Wali Kelas</a></li>
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
                        <h3 class="mb-0">Form Wali Kelas</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('wali-kelas/' . $wk->id) }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_rombel">Nama Rombel</label>
                                        @if (count($rombel) > 0)
                                        <select class="form-control @error('kode_rombel') is-invalid @enderror"
                                            id="kode_rombel" name="kode_rombel">
                                            @foreach ($rombel as $id => $m)
                                            <option value="{{ $id }}" {{ $id == $wk->kode_rombel ? 'selected' : '' }}>
                                                {{ $m }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('kode_rombel')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="alert alert-info alert-important" role="alert">
                                            <strong>Info!</strong> Rombel not yet available!
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_guru">Nama Wali Kelas</label>
                                        @if (count($teacher) > 0)
                                        <select class="form-control @error('kode_guru') is-invalid @enderror"
                                            id="kode_guru" name="kode_guru">
                                            @foreach ($teacher as $id => $m)
                                            <option value="{{ $id }}" {{ $id == $wk->kode_guru ? 'selected' : '' }}>
                                                {{ $m }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('kode_guru')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="alert alert-info alert-important" role="alert">
                                            <strong>Info!</strong> Waki Kelas not yet available!
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